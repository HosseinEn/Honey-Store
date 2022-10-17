require('./bootstrap');

import * as Vue from 'vue'
import Welcome from './components/Welcome'
import router from './routes';

const app = Vue.createApp({})

app.component('welcome', Welcome)

app.use(router).mount('#app')

