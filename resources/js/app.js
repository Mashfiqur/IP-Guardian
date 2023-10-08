import './bootstrap';
import '../css/app.css';
import { createPinia } from 'pinia';
import router from "@src/router";
import { createApp } from 'vue';
import App from '@src/App.vue'

const pinia = createPinia();
const app = createApp(App);

app.use(pinia)
    .use(router)
    .mount('#app')
