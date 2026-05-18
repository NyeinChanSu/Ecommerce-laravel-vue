<template>
  <div>
    <h1 class="h3 mb-4">Order #{{ order.id }}</h1>

    <div class="row">
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <h2 class="h5">Shipping details</h2>
            <p class="mb-1"><strong>Name:</strong> {{ order.shipping_address.name }}</p>
            <p class="mb-1"><strong>Address:</strong> {{ order.shipping_address.address }}</p>
            <p class="mb-1"><strong>City:</strong> {{ order.shipping_address.city }}</p>
            <p class="mb-1"><strong>Postal code:</strong> {{ order.shipping_address.postcode }}</p>
            <p class="mb-0"><strong>Country:</strong> {{ order.shipping_address.country }}</p>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h2 class="h5">Items</h2>
            <div class="list-group list-group-flush">
              <div class="list-group-item" v-for="item in order.order_items" :key="item.id">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <strong>{{ item.product?.name || 'Product removed' }}</strong>
                    <div class="text-muted">Qty: {{ item.quantity }}</div>
                  </div>
                  <span>${{ item.subtotal.toFixed(2) }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card p-4">
          <h2 class="h5">Order summary</h2>
          <p class="mb-1"><strong>Total</strong></p>
          <p class="fs-4">${{ order.total.toFixed(2) }}</p>
          <p class="text-muted mb-0">Payment reference: {{ order.payment_ref }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const order = ref({ order_items: {}, shipping_address: {} });

const loadOrder = async () => {
  const response = await axios.get(`/api/orders/${route.params.id}`);
  order.value = response.data;
};

onMounted(loadOrder);
</script>
