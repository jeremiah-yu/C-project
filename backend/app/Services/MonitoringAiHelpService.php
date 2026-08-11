<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class MonitoringAiHelpService
{
    public function __construct(
        private readonly EarlyWarningService $earlyWarningService,
    ) {
    }

    public function isLiveAiConfigured(): bool
    {
        $provider = config('ai.provider');

        if ($provider === 'ollama') {
            return true;
        }

        return filled(config('ai.api_key'));
    }

    /**
     * @return array{source: string, provider: string, summary: string, advice: string, actions: list<string>, prevention_note: string}
     */
    public function generateHelp(int $studentId, ?string $question = null): array
    {
        $assessment = $this->earlyWarningService->assessByStudentId($studentId);

        if (! $assessment) {
            return [
                'source' => 'none',
                'provider' => 'none',
                'summary' => 'No grade record found.',
                'advice' => 'This student has no approved grades to analyze yet.',
                'actions' => ['Wait for grade releases, then reopen AI Help.'],
                'prevention_note' => 'AI Help needs grade data before it can coach a student.',
            ];
        }

        $prompt = $this->buildPrompt($assessment, $question);

        if ($this->isLiveAiConfigured()) {
            try {
                $raw = $this->callProvider($prompt);

                return $this->parseAiResponse($raw, $assessment, true);
            } catch (Throwable $exception) {
                Log::warning('Monitoring AI provider failed; using CDM coach fallback.', [
                    'message' => $exception->getMessage(),
                ]);
            }
        }

        return $this->coachFallback($assessment, $question);
    }

    /**
     * @param  array<string, mixed>  $assessment
     */
    private function buildPrompt(array $assessment, ?string $question): string
    {
        $subjects = collect($assessment['subjects'] ?? [])->map(function (array $subject) {
            return sprintf(
                '%s (%s): Prelim=%s, Midterm=%s, Final=%s, avg=%s, risk=%s',
                $subject['subject_code'],
                $subject['subject_name'],
                $subject['periods']['Prelim'] ?? 'n/a',
                $subject['periods']['Midterm'] ?? 'n/a',
                $subject['periods']['Final'] ?? 'n/a',
                $subject['average_grade'] ?? 'n/a',
                $subject['risk_label'],
            );
        })->implode("\n");

        $questionLine = $question
            ? "Student/adviser question: {$question}"
            : 'Provide proactive coaching even if no specific question was asked.';

        return <<<PROMPT
You are CDM Portal AI Help, an academic early-warning coach for Colegio de Montalban.
Be practical, kind, and specific. Focus on preventing failing grades.

Student: {$assessment['student_name']} ({$assessment['student_number']})
Course: {$assessment['course_code']}
Overall risk: {$assessment['risk_label']}
Trend: {$assessment['trend_label']}
Average grade: {$assessment['average_grade']}
Warnings:
- {$this->joinLines($assessment['warnings'] ?? [])}

Subjects:
{$subjects}

{$questionLine}

Respond in JSON only with keys:
summary (string),
advice (string, 2-4 short paragraphs),
actions (array of 4-7 concrete next steps),
prevention_note (string).
PROMPT;
    }

    /**
     * @param  list<string>  $lines
     */
    private function joinLines(array $lines): string
    {
        return implode("\n- ", $lines ?: ['None']);
    }

    private function callProvider(string $prompt): string
    {
        return match (config('ai.provider')) {
            'openai' => $this->callOpenAiCompatible($prompt),
            'ollama' => $this->callOllama($prompt),
            default => $this->callGemini($prompt),
        };
    }

    private function callGemini(string $prompt): string
    {
        $model = config('ai.model', 'gemini-2.5-flash');
        $key = config('ai.api_key');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$key}";

        $response = $this->http()
            ->acceptJson()
            ->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.4,
                    'responseMimeType' => 'application/json',
                ],
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException('Gemini request failed: '.$response->body());
        }

        return (string) data_get($response->json(), 'candidates.0.content.parts.0.text', '');
    }

    private function callOpenAiCompatible(string $prompt): string
    {
        $response = $this->http()
            ->withToken((string) config('ai.api_key'))
            ->acceptJson()
            ->post(rtrim((string) config('ai.openai_base_url'), '/').'/chat/completions', [
                'model' => config('ai.model', 'gpt-4o-mini'),
                'temperature' => 0.4,
                'response_format' => ['type' => 'json_object'],
                'messages' => [
                    ['role' => 'system', 'content' => 'You are CDM Portal AI Help. Reply with JSON only.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException('OpenAI request failed: '.$response->body());
        }

        return (string) data_get($response->json(), 'choices.0.message.content', '');
    }

    private function callOllama(string $prompt): string
    {
        $response = $this->http()
            ->acceptJson()
            ->post(rtrim((string) config('ai.ollama_base_url'), '/').'/api/chat', [
                'model' => config('ai.model', 'llama3.2'),
                'stream' => false,
                'format' => 'json',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are CDM Portal AI Help. Reply with JSON only.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException('Ollama request failed: '.$response->body());
        }

        return (string) data_get($response->json(), 'message.content', '');
    }

    private function http()
    {
        return Http::timeout(config('ai.timeout', 45))
            ->withOptions([
                'verify' => (bool) config('ai.verify_ssl', true),
            ]);
    }

    /**
     * @param  array<string, mixed>  $assessment
     * @return array{source: string, provider: string, summary: string, advice: string, actions: list<string>, prevention_note: string}
     */
    private function parseAiResponse(string $raw, array $assessment, bool $live): array
    {
        $cleaned = trim($raw);
        $cleaned = preg_replace('/^```json\s*|\s*```$/', '', $cleaned) ?? $cleaned;
        $decoded = json_decode($cleaned, true);

        if (! is_array($decoded)) {
            return $this->coachFallback($assessment, null);
        }

        $actions = $decoded['actions'] ?? [];
        if (! is_array($actions)) {
            $actions = [];
        }

        return [
            'source' => $live ? 'live-ai' : 'cdm-coach',
            'provider' => $live ? (string) config('ai.provider') : 'cdm-coach',
            'summary' => (string) ($decoded['summary'] ?? $assessment['headline']),
            'advice' => (string) ($decoded['advice'] ?? ''),
            'actions' => array_values(array_filter(array_map('strval', $actions))),
            'prevention_note' => (string) ($decoded['prevention_note'] ?? ''),
        ];
    }

    /**
     * Conversational offline coach used when no AI key / provider is available.
     *
     * @param  array<string, mixed>  $assessment
     * @return array{source: string, provider: string, summary: string, advice: string, actions: list<string>, prevention_note: string}
     */
    private function coachFallback(array $assessment, ?string $question): array
    {
        $support = $this->earlyWarningService->generateSupportPlan($assessment);
        $risky = collect($assessment['subjects'] ?? [])
            ->filter(fn (array $subject) => in_array($subject['risk_level'], ['high', 'moderate'], true))
            ->pluck('subject_code')
            ->all();

        $focus = $risky ? implode(', ', $risky) : 'your heaviest subjects';
        $questionBit = $question
            ? "About your question (“{$question}”): focus first on {$focus}, because those grades drive the current {$assessment['risk_label']} signal."
            : "I reviewed {$assessment['student_name']}'s grade pattern and the biggest leverage is {$focus}.";

        $advice = <<<TEXT
{$questionBit}

Current standing: {$assessment['risk_label']} with a {$assessment['trend_label']} trend (average {$assessment['average_grade']}).
Treat this as an early-warning coach: protect passing marks now, then rebuild confidence subject by subject.

Use short daily blocks (45–90 minutes) on weak topics, ask your professor one clarifying question this week, and track every quiz result so the next midterm/final does not surprise you.
TEXT;

        return [
            'source' => 'cdm-coach',
            'provider' => 'cdm-coach',
            'summary' => $support['summary'],
            'advice' => trim($advice),
            'actions' => $support['actions'],
            'prevention_note' => $support['prevention_note'].' Tip: add GEMINI_API_KEY or OPENAI_API_KEY in backend/.env to enable live LLM AI Help.',
        ];
    }
}
