<template>
  <div>
    <div class="row">
      <div class="col-md-6 mb-4">
        <img :src="product.images || placeholderImage" class="img-fluid rounded" :alt="product.name" />
      </div>
      <div class="col-md-6">
        <h1>{{ product.name }}</h1>
        <p class="text-muted">SKU: {{ product.slug }}</p>
        <p class="fs-4 text-primary mb-3">${{ product.price.toFixed(2) }}</p>
        <p>{{ product.description || 'No description available.' }}</p>
        <p><strong>Stock:</strong> {{ product.stock }}</p>
        <button class="btn btn-primary" @click="addToCart(product.id)">Add to cart</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';

const route = useRoute();
const product = ref({});
const placeholderImage = 'https://via.placeholder.com/700x500?text=Product';

const loadProduct = async () => {
  const response = await axios.get(`/api/products/${route.params.id}`);
  product.value = response.data;
};

const addToCart = async (productId) => {
  await axios.post(`/api/cart/${productId}/add`);
  window.location.href = '/cart';
};

onMounted(loadProduct);
</script>
