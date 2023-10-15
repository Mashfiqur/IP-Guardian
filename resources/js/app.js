import './bootstrap';
import '../css/app.css';
import router from "@src/router";
import pinia from "@src/store";
import { createApp } from 'vue';
import App from '@src/App.vue'
import setAxiosAuthHeader from '@src/utils/setAxiosAuthHeader';
import Notifications, { notify } from '@kyvg/vue3-notification'

setAxiosAuthHeader();

window.notify = notify;

createApp(App)
    .use(pinia)
    .use(router)
    .use(Notifications, {
        closeOnClick: true
    })
    .mount('#app');