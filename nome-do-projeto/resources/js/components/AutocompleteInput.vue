<template>
    <div class="autocomplete-container">
    <div class="autocomplete">
      <input class="autocomplete-input" type="text" v-model="searchText" @input="updateSuggestions" />
        <div class="suggestions-container" v-if="searchText.length > 0">
            <div class="suggestion" v-for="suggestion in suggestions" :key="suggestion.id" @click="selectSuggestion(suggestion)">
              {{ suggestion.modelo }}
            </div>
        </div>
    </div>
  </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        searchText: '',
        suggestions: [],
      };
    },
    methods: {
      updateSuggestions() {
        axios.post('/search', { q: this.searchText })
          .then(response => {
            console.log(response.data);
            this.suggestions = response.data;
          });
      },
      selectSuggestion(suggestion) {
        this.searchText = suggestion.modelo;
        this.suggestions = [];
      },
    },
  };
  </script>

  
<style scoped>
.autocomplete-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.autocomplete-input{
  width:450px;
  padding: 2px;
  height:30px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.suggestion{
  padding: 5px;
}
.suggestions-container {
  position: absolute;
  width: 450px;
  padding: 2px;
  background-color: #fff;
  border: 1px solid #ccc;
  z-index: 1;
  overflow: auto;
  border: 1px solid #ccc;
  border-radius: 2px;
}
</style>