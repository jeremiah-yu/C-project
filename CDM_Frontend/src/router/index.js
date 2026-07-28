import { createRouter, createWebHashHistory } from 'vue-router'
import DashboardLayout from '../layouts/DashboardLayout.vue'
import DashboardView from '../views/DashboardView.vue'
import AdmissionView from '../modules/admission/AdmissionView.vue'
import EnrollmentView from '../modules/enrollment/EnrollmentView.vue'
import GradingView from '../modules/grading/GradingView.vue'
import MonitoringView from '../modules/monitoring/MonitoringView.vue'
import DocumentRequestView from '../modules/document-request/DocumentRequestView.vue'
import StudentManagementView from '../modules/student-management/StudentManagementView.vue'
import EventAttendanceView from '../modules/event-attendance/EventAttendanceView.vue'

const routes = [
  {
    path: '/',
    component: DashboardLayout,
    children: [
      {
        path: '',
        name: 'dashboard',
        component: DashboardView,
        meta: { title: 'Dashboard' },
      },
      {
        path: 'admission',
        name: 'admission',
        component: AdmissionView,
        meta: { title: 'Admission' },
      },
      {
        path: 'enrollment',
        name: 'enrollment',
        component: EnrollmentView,
        meta: { title: 'Enrollment' },
      },
      {
        path: 'grading',
        name: 'grading',
        component: GradingView,
        meta: { title: 'Grading' },
      },
      {
        path: 'monitoring',
        name: 'monitoring',
        component: MonitoringView,
        meta: { title: 'Monitoring' },
      },
      {
        path: 'document-request',
        name: 'document-request',
        component: DocumentRequestView,
        meta: { title: 'Document Request' },
      },
      {
        path: 'student-management',
        name: 'student-management',
        component: StudentManagementView,
        meta: { title: 'Student Management' },
      },
      {
        path: 'event-attendance',
        name: 'event-attendance',
        component: EventAttendanceView,
        meta: { title: 'Event Attendance' },
      },
    ],
  },
]

const router = createRouter({
  // Hash history works in browser PWA, Capacitor WebView, and Electron file builds.
  history: createWebHashHistory(),
  routes,
})

router.afterEach((to) => {
  document.title = to.meta.title ? `${to.meta.title} | CDM Portal` : 'CDM Portal'
})

export default router
