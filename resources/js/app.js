import './bootstrap';
import '../css/app.css';
import router from "@src/router";
import pinia from "@src/store";
import { createApp } from 'vue';
import App from '@src/App.vue'
import setAxiosAuthHeader from '@src/utils/setAxiosAuthHeader';

setAxiosAuthHeader();

createApp(App).use(pinia).use(router).mount('#app');