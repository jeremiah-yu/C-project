export const schoolInfo = {
  name: 'Colegio de Montalban',
  shortName: 'CDM',
  portalName: 'CDM Portal',
  tagline: 'OneServe campus services for every student journey.',
  location: 'Rodriguez, Rizal, Philippines',
  established: 'Campus community learning hub',
  mission:
    'To provide accessible, technology-enabled campus services that support every learner from admission to graduation.',
  vision:
    'A connected campus where academic care, early intervention, and student success tools work together.',
  overview: [
    {
      title: 'Student-centered services',
      body: 'Enrollment, grading, documents, and academic support live in one portal so students and staff move faster with clearer records.',
    },
    {
      title: 'Faculty & registrar tools',
      body: 'Professors and registrar staff share the same academic source of truth for sections, grades, and student records.',
    },
    {
      title: 'Preventive academic care',
      body: 'AI Monitoring watches grade patterns early so at-risk learners get support before a failing mark becomes final.',
    },
  ],
  contacts: [
    { label: 'Registrar', value: 'registrar@cdm.edu.ph' },
    { label: 'Campus', value: 'Rodriguez, Rizal' },
    { label: 'Portal', value: 'OneServe · CDM Portal' },
  ],
  upcomingLinks: [
    {
      id: 'ai-monitoring',
      title: 'AI Monitoring Early Warning',
      status: 'Available now',
      description:
        'Track grade trends, flag risk of failing, and generate personalized help-support plans for students and advisers.',
      routeName: 'monitoring',
      requiresAuth: true,
      featured: true,
    },
    {
      id: 'study-plans',
      title: 'Guided Study Plans',
      status: 'Coming soon',
      description: 'Auto-built weekly study plans linked to subjects with declining grades.',
      routeName: null,
      requiresAuth: false,
      featured: false,
    },
    {
      id: 'advisor-alerts',
      title: 'Adviser Alert Inbox',
      status: 'Coming soon',
      description: 'Push early-warning notices to professors and registrar advisers in one place.',
      routeName: null,
      requiresAuth: false,
      featured: false,
    },
  ],
}
