<template>
    <div class="image-preview-container">
      teste
        @if(isset($car_of_the_day))
            <div class="random-car-image"><img src="{{ asset($car_of_the_day->foto) }}" alt=""></div>
        @else
            <div>No Car of the Day found.</div>
        @endif
      <!-- <img :src="carImagePath" :style="imageStyle"> -->
    </div>
  </template>
  
  <script>
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
            this.carImagePath = response.data.imagePath;
            this.randomizeImagePosition();
          });
      },
      randomizeImagePosition() {
        // Exemplo: Exibir uma parte 100x100px da imagem
        const positionX = Math.random() * 100; // Ajuste conforme necessário
        const positionY = Math.random() * 100; // Ajuste conforme necessário
        this.imageStyle = {
          objectFit: 'cover',
          width: '100px',
          height: '100px',
          transform: `translate(-${positionX}px, -${positionY}px)`,
        };
      },
    },
  };
  </script>
  
  <style scoped>
  .image-preview-container {
    width: 100px;
    height: 100px;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  </style>