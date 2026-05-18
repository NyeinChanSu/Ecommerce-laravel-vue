import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import ProductShow from '../pages/ProductShow.vue';
import Cart from '../pages/Cart.vue';
import Checkout from '../pages/Checkout.vue';
import Login from '../pages/Login.vue';
import Register from '../pages/Register.vue';
import Orders from '../pages/Orders.vue';
import OrderShow from '../pages/OrderShow.vue';
import NotFound from '../pages/NotFound.vue';

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/product/:id', name: 'product.show', component: ProductShow, props: true },
  { path: '/cart', name: 'cart', component: Cart },
  { path: '/checkout', name: 'checkout', component: Checkout },
  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/orders', name: 'orders', component: Orders },
  { path: '/orders/:id', name: 'order.show', component: OrderShow, props: true },
  { path: '/:pathMatch(.*)*', name: 'notfound', component: NotFound },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
