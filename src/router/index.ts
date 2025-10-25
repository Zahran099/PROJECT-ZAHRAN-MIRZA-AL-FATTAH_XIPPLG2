import { createRouter, createWebHistory } from '@ionic/vue-router';
import type { RouteRecordRaw } from 'vue-router'; // ✅ perbaikan di sini
import TabsPage from '../views/TabsPage.vue';
import TabAuthPage from '../views/TabAuthPage.vue';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    redirect: '/tabauth'
  },
  {
    path: '/tabauth',
    component: TabAuthPage
  },
  {
    path: '/tabs/',
    component: TabsPage,
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        redirect: '/tabs/tab5'
      },
      {
        path: 'tab1',
        component: () => import('@/views/Tab1Page.vue'),
        meta: { requiresAuth: true }
      },
      {
        path: 'tab2',
        component: () => import('@/views/Tab2Page.vue'),
        meta: { requiresAuth: true }
      },
      {
        path: 'tab3',
        component: () => import('@/views/Tab3Page.vue'),
        meta: { requiresAuth: true }
      },
      {
        path: 'tab4',
        component: () => import('@/views/Tab4Page.vue'),
        meta: { requiresAuth: true }
      },
      {
        path: 'tab5',
        component: () => import('@/views/Tab5Page.vue'),
        meta: { requiresAuth: true }
      },
      {
        path: 'detail/:id',
        name: 'DetailPage',
        component: () => import('@/views/DetailPage.vue'),
        meta: { requiresAuth: true }
      }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
});

// 🔐 Middleware proteksi route
router.beforeEach((to, from, next) => {
  try {
    const storedUser = localStorage.getItem('user');
    const user = storedUser ? JSON.parse(storedUser) : null;

    if (to.meta.requiresAuth && (!user || !user.token)) {
      next('/tabauth');
      return;
    } 

    if (to.path === '/tabauth' && user && user.token) {
      next('/tabs/tab5');
      return;
    }

    next();
  } catch (err) {
    console.error('Error checking auth:', err);
    next('/tabauth');
  }
});

export default router;