export default [
    {
        path: "/",
        name: "login",
        component: () => import("@src/views/auth/Login.vue"),
        meta: {
            title: 'Login',
            authRequired: false,
        },
    },
];