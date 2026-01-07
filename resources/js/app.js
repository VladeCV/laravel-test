import './bootstrap'; // keeps Laravel bootstrap (Axios setup, etc.)
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.js';

import { createApp } from 'vue';
import ItemsComponent from './Components/ItemsComponent.vue';
import axios from 'axios';

// Make Axios send cookies for Sanctum authentication
axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://127.0.0.1:8000';

const app = createApp({});
app.component('items-component', ItemsComponent);
app.mount('#app');
