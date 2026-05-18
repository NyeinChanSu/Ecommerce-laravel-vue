<template>
  <div>
    <h1 class="h3 mb-4">Shopping Cart</h1>

    <div v-if="items.length === 0" class="alert alert-info">
      Your cart is empty. <router-link to="/">Browse products</router-link>.
    </div>

    <div v-else>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Product</th>
              <th class="text-center">Quantity</th>
              <th class="text-end">Price</th>
              <th class="text-end">Subtotal</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, productId) in items" :key="productId">
              <td>{{ item.name }}</td>
              <td class="text-center">
                <div class="input-group input-group-sm justify-content-center">
                  <input type="number" class="form-control" min="1" v-model.number="item.quantity" />
                  <button class="btn btn-outline-secondary" @click="updateItem(productId, item.quantity)">Update</button>
                </div>
              </td>
              <td class="text-end">${{ item.price.toFixed(2) }}</td>
              <td class="text-end">${{ (item.price * item.quantity).toFixed(2) }}</td>
              <td class="text-end">
                <button class="btn btn-sm btn-danger" @click="removeItem(productId)">Remove</button>
              </td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="text-end"><strong>Total</strong></td>
              <td class="text-end"><strong>${{ total.toFixed(2) }}</strong></td>
              <td></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="d-flex justify-content-between">
        <router-link class="btn btn-outline-secondary" to="/">Continue shopping</router-link>
        <router-link class="btn btn-primary" to="/checkout">Proceed to checkout</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, computed, onMounted } from 'vue';
import axios from 'axios';

const cart = reactive({ items: {} });

const loadCart = async () => {
  const response = await axios.get('/api/cart');
  cart.items = response.data;
};

const updateItem = async (productId, quantity) => {
  await axios.post(`/api/cart/${productId}/update`, { quantity });
  await loadCart();
};

const removeItem = async (productId) => {
  await axios.post(`/api/cart/${productId}/remove`);
  await loadCart();
};

const total = computed(() => {
  return Object.values(cart.items).reduce((sum, item) => sum + item.price * item.quantity, 0);
});

const items = computed(() => cart.items);

onMounted(loadCart);
</script>
