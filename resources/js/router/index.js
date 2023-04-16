
const routes = [
    {
        path: '/admin/dashboard',
        name : 'admin/dashboard',
        component: () => import('../views/admin/Dashboard.vue')
    },
    {
        path: '/admin/tag',
        name : 'admin/tag',
        meta: {
            title : 'Tag'
        },
        component: () => import('../views/admin/tag/Index.vue')
    },
    {
        path: '/admin/category',
        name : 'category',
        meta: {
            title : 'Category'
        },
        component: () => import('../views/admin/category/Index.vue')
    },
    {
        path: '/admin/user',
        name : 'user',
        meta: {
            title : 'User'
        },
        component: () => import('../views/admin/user/Index.vue')
    },
    {
        path: '/admin/role',
        name : 'role',
        meta: {
            title : 'Role'
        },
        component: () => import('../views/admin/role/Index.vue')
    },
    {
        path: '/admin/assign-role',
        name : 'AssignRole',
        meta: {
            title : 'Assign Role'
        },
        component: () => import('../views/admin/role/AssignRole.vue')
    },



    {
        path: '*',
        name: 'PageNotFound',
        component: import('./../views/error/PageNotFound.vue')
    }


  ]



  export default routes

