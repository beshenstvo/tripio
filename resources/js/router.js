import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: "/",
    name: "Home",
    component: () => import('./views/AuthUser/HomeComponent.vue'),
    meta: { isAuth: false}
  },
  {
    path: "/login",
    name: "Login",
    component: () => import('./views/AuthUser/LoginComponent.vue'),
    meta: { isAuth: false }
  },
  {
    path: "/register",
    name: "Register",
    component: () => import('./views/AuthUser/RegisterComponent.vue'),
    meta: { isAuth: false }
  },
  {
    path: "/profile",
    name: "Profile",
    component: () => import('./views/AuthUser/ProfileComponent.vue'),
    meta: { isAuth: true}
  },
  {
    path: "/hotel",
    name: "Hotel",
    component: () => import('./views/AuthUser/HotelComponent.vue'),
    meta: { isAuth: false, role: 'user'}
  },
  {
    path: "/route",
    name: "Route",
    component: () => import('./views/AuthUser/RouteComponent.vue'),
    meta: { isAuth: false}
  },
  {
    path: "/excursion",
    name: "Excursion",
    component: () => import('./views/AuthUser/ExcursionComponent.vue'),
    meta: { isAuth: false}
  },
  {
    path: "/forum",
    name: "Forum",
    component: () => import('./views/AuthUser/ForumComponent.vue'),
    meta: { isAuth: false}
  },
  {
    path: "/favorites",
    name: "Favorites",
    component: () => import('./views/AuthUser/FavoritesComponent.vue'),
    meta: { isAuth: true}
  },
  {
    path: "/notice",
    name: "Notice",
    component: () => import('./views/AuthUser/NoticeComponent.vue'),
    meta: { isAuth: true , role: 'user'}
  },
  {
    path: "/admin/login",
    name: "Login.admin",
    component: () => import('./views/AuthAdmin/LoginComponent.vue'),
    meta: { isAuth: false }
  },
  {
    path: "/admin/allaccounts",
    name: "Admin.allaccounts",
    component: () => import('./views/AuthAdmin/AccountsComponent.vue'),
    meta: { isAuth: true }
  },
  {
    path: "/admin/excursion",
    name: "Admin.excursion",
    component: () => import('./views/AuthAdmin/ExcursionComponent.vue'),
    meta: { isAuth: true }
  },
  {
    path: "/admin/readyroute",
    name: "Admin.readyroute",
    component: () => import('./views/AuthAdmin/ReadyRoutesComponent.vue'),
    meta: { isAuth: true }
  },
  {
    path: "/admin/forum",
    name: "Admin.forum",
    component: () => import('./views/AuthAdmin/ForumComponent.vue'),
    meta: { isAuth: true }
  },
  {
    path: "/admin/reviews",
    name: "Admin.reviews",
    component: () => import('./views/AuthAdmin/ReviewsComponent.vue'),
    meta: { isAuth: true }
  },
  {
    path: "/admin/notice",
    name: "Admin.notice",
    component: () => import('./views/AuthAdmin/NoticeComponent.vue'),
    meta: { isAuth: true }
  },
  {
    path: '/admin',
    name: 'Admin.home',
    component: () => import('./views/AuthAdmin/HomePageComponent.vue'),
    meta: {
      isAuth: true,
      roles: ['admin'],
    },
  },
  {
    path: "/guide/login",
    name: "Guide.login",
    component: () => import('./views/AuthGuide/LoginComponent.vue'),
    meta: { isAuth: false }
  },
  {
    path: "/guide/register",
    name: "Guide.register",
    component: () => import('./views/AuthGuide/RegisterComponent.vue'),
    meta: { isAuth: false }
  },
  {
    path: "/guide",
    name: "Guide.home",
    component: () => import('./views/AuthGuide/HomePageComponent.vue'),
    meta: { isAuth: true }
  },
  {
    path: "/guide/service",
    name: "Guide.service",
    component: () => import('./views/AuthGuide/ServiceComponent.vue'),
    meta: { isAuth: true }
  },
  {
    path: "/guide/request",
    name: "Guide.request",
    component: () => import('./views/AuthGuide/RequestComponent.vue'),
    meta: { isAuth: true }
  },
  {
    path: "/guide/notice",
    name: "Guide.notice",
    component: () => import('./views/AuthGuide/NoticeComponent.vue'),
    meta: { isAuth: true }
  },
  {
    path: "/guide/profile",
    name: "Guide.profile",
    component: () => import('./views/AuthGuide/ProfileComponent.vue'),
    meta: { isAuth: true }
  },
  {
    path: '/error',
    name: 'Error',
    component: () => import('./views/NotFoundComponent.vue'),
    props: {
      title: '404 Error',
      message: 'Sorry, the page you requested was not found.',
    },
  },
  {
    path: '/:catchAll(.*)',
    redirect: '/error',
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
