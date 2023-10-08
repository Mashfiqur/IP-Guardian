import './bootstrap';
import '../css/app.css';
import { createPinia } from 'pinia';
import { createApp } from 'vue';
import App from '@src/App.vue'

const pinia = createPinia();
const app = createApp(App);

app.use(pinia)
    .mount('#app')