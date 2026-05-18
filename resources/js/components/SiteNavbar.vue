<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
      <router-link class="navbar-brand" to="/">Ecommerce</router-link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link class="nav-link" to="/">Shop</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/cart">Cart</router-link>
          </li>
          <li class="nav-item" v-if="user">
            <router-link class="nav-link" to="/orders">Orders</router-link>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown" v-if="loggedUser">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ loggedUser.name }}</a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><router-link class="dropdown-item" to="/orders">Orders</router-link></li>
              <li><a @click.prevent="logout" class="dropdown-item" href="#">Logout</a></li>
            </ul>
          </li>
          <template v-else>
            <li class="nav-item">
              <router-link class="nav-link" to="/login">Login</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/register">Register</router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { computed } from 'vue';
import { store } from '../store';

const props = defineProps({
  user: Object,
});

const loggedUser = computed(() => props.user || store.user);

const logout = async () => {
  await fetch('/api/logout', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
    },
  });
  window.location.href = '/';
};
</script>
