import './bootstrap';

import { createApp } from 'vue';
import AddIncome from './components/AddIncome.vue';
import BalanceCard from './components/BalanceCard.vue';

const app = createApp({})
app.component('add-income', AddIncome)
app.component('balance-card', BalanceCard)

app.mount('#app');


