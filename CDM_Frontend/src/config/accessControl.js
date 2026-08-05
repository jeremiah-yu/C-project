export const ROLES = Object.freeze({
  GUEST: 'Guest',
  STUDENT: 'Student',
  PROFESSOR: 'Professor',
  REGISTRAR_STAFF: 'Registrar Staff',
  ADMIN: 'Admin',
})

export const ROLE_DASHBOARDS = Object.freeze({
  [ROLES.GUEST]: '/portal/guest-dashboard',
  [ROLES.STUDENT]: '/portal/student-dashboard',
  [ROLES.PROFESSOR]: '/portal/professor-dashboard',
  [ROLES.REGISTRAR_STAFF]: '/portal/registrar-dashboard',
  [ROLES.ADMIN]: '/portal/admin-dashboard',
})

export const dashboardForRole = (role) => ROLE_DASHBOARDS[role] || '/portal/unauthorized'

export const ROUTE_ROLES = Object.freeze({
  home: Object.values(ROLES),
  'guest-dashboard': [ROLES.GUEST],
  'student-dashboard': [ROLES.STUDENT],
  'professor-dashboard': [ROLES.PROFESSOR],
  'registrar-dashboard': [ROLES.REGISTRAR_STAFF],
  'admin-dashboard': [ROLES.ADMIN],
  'guest-profile': [ROLES.GUEST],
  'document-request': Object.values(ROLES),
  appointments: [ROLES.GUEST],
  'activate-student-account': [ROLES.GUEST],
  admission: [ROLES.REGISTRAR_STAFF, ROLES.ADMIN],
  enrollment: [ROLES.REGISTRAR_STAFF, ROLES.ADMIN],
  grading: [ROLES.STUDENT, ROLES.PROFESSOR, ROLES.ADMIN],
  monitoring: [ROLES.STUDENT, ROLES.PROFESSOR, ROLES.REGISTRAR_STAFF, ROLES.ADMIN],
  'student-management': [ROLES.REGISTRAR_STAFF, ROLES.ADMIN],
  'event-attendance': [ROLES.STUDENT, ROLES.PROFESSOR, ROLES.REGISTRAR_STAFF, ROLES.ADMIN],
})

export const NAVIGATION_ITEMS = Object.freeze([
  { name: 'guest-dashboard', label: 'Dashboard', path: '/portal/guest-dashboard', icon: 'DB', roles: ROUTE_ROLES['guest-dashboard'] },
  { name: 'guest-profile', label: 'My Profile', path: '/portal/profile', icon: 'PR', roles: ROUTE_ROLES['guest-profile'] },
  { name: 'document-request', label: 'Document Requests', path: '/portal/document-request', icon: 'DR', roles: ROUTE_ROLES['document-request'] },
  { name: 'appointments', label: 'Appointments', path: '/portal/appointments', icon: 'AP', roles: ROUTE_ROLES.appointments },
  { name: 'activate-student-account', label: 'Activate Student Account', path: '/portal/activate-student-account', icon: 'AC', roles: ROUTE_ROLES['activate-student-account'], comingSoon: true },
  { name: 'student-dashboard', label: 'Student Dashboard', path: '/portal/student-dashboard', icon: 'DB', roles: ROUTE_ROLES['student-dashboard'] },
  { name: 'professor-dashboard', label: 'Professor Dashboard', path: '/portal/professor-dashboard', icon: 'DB', roles: ROUTE_ROLES['professor-dashboard'] },
  { name: 'registrar-dashboard', label: 'Registrar Dashboard', path: '/portal/registrar-dashboard', icon: 'DB', roles: ROUTE_ROLES['registrar-dashboard'] },
  { name: 'admin-dashboard', label: 'Admin Dashboard', path: '/portal/admin-dashboard', icon: 'DB', roles: ROUTE_ROLES['admin-dashboard'] },
  { name: 'admission', label: 'Admission', path: '/portal/admission', icon: 'AD', roles: ROUTE_ROLES.admission },
  { name: 'enrollment', label: 'Enrollment', path: '/portal/enrollment', icon: 'EN', roles: ROUTE_ROLES.enrollment },
  { name: 'grading', label: 'Grading', path: '/portal/grading', icon: 'GR', roles: ROUTE_ROLES.grading },
  { name: 'monitoring', label: 'AI Monitoring', path: '/portal/monitoring', icon: 'MO', roles: ROUTE_ROLES.monitoring },
  { name: 'student-management', label: 'Student Management', path: '/portal/student-management', icon: 'SM', roles: ROUTE_ROLES['student-management'] },
  { name: 'event-attendance', label: 'Event Attendance', path: '/portal/event-attendance', icon: 'EV', roles: ROUTE_ROLES['event-attendance'] },
])

export const canAccess = (role, allowedRoles = []) => allowedRoles.includes(role)
