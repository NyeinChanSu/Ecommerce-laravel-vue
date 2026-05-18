<template>
  <div>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h1 class="h3">Shop</h1>
        <p class="text-muted">Browse the available products.</p>
      </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
      <div class="col" v-for="product in products.data" :key="product.id">
        <div class="card h-100">
          <img :src="product.images || placeholderImage" class="card-img-top" :alt="product.name" />
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ product.name }}</h5>
            <p class="card-text text-truncate">{{ product.description || 'No description' }}</p>
            <p class="fs-5 text-primary mb-3">${{ product.price.toFixed(2) }}</p>
            <div class="mt-auto d-grid gap-2">
              <router-link :to="`/product/${product.id}`" class="btn btn-outline-primary">View details</router-link>
              <button class="btn btn-primary" @click="addToCart(product.id)">Add to cart</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <nav aria-label="Page navigation" class="mt-4" v-if="products.meta && products.meta.last_page > 1">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: page === 1 }">
          <button class="page-link" @click="goToPage(page - 1)">Previous</button>
        </li>
        <li class="page-item" v-for="n in products.meta.last_page" :key="n" :class="{ active: page === n }">
          <button class="page-link" @click="goToPage(n)">{{ n }}</button>
        </li>
        <li class="page-item" :class="{ disabled: page === products.meta.last_page }">
          <button class="page-link" @click="goToPage(page + 1)">Next</button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const products = ref({ data: [], meta: {} });
const page = ref(1);
const placeholderImage = 'https://via.placeholder.com/400x300?text=Product';

const loadProducts = async () => {
  const response = await axios.get('/api/products', { params: { page: page.value } });
  products.value = response.data;
};

const goToPage = async (pageNumber) => {
  if (pageNumber < 1 || pageNumber > products.value.meta.last_page) return;
  page.value = pageNumber;
  await loadProducts();
};

const addToCart = async (productId) => {
  await axios.post(`/api/cart/${productId}/add`);
  window.location.reload();
};

onMounted(loadProducts);
</script>
