<script setup lang="ts">
import Footer from "./Footer.vue";
</script>

<template>
    <footer class="footer">
        <div class="waves">
            <div class="wave" id="wave1"></div>
            <div class="wave" id="wave2"></div>
            <div class="wave" id="wave3"></div>
            <div class="wave" id="wave4"></div>
        </div>
    </footer>
</template>

<style scoped>
.footer {
    background: #d87220;
    text-align: center;
    position: relative;
    bottom: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    margin: 0;
}

/* waves */
.wave {
    position: absolute;
    top: -100px;
    left: 0;
    width: 100%;
    height: 100px;
    background: url("/images/front/wave.png");
    background-size: 1000px 100px;
}

.wave#wave1 {
    z-index: 1000;
    opacity: 1;
    bottom: 0;
    animation: animateWaves 4s linear infinite;
}

.wave#wave2 {
    z-index: 999;
    opacity: 0.5;
    bottom: 10px;
    animation: animate 4s linear infinite !important;
}

.wave#wave3 {
    z-index: 1000;
    opacity: 0.2;
    bottom: 15px;
    animation: animateWaves 3s linear infinite;
}

.wave#wave4 {
    z-index: 999;
    opacity: 0.7;
    bottom: 20px;
    animation: animate 3s linear infinite;
}

/* animations */
@keyframes animateWaves {
    0% {
        background-position-x: 1000px;
    }
    100% {
        background-positon-x: 0px;
    }
}

@keyframes animate {
    0% {
        background-position-x: -1000px;
    }
    100% {
        background-positon-x: 0px;
    }
}
</style>
