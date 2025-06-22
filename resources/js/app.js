import './bootstrap';

import { createApp } from 'vue';
import Register from './components/Auth/Register.vue';

const app = createApp({})
app.component('register-form', Register)
app.mount('#app');


