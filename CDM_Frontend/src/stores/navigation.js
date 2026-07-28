import { defineStore } from 'pinia'

// Centralized navigation keeps routes, sidebar links, and dashboard cards consistent.
export const useNavigationStore = defineStore('navigation', {
  state: () => ({
    menuItems: [
      {
        name: 'dashboard',
        label: 'Dashboard',
        path: '/',
        icon: 'DB',
        description: 'Overview of campus operations and module shortcuts.',
      },
      {
        name: 'admission',
        label: 'Admission',
        path: '/admission',
        icon: 'AD',
        description: 'Manage applications, requirements, evaluations, and admission status.',
      },
      {
        name: 'enrollment',
        label: 'Enrollment',
        path: '/enrollment',
        icon: 'EN',
        description: 'Prepare enrollment workflows, class sections, and student registration.',
      },
      {
        name: 'grading',
        label: 'Grading',
        path: '/grading',
        icon: 'GR',
        description: 'Organize grading tasks, grade encoding, and release workflows.',
      },
      {
        name: 'monitoring',
        label: 'Monitoring',
        path: '/monitoring',
        icon: 'MO',
        description: 'Track academic standing, progress alerts, and interventions.',
      },
      {
        name: 'document-request',
        label: 'Document Request',
        path: '/document-request',
        icon: 'DR',
        description: 'Queue document requests and appointment scheduling.',
      },
      {
        name: 'student-management',
        label: 'Student Management',
        path: '/student-management',
        icon: 'SM',
        description: 'Maintain student profiles, credentials, and academic records.',
      },
      {
        name: 'event-attendance',
        label: 'Event Attendance',
        path: '/event-attendance',
        icon: 'EV',
        description: 'Plan campus events and prepare QR-based attendance workflows.',
      },
    ],
  }),
})
