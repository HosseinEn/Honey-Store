require('./bootstrap');
import * as Vue from 'vue'
import App from './App.vue'
import store from './store'
import router from './routes';
import './assets/css/common.css';
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'cors'

const cors = require('cors');
const corsConfig = {
  credentials: true,
  origin: true
};

const app = Vue.createApp({})
app.component('app', App)
// app.use(cors(corsConfig));
app.use(store)
app.use(router).mount('#app')

