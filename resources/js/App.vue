<template>
  <div>
    <SiteNavbar :user="user" @logout="handleLogout" />
    <main class="container py-4">
      <router-view @update-user="loadUser" />
    </main>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import SiteNavbar from './components/SiteNavbar.vue';
import { fetchUser } from './store';

const user = ref(null);

const loadUser = async () => {
  user.value = await fetchUser();
};

const handleLogout = async () => {
  await fetch('/api/logout', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
    },
  });
  await loadUser();
  window.location.href = '/';
};

onMounted(loadUser);
</script>
