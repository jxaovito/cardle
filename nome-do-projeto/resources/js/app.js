import { createApp } from 'vue';
import AutocompleteInput from './components/AutocompleteInput.vue';
import RandomCarImage from './components/RandomCarImage.vue';

const app = createApp({});

app.component('autocomplete-input', AutocompleteInput);
app.component('image-preview-container', RandomCarImage);

app.mount('#app');