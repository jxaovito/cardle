import { createApp } from 'vue';
import AutocompleteInput from './components/AutocompleteInput.vue';

const app = createApp({});

app.component('autocomplete-input', AutocompleteInput);

app.mount('#app');