<template>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h1 class="h4 mb-3">Register</h1>
          <form @submit.prevent="submit">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input class="form-control" v-model="form.name" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" v-model="form.email" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" v-model="form.password" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Confirm Password</label>
              <input type="password" class="form-control" v-model="form.password_confirmation" required />
            </div>
            <div v-if="error" class="alert alert-danger">{{ error }}</div>
            <button class="btn btn-primary w-100" type="submit">Register</button>
          </form>
          <div class="mt-3 text-center">
            <router-link to="/login">Already have an account? Login</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const emit = defineEmits(['update-user']);
const router = useRouter();
const error = ref('');
const form = reactive({ name: '', email: '', password: '', password_confirmation: '' });

const submit = async () => {
  try {
    await axios.post('/api/register', form);
    emit('update-user');
    router.push('/');
  } catch (e) {
    error.value = e.response?.data?.message || 'Unable to register.';
  }
};
</script>
