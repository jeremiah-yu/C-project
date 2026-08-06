<script setup>
import { computed } from 'vue'
import { RouterLink } from 'vue-router'
import { ROLES, ROUTE_ROLES, canAccess } from '../config/accessControl'

const props = defineProps({
  role: { type: String, required: true },
})

const canOpenMonitoring = computed(() => canAccess(props.role, ROUTE_ROLES.monitoring))

const highlights = computed(() => {
  if (props.role === ROLES.STUDENT) {
    return [
      'Check your grade risk signals early.',
      'Generate a help-support plan before finals.',
      'Track subject-by-subject early warnings.',
    ]
  }

  return [
    'Review students flagged for risk of failing.',
    'Inspect subject grade trends across periods.',
    'Generate intervention / help-support plans.',
  ]
})
</script>

<template>
  <section class="page-header">
    <p class="page-kicker">{{ role }} Portal</p>
    <h1 class="page-title">{{ role }} Dashboard</h1>
    <p class="page-description">
      Start with AI Monitoring to catch academic risk early and guide students with support plans.
    </p>
  </section>

  <section class="dashboard-panel">
    <h2>Quick actions</h2>
    <ul>
      <li v-for="item in highlights" :key="item">{{ item }}</li>
    </ul>
    <RouterLink v-if="canOpenMonitoring" class="cta" :to="{ name: 'monitoring' }">
      Open AI Monitoring
    </RouterLink>
  </section>
</template>

<style scoped>
.dashboard-panel {
  border: 1px solid var(--color-border);
  border-radius: 16px;
  background: var(--color-surface);
  padding: 22px;
  box-shadow: var(--shadow-soft);
  max-width: 720px;
}

.dashboard-panel h2 {
  margin: 0 0 12px;
  font-family: var(--font-display);
  font-size: 1.25rem;
}

.dashboard-panel ul {
  margin: 0 0 18px;
  padding-left: 18px;
  color: var(--color-muted);
  line-height: 1.6;
}

.cta {
  display: inline-flex;
  align-items: center;
  min-height: 42px;
  border-radius: 8px;
  background: var(--color-dartmouth-green);
  color: #fff;
  font-weight: 700;
  padding: 0 16px;
}
</style>
