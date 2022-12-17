import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axios from 'axios'
import Toaster from "@meforma/vue-toaster";
import { io } from "socket.io-client"

import FieldErrorMessage from './components/global/FieldErrorMessage.vue'
import ConfirmationDialog from './components/global/ConfirmationDialog.vue'

import App from './App.vue'
import router from './router'

//import './assets/main.css'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap-icons/font/bootstrap-icons.css"
import "bootstrap"

import "./assets/main.css";
import "./assets/dashboard.css";

const app = createApp(App);

app.provide('socket', io("http://127.0.0.1:3000"));

const serverBaseUrl = 'http://server_api.test'
app.provide('axios', axios.create({
    baseURL: serverBaseUrl + '/api',
    headers: {
        'Content-type': 'application/json',
    },
  }));
app.provide('serverBaseUrl', serverBaseUrl);

app.use(Toaster, {
    // Global/Default options
    position: 'top',
    timeout: 3000,
    pauseOnHover: true
});

app.provide('toast', app.config.globalProperties.$toast);

app.use(createPinia());
app.use(router);

app.component('FieldErrorMessage', FieldErrorMessage);
app.component('ConfirmationDialog', ConfirmationDialog);

app.mount('#app');
