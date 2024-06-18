import { createApp, reactive, computed } from 'vue'

const state = reactive({
  search: '',
})

const array = [
  { id: 1, title: 'Valhalla', content: '123' },
  { id: 2, title: 'Wurstopia', content: '3' },
  { id: 3, title: 'Brandon', content: '789' },
]

array.sort((a, b) => a.title.localeCompare(b.title))

const results = computed(() => {
  return array.filter(item => item.title.includes(state.search) || item.content.includes(state.search))
})

createApp({
  setup() {
    return {
      state,
      results
    }
  },
}).mount('#app')