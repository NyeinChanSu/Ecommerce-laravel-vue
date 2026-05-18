import { reactive } from 'vue';

export const store = reactive({
  user: null,
});

export async function fetchUser() {
  try {
    const response = await fetch('/api/user', {
      credentials: 'same-origin',
    });
    if (!response.ok) {
      store.user = null;
      return null;
    }
    const user = await response.json();
    store.user = user;
    return user;
  } catch (error) {
    store.user = null;
    return null;
  }
}
