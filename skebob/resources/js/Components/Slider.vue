<template>
    <div class="slider">
        <div class="slider-wrapper" :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
            <div v-for="(photo, index) in photos" :key="index" class="slider-item">
                <img :src="photo" alt="Slider Image" />
            </div>
        </div>

      <span
          v-for="(photo, index) in photos"
          :key="'dot-' + index"
          :class="{ active: index === currentIndex }"
          @click="goToSlide(index)"
      ></span>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

// Array of image URLs
const photos = [
    "../images/front/slbg1.png",
    "../images/front/slbg2.png",
    "../images/front/slbg3.png",
    "../images/front/slbg4.jpg",
    "../images/front/slbg5.jpg",
];

const currentIndex = ref(0);
let autoplayInterval = null;

// Functions
const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % photos.length;
};

const goToSlide = (index) => {
    currentIndex.value = index;
};

// Autoplay functionality
const startAutoplay = () => {
    autoplayInterval = setInterval(() => {
        nextSlide();
    }, 3000); // Change slide every 3 seconds
};

const stopAutoplay = () => {
    clearInterval(autoplayInterval);
};

onMounted(() => {
    startAutoplay();
});

onUnmounted(() => {
    stopAutoplay();
});
</script>

<style scoped>
/* Container styles */
.slider {
    position: relative;
    width: 100%;
    max-width: 1200px;
    margin: auto;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Slider wrapper */
.slider-wrapper {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

/* Slider items */
.slider-item {
    min-width: 100%;
}

.slider-item img {
    width: 100%;
    display: block;
    object-fit: cover;
}


/*@media screen and (max-width: 768px) {
    .slider {
        height: 550px;
    }
}
*/
</style>
