  <template>
    <div class="image-preview-container">
      <div v-if="carImagePath" class="random-car-image">
        <img :src="carImagePath" :style="imageStyle" alt="Car of the Day">
      </div>
      <div v-else>No Car of the Day found.</div>
    </div>
  </template>

  <script>
    import axios from 'axios';

    export default {
    data() {
      return {
        carImagePath: '',
        imageStyle: {},
      };
    },
    mounted() {
      this.fetchRandomCarImage();
    },
    methods: {
      fetchRandomCarImage() {
        axios.get('/random-car-image')
          .then(response => {
            if (response.data.car_of_the_day) {
              this.carImagePath = response.data.car_of_the_day.foto;
              this.randomizeImagePosition();
            } else {
              console.error('No car of the day data received.');
            }
          })
          .catch(error => {
            console.error("Error fetching random car image:", error);
          });
      },
      randomizeImagePosition() {
        // Exemplo: Exibir uma parte 100x100px da imagem
        // const positionX = Math.random() * 100;
        // const positionY = Math.random() * 100; 
        this.imageStyle = {
          objectFit: 'cover',
          width: '2500px',
          height: '400px',
          // transform: `translate(-${positionX}px, -${positionY}px)`,
        };
      },
    },
  };
  </script>

  <style scoped>
  .image-preview-container {
    margin-top: 50px;
    width: 750px;
    height: 400px;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  </style>