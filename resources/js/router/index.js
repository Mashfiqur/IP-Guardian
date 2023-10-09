import { createRouter, createWebHistory } from "vue-router";
import routes from "@src/router/routes";
import { useAuthStore } from '@src/store/auth';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
});

router.beforeEach(async (to, from, next) => {
  const authRequired = to.matched.some(route => route.meta.authRequired);
  if (!authRequired && to.name !== 'login') return next();

  // Initiate Auth Store
  const authStore = useAuthStore();
  const bearerToken = localStorage.getItem('bearer_token');

  if(bearerToken){
    await authStore.authorization();
  }

  // Redirect to dashboard or any route if user has session
  if(to.name == 'login' && authStore.isLoggedIn){
    return to.query.redirectFrom != undefined 
          ? redirectToRoute(to.query.redirectFrom) 
          : redirectToRoute('dashboard');
  }

  function redirectToRoute(routeName) {
    next({
      name: routeName
    });
  }

  next();

  // Set title of the HTML Page from route meta
  const initialTitle = document.title.split('|')[0] || 'IP Guardian';
  document.title = to.meta.title ? `${initialTitle} | ${to.meta.title}` : initialTitle;

});


export default router;