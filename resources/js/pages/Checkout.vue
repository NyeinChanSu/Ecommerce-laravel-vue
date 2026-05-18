<template>
  <div>
    <h1 class="h3 mb-4">Checkout</h1>
    <div v-if="items.length === 0" class="alert alert-info">
      Your cart is empty. <router-link to="/">Browse products</router-link>.
    </div>
    <div v-else>
      <div class="row">
        <div class="col-lg-7">
          <form @submit.prevent="submitOrder">
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input class="form-control" v-model="form.name" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input class="form-control" type="email" v-model="form.email" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Address</label>
              <input class="form-control" v-model="form.address" required />
            </div>
            <div class="row g-3 mb-3">
              <div class="col-md-4">
                <label class="form-label">City</label>
                <input class="form-control" v-model="form.city" required />
              </div>
              <div class="col-md-4">
                <label class="form-label">Postal code</label>
                <input class="form-control" v-model="form.postcode" required />
              </div>
              <div class="col-md-4">
                <label class="form-label">Country</label>
                <input class="form-control" v-model="form.country" required />
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input class="form-control" v-model="form.phone" required />
            </div>
            <div v-if="error" class="alert alert-danger">{{ error }}</div>
            <button class="btn btn-primary" type="submit">Place order</button>
          </form>
        </div>
        <div class="col-lg-5">
          <div class="card p-4 mb-4">
            <h2 class="h5">Order summary</h2>
            <ul class="list-group list-group-flush mb-3">
              <li class="list-group-item" v-for="item in items" :key="item.id">
                <div class="d-flex justify-content-between">
                  <div>
                    <strong>{{ item.name }}</strong>
                    <div class="text-muted">Qty: {{ item.quantity }}</div>
                  </div>
                  <span>${{ (item.price * item.quantity).toFixed(2) }}</span>
                </div>
              </li>
            </ul>
            <div class="d-flex justify-content-between fw-semibold">
              <span>Total</span>
              <span>${{ total.toFixed(2) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, computed, onMounted, ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const cart = reactive({ items: {} });
const error = ref('');
const form = reactive({ name: '', email: '', address: '', city: '', postcode: '', country: '', phone: '' });

const loadCart = async () => {
  const response = await axios.get('/api/cart');
  cart.items = response.data;
};
const items = computed(() => Object.values(cart.items));
const total = computed(() => items.value.reduce((sum, item) => sum + item.price * item.quantity, 0));

const submitOrder = async () => {
  try {
    const response = await axios.post('/api/checkout', form);
    if (response.data && response.data.order_id) {
      router.push(`/orders/${response.data.order_id}`);
    }
  } catch (e) {
    error.value = e.response?.data?.message || 'Unable to place order.';
  }
};

onMounted(loadCart);
</script>
