<template>
  <div>
    <h1 class="h3 mb-4">My Orders</h1>

    <div v-if="orders.data.length === 0" class="alert alert-info">
      You have no orders yet.
    </div>

    <div v-else class="list-group">
      <router-link v-for="order in orders.data" :key="order.id" :to="`/orders/${order.id}`" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <div>
          <strong>Order #{{ order.id }}</strong>
          <div class="text-muted">Placed on {{ new Date(order.created_at).toLocaleDateString() }}</div>
        </div>
        <div class="text-end">
          <div class="fw-semibold">${{ order.total.toFixed(2) }}</div>
          <span class="badge bg-secondary text-capitalize">{{ order.status }}</span>
        </div>
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const orders = ref({ data: [] });

const loadOrders = async () => {
  const response = await axios.get('/api/orders');
  orders.value = response.data;
};

onMounted(loadOrders);
</script>
