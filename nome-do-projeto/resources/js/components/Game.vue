<template>
  <div class="game-container">

    <!-- Header -->
    <header class="game-header">
      <div class="logo">CARDLE</div>
      <p class="tagline">Adivinhe o carro do dia!</p>
      <div class="attempt-dots">
        <span
          v-for="n in MAX_ATTEMPTS"
          :key="n"
          class="dot"
          :class="{
            used: n <= guesses.length && !gameWon,
            won: gameWon && n <= guesses.length,
          }"
        ></span>
      </div>
    </header>

    <!-- Car Image -->
    <div class="image-section">
      <div class="image-viewport">
        <img
          v-if="carImagePath"
          :src="'/' + carImagePath"
          class="car-image"
          :style="{ transform: `scale(${currentScale})` }"
          alt="Carro do dia"
        />
        <div v-else class="image-placeholder">
          <span>🚗</span>
        </div>
      </div>
      <p class="zoom-label" v-if="!gameWon && !gameLost">
        Zoom: {{ Math.round(100 / currentScale) }}% da imagem visível
      </p>
    </div>

    <!-- Result banners -->
    <div v-if="gameWon" class="result-banner win">
      🏆 Correto! Você acertou em
      <strong>{{ guesses.length }} tentativa{{ guesses.length !== 1 ? 's' : '' }}</strong>!
    </div>
    <div v-if="gameLost" class="result-banner lose">
      😢 O carro era: <strong>{{ dailyCarReveal }}</strong>
    </div>

    <!-- Input -->
    <div v-if="!gameWon && !gameLost" class="input-section">
      <div class="autocomplete" ref="autocompleteRef">
        <div class="input-wrapper">
          <span class="input-icon">🔍</span>
          <input
            v-model="searchText"
            @input="onInput"
            @keydown.escape="closeSuggestions"
            @keydown.enter.prevent="selectFirst"
            @keydown.tab.prevent="selectFirst"
            placeholder="Digite a marca ou modelo..."
            class="search-input"
            autocomplete="off"
          />
        </div>
        <div v-if="suggestions.length" class="suggestions-list">
          <div
            v-for="car in suggestions"
            :key="car.id"
            class="suggestion-item"
            @click="makeGuess(car)"
          >
            <span class="s-marca">{{ car.marca }}</span>
            <span class="s-modelo">{{ car.modelo }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Guesses Table -->
    <div v-if="guesses.length" class="guesses-section">
      <div class="table-head">
        <div class="th th-car">Carro</div>
        <div class="th">Marca</div>
        <div class="th">Carroceria</div>
        <div class="th">Motor</div>
        <div class="th">Ano</div>
        <div class="th">Peso</div>
      </div>
      <div
        v-for="(g, i) in guesses"
        :key="i"
        class="guess-row"
        :class="{ 'guess-win': g.won }"
      >
        <div class="td td-car">{{ g.car.marca }} {{ g.car.modelo }}</div>
        <div class="td" :class="g.comparison.marca.result">
          {{ g.car.marca }}
        </div>
        <div class="td" :class="g.comparison.carroceria.result">
          {{ g.car.carroceria }}
        </div>
        <div class="td" :class="g.comparison.motor.result">
          {{ g.car.motor }}L {{ arrow(g.comparison.motor.result) }}
        </div>
        <div class="td" :class="g.comparison.ano_lancamento.result">
          {{ g.car.ano_lancamento }} {{ arrow(g.comparison.ano_lancamento.result) }}
        </div>
        <div class="td" :class="g.comparison.peso.result">
          {{ g.car.peso }}kg {{ arrow(g.comparison.peso.result) }}
        </div>
      </div>
    </div>

    <!-- Legend -->
    <div v-if="guesses.length" class="legend">
      <span class="legend-item correct">■ Correto</span>
      <span class="legend-item wrong">■ Errado</span>
      <span class="legend-item low">■ ↑ Precisa ser maior</span>
      <span class="legend-item high">■ ↓ Precisa ser menor</span>
    </div>

  </div>
</template>

<script>
import axios from 'axios';

const MAX_ATTEMPTS = 6;
const SCALES = [4.5, 3.2, 2.4, 1.8, 1.3, 1.0, 1.0];

export default {
  name: 'Game',

  data() {
    return {
      MAX_ATTEMPTS,
      carImagePath: null,
      searchText: '',
      suggestions: [],
      guesses: [],
      guessedIds: [],
      gameWon: false,
      gameLost: false,
      dailyCarReveal: '',
    };
  },

  computed: {
    currentScale() {
      if (this.gameWon || this.gameLost) return 1.0;
      const idx = Math.min(this.guesses.length, SCALES.length - 1);
      return SCALES[idx];
    },
  },

  mounted() {
    this.loadState();
    this.fetchCarImage();
    if (this.gameLost && !this.dailyCarReveal) {
      this.fetchGameOverReveal();
    }
    document.addEventListener('click', this.onClickOutside);
  },

  beforeUnmount() {
    document.removeEventListener('click', this.onClickOutside);
  },

  methods: {
    fetchCarImage() {
      axios.get('/random-car-image').then(r => {
        if (r.data.car_of_the_day) {
          this.carImagePath = r.data.car_of_the_day.foto;
        }
      }).catch(() => {});
    },

    onInput() {
      if (!this.searchText.trim()) {
        this.suggestions = [];
        return;
      }
      axios.post('/search', { q: this.searchText }).then(r => {
        this.suggestions = r.data.filter(c => !this.guessedIds.includes(c.id));
      }).catch(() => {});
    },

    closeSuggestions() {
      this.suggestions = [];
    },

    onClickOutside(e) {
      if (this.$refs.autocompleteRef && !this.$refs.autocompleteRef.contains(e.target)) {
        this.closeSuggestions();
      }
    },

    selectFirst() {
      if (this.suggestions.length) this.makeGuess(this.suggestions[0]);
    },

    arrow(result) {
      if (result === 'low') return '↑';
      if (result === 'high') return '↓';
      return '';
    },

    makeGuess(car) {
      if (this.guessedIds.includes(car.id) || this.gameWon || this.gameLost) return;

      axios.post('/try', { id: car.id }).then(r => {
        const data = r.data;

        if (data.won) {
          this.guesses.push({
            car: data.guessedCar,
            won: true,
            comparison: {
              marca: { result: 'correct' },
              carroceria: { result: 'correct' },
              motor: { result: 'correct' },
              ano_lancamento: { result: 'correct' },
              peso: { result: 'correct' },
            },
          });
          this.gameWon = true;
        } else {
          this.guesses.push({
            car: data.guessedCar,
            won: false,
            comparison: data.comparison,
          });
          this.guessedIds.push(car.id);

          if (this.guesses.length >= MAX_ATTEMPTS) {
            this.gameLost = true;
            this.fetchGameOverReveal();
          }
        }

        this.searchText = '';
        this.suggestions = [];
        this.saveState();
      }).catch(() => {});
    },

    fetchGameOverReveal() {
      axios.get('/game-over').then(r => {
        this.dailyCarReveal = `${r.data.marca} ${r.data.modelo}`;
        this.saveState();
      }).catch(() => {});
    },

    saveState() {
      try {
        localStorage.setItem('cardle_v2', JSON.stringify({
          date: new Date().toDateString(),
          guesses: this.guesses,
          guessedIds: this.guessedIds,
          gameWon: this.gameWon,
          gameLost: this.gameLost,
          dailyCarReveal: this.dailyCarReveal,
        }));
      } catch (e) {}
    },

    loadState() {
      try {
        const raw = localStorage.getItem('cardle_v2');
        if (!raw) return;
        const s = JSON.parse(raw);
        if (s.date !== new Date().toDateString()) return;
        this.guesses = s.guesses || [];
        this.guessedIds = s.guessedIds || [];
        this.gameWon = s.gameWon || false;
        this.gameLost = s.gameLost || false;
        this.dailyCarReveal = s.dailyCarReveal || '';
      } catch (e) {}
    },
  },
};
</script>

<style scoped>
/* ---------- Layout ---------- */
.game-container {
  max-width: 820px;
  margin: 0 auto;
  padding: 24px 16px 60px;
  font-family: 'Segoe UI', Arial, sans-serif;
  color: #f1f5f9;
}

/* ---------- Header ---------- */
.game-header {
  text-align: center;
  margin-bottom: 24px;
}
.logo {
  font-size: 2.6rem;
  font-weight: 900;
  letter-spacing: 10px;
  color: #f59e0b;
  text-shadow: 0 0 30px rgba(245, 158, 11, 0.4);
}
.tagline {
  color: #94a3b8;
  margin: 4px 0 12px;
  font-size: 0.9rem;
}
.attempt-dots {
  display: flex;
  justify-content: center;
  gap: 8px;
}
.dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: #334155;
  transition: background 0.3s;
}
.dot.used { background: #ef4444; }
.dot.won  { background: #22c55e; }

/* ---------- Image ---------- */
.image-section {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 20px;
}
.image-viewport {
  width: 100%;
  max-width: 700px;
  height: 360px;
  overflow: hidden;
  border-radius: 14px;
  background: #0f172a;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 8px 32px rgba(0,0,0,0.5);
}
.car-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transform-origin: center center;
  transition: transform 0.9s cubic-bezier(0.4, 0, 0.2, 1);
}
.image-placeholder {
  font-size: 4rem;
  opacity: 0.3;
}
.zoom-label {
  font-size: 0.75rem;
  color: #64748b;
  margin-top: 8px;
}

/* ---------- Result Banners ---------- */
.result-banner {
  text-align: center;
  padding: 16px 24px;
  border-radius: 10px;
  font-size: 1.1rem;
  margin-bottom: 20px;
}
.result-banner.win {
  background: #14532d;
  border: 1px solid #22c55e;
  color: #86efac;
}
.result-banner.lose {
  background: #450a0a;
  border: 1px solid #ef4444;
  color: #fca5a5;
}

/* ---------- Input ---------- */
.input-section {
  display: flex;
  justify-content: center;
  margin-bottom: 28px;
}
.autocomplete {
  position: relative;
  width: 100%;
  max-width: 560px;
}
.input-wrapper {
  display: flex;
  align-items: center;
  background: #1e293b;
  border: 2px solid #334155;
  border-radius: 10px;
  padding: 0 12px;
  transition: border-color 0.2s;
}
.input-wrapper:focus-within {
  border-color: #f59e0b;
}
.input-icon {
  font-size: 1rem;
  margin-right: 8px;
  opacity: 0.6;
}
.search-input {
  flex: 1;
  background: transparent;
  border: none;
  outline: none;
  color: #f1f5f9;
  font-size: 1rem;
  padding: 12px 0;
}
.search-input::placeholder { color: #475569; }

.suggestions-list {
  position: absolute;
  top: calc(100% + 4px);
  left: 0;
  right: 0;
  background: #1e293b;
  border: 1px solid #334155;
  border-radius: 10px;
  overflow: hidden;
  z-index: 100;
  max-height: 260px;
  overflow-y: auto;
  box-shadow: 0 8px 24px rgba(0,0,0,0.4);
}
.suggestion-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 16px;
  cursor: pointer;
  transition: background 0.15s;
}
.suggestion-item:hover { background: #334155; }
.s-marca {
  font-size: 0.78rem;
  color: #f59e0b;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  min-width: 60px;
}
.s-modelo {
  color: #e2e8f0;
  font-size: 0.95rem;
}

/* ---------- Table ---------- */
.guesses-section {
  border-radius: 10px;
  overflow: hidden;
  border: 1px solid #1e293b;
}
.table-head {
  display: grid;
  grid-template-columns: 2fr 1fr 1.2fr 0.8fr 0.8fr 1fr;
  background: #0f172a;
  padding: 10px 0;
}
.th {
  text-align: center;
  font-size: 0.7rem;
  font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.th-car { text-align: left; padding-left: 14px; }

.guess-row {
  display: grid;
  grid-template-columns: 2fr 1fr 1.2fr 0.8fr 0.8fr 1fr;
  border-top: 1px solid #1e293b;
  background: #0f172a;
}
.guess-row.guess-win .td:not(.td-car) {
  animation: pop 0.3s ease;
}
.td {
  padding: 10px 6px;
  text-align: center;
  font-size: 0.88rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 4px;
  border-left: 1px solid #1e293b;
}
.td-car {
  text-align: left;
  justify-content: flex-start;
  padding-left: 14px;
  color: #cbd5e1;
  font-size: 0.85rem;
  border-left: none;
}

/* Cell colors */
.td.correct {
  background: #166534;
  color: #bbf7d0;
}
.td.wrong {
  background: #1e293b;
  color: #94a3b8;
}
.td.low {
  background: #713f12;
  color: #fde68a;
}
.td.high {
  background: #713f12;
  color: #fde68a;
}

/* ---------- Legend ---------- */
.legend {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  justify-content: center;
  margin-top: 16px;
}
.legend-item {
  font-size: 0.75rem;
  color: #64748b;
}
.legend-item.correct { color: #22c55e; }
.legend-item.wrong   { color: #64748b; }
.legend-item.low, .legend-item.high { color: #f59e0b; }

/* ---------- Animation ---------- */
@keyframes pop {
  0%   { transform: scale(1); }
  50%  { transform: scale(1.06); }
  100% { transform: scale(1); }
}
</style>
