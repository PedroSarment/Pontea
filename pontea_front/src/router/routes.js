
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '/home', component: () => import('pages/HomePage.vue') },
      { path: '/atividades', component: () => import('pages/ActivitiesPage.vue'), // Rota pai "atividades"
        children: [
          { path: 'detalhes', component: () => import('pages/DetailsPage.vue') } // Rota filha "detalhes" -> atividades/detalhes
        ]
      },
      { path: '/experiencias', component: () => import('pages/ExperiencesPage.vue') },
      { path: '/educadores', component: () => import('pages/EducatorsPage.vue') },
      { path: '/busca', component: () => import('pages/SearchPage.vue') }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
