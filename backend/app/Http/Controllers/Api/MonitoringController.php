<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Student;
use App\Services\EarlyWarningService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function __construct(private readonly EarlyWarningService $earlyWarningService)
    {
    }

    public function earlyWarnings(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->loadMissing('role');

        if ($user->role?->role_name === Role::STUDENT) {
            return response()->json([
                'success' => true,
                'message' => 'Personal early-warning assessment loaded.',
                'data' => $this->earlyWarningService->assessForUserId($user->id),
            ]);
        }

        $professorUserId = $user->role?->role_name === Role::PROFESSOR ? $user->id : null;

        return response()->json([
            'success' => true,
            'message' => 'Early-warning overview loaded.',
            'data' => $this->earlyWarningService->overview($professorUserId),
        ]);
    }

    public function myRisk(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->loadMissing('role');

        if ($user->role?->role_name !== Role::STUDENT) {
            return response()->json([
                'success' => false,
                'message' => 'Only student accounts can load personal risk dashboards.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Personal early-warning assessment loaded.',
            'data' => $this->earlyWarningService->assessForUserId($user->id),
        ]);
    }

    public function supportPlan(Request $request, int $student): JsonResponse
    {
        $user = $request->user();
        $user->loadMissing('role');

        if ($user->role?->role_name === Role::STUDENT) {
            $owned = Student::query()->where('user_id', $user->id)->where('id', $student)->exists();
            if (! $owned) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only generate a support plan for your own record.',
                ], 403);
            }
        }

        $assessment = $this->earlyWarningService->assessByStudentId($student);

        if (! $assessment) {
            return response()->json([
                'success' => false,
                'message' => 'Student grade record not found for monitoring.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Help support plan generated.',
            'data' => $this->earlyWarningService->generateSupportPlan($assessment),
        ]);
    }
}
