import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';
import Game from './components/Game.vue';

// CSRF token for all POST requests
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const app = createApp({});
app.component('game-app', Game);
app.mount('#app');
