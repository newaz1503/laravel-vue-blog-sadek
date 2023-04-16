
const routes = [
    {
        path: '/admin/login',
        name : 'admin.login',
        meta: {
            title : 'Login'
        },
        component: () => import('../views/auth/Login.vue')
    },

  ]

  export default routes

