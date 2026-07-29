<script setup>
import { RouterLink } from 'vue-router'
import { useNavigationStore } from '../stores/navigation'
import { useAuthStore } from '../stores/authStore'

defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['close'])
const navigationStore = useNavigationStore()
const authStore = useAuthStore()
</script>

<template>
  <aside class="sidebar" :class="{ 'is-open': isOpen }">
    <div class="brand">
      <span class="brand-mark">CDM</span>
      <div>
        <strong>CDM Portal</strong>
        <small>Developer Scaffold</small>
      </div>
    </div>

    <nav class="sidebar-nav" aria-label="Main navigation">
      <RouterLink
        v-for="item in navigationStore.menuItemsForRole(authStore.currentRole)"
        :key="item.name"
        :to="item.path"
        class="nav-link"
        @click="emit('close')"
      >
        <span class="nav-icon" aria-hidden="true">{{ item.icon }}</span>
        <span>{{ item.label }}</span>
      </RouterLink>
    </nav>
  </aside>
</template>

<style scoped>
.sidebar {
  position: fixed;
  inset: 0 auto 0 0;
  z-index: 30;
  width: 280px;
  border-right: 1px solid var(--color-border);
  background: var(--color-eerie-black);
  padding: 22px 16px;
  transform: translateX(0);
  transition: transform 180ms ease;
}

.brand {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 0 8px 22px;
}

.brand-mark {
  display: grid;
  width: 44px;
  height: 44px;
  place-items: center;
  border-radius: 8px;
  background: var(--color-naples-yellow);
  color: var(--color-eerie-black);
  font-size: 0.82rem;
  font-weight: 800;
}

.brand strong,
.brand small {
  display: block;
}

.brand small {
  margin-top: 2px;
  color: var(--color-anti-flash-white);
}

.brand strong {
  color: var(--color-anti-flash-white);
}

.sidebar-nav {
  display: grid;
  gap: 6px;
}

.nav-link {
  display: flex;
  align-items: center;
  gap: 12px;
  min-height: 44px;
  border-radius: 8px;
  padding: 10px 12px;
  color: var(--color-anti-flash-white);
  font-weight: 600;
}

.nav-link:hover {
  background: var(--color-dark-spring-green);
  color: var(--color-anti-flash-white);
}

.nav-link.router-link-active {
  background: var(--color-dartmouth-green);
  color: var(--color-anti-flash-white);
}

.nav-icon {
  width: 24px;
  text-align: center;
}

@media (max-width: 860px) {
  .sidebar {
    transform: translateX(-100%);
  }

  .sidebar.is-open {
    transform: translateX(0);
  }
}
</style>
