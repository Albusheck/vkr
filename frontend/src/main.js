import { createApp } from 'vue';
import Unicon from 'vue-unicons'

import App from './App.vue';
import store from './store';
import './assets/main.css';

import { uniAngleUp } from 'vue-unicons/dist/icons'

Unicon.add([uniAngleUp])
const app = createApp(App);

app
.use(store) 
.use(Unicon)
.mount('#app');
