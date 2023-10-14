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
                path: "/ip-addresses/create",
                name: "ip-address.create",
                component: () => import("@src/views/auth/ip-address/CreateEditIPAddress.vue"),
                meta: {
                    title: 'Create IP Address',
                    authRequired: true,
                },
            },
            {
                path: "/ip-addresses/:id",
                name: "ip-address.show",
                component: () => import("@src/views/auth/ip-address/Show.vue"),
                meta: {
                    title: 'Show IP Address',
                    authRequired: true,
                },
            },
            {
                path: "/ip-addresses/:id/edit",
                name: "ip-address.edit",
                component: () => import("@src/views/auth/ip-address/CreateEditIPAddress.vue"),
                meta: {
                    title: 'Edit IP Address',
                    authRequired: true,
                },
            },
            {
                path: "/authentication-logs",
                name: "authentication-logs",
                component: () => import("@src/views/auth/authentication-log/Index.vue"),
                meta: {
                    title: 'Authentication Log',
                    authRequired: true,
                },
            },
            {
                path: "/audit-logs",
                name: "audit-logs",
                component: () => import("@src/views/auth/audit-log/Index.vue"),
                meta: {
                    title: 'Audit Log',
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