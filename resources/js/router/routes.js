export default [
    {
        path: '',
        name: 'login',
        component: () => import('@src/views/guest/Login.vue'),
        meta: {
          title: 'Login',
          authRequired: false,
        },
    },
    {
        path: '/*', 
        name: 'AuthLayout', 
        component: () => import("@src/components/layouts/auth-layout/Index.vue"),
        children: [
            {
                path: "/dashboard",
                name: "dashboard",
                component: () => import("@src/views/auth/dashboard/Index.vue"),
                meta: {
                    title: 'Dashboard',
                    authRequired: true,
                },
            },
            {
                path: "/ip-addresses",
                name: "ip-address",
                component: () => import("@src/views/auth/ip-address/Index.vue"),
                meta: {
                    title: 'IP Address',
                    authRequired: true,
                },
            },
            {
                path: "/my-profile",
                name: "my-profile",
                component: () => import("@src/views/auth/my-profile/Index.vue"),
                meta: {
                    title: 'My Profile',
                    authRequired: true,
                },
            },
        ],
    }
];