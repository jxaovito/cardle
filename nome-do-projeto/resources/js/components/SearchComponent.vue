<template>
    <div>
        <input type="search" placeholder="Search" v-model="search" class="campo">
        <div v-if="results.length">
            <div v-for="result in results" :key="result.id">
                {{ result.name }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            search: '',
            results: []
        }
    },
    watch: {
        search(value) {
            this.fetchResults(value);
        }
    },
    methods: {
        fetchResults(value) {
            if (value.length) {
                axios.get(`/api/search?q=${value}`).then(response => {
                    this.results = response.data;
                });
            } else {
                this.results = [];
            }
        }
    }
}
</script>