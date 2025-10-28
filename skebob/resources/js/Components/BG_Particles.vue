<script setup>
import { onMounted, onBeforeUnmount, ref } from "vue";

const canvas = ref(null);
let ctx, animationFrame, particles = [];

const shapes = ["circle", "square", "triangle"];

// Fixed dimensions that never change
const FIXED_WIDTH = 1920;
const FIXED_HEIGHT = 1080;

class Particle {
    constructor() {
        this.x = Math.random() * FIXED_WIDTH;
        this.y = FIXED_HEIGHT + 20;
        this.size = (Math.random() * 10 + 10) * 3;
        this.speedY = Math.random() * 1 + 0.5;
        this.opacity = 0;
        this.life = 0;
        this.shape = shapes[Math.floor(Math.random() * shapes.length)];
        this.angle = 0;
        this.rotationSpeed = (2 * Math.PI) / (60 * 5);
    }

    update() {
        this.y -= this.speedY;
        this.life += 0.02;
        this.angle += this.rotationSpeed;

        if (this.life < 1) {
            this.opacity = this.life;
        } else {
            this.opacity = Math.max(0, 2 - this.life);
        }

        if (this.y < -20 || this.opacity <= 0) {
            this.reset();
        }
    }

    reset() {
        this.x = Math.random() * FIXED_WIDTH;
        this.y = FIXED_HEIGHT + 20;
        this.size = (Math.random() * 10 + 10) * 3;
        this.speedY = Math.random() * 1 + 0.5;
        this.opacity = 0;
        this.life = 0;
        this.shape = shapes[Math.floor(Math.random() * shapes.length)];
        this.angle = 0;
    }

    draw(ctx) {
        ctx.save();
        ctx.translate(this.x, this.y);
        ctx.rotate(this.angle);

        ctx.globalAlpha = this.opacity;
        ctx.fillStyle = "#7e411e";

        switch (this.shape) {
            case "circle":
                ctx.beginPath();
                ctx.arc(0, 0, this.size / 2, 0, Math.PI * 2);
                ctx.fill();
                break;

            case "square":
                ctx.fillRect(-this.size / 2, -this.size / 2, this.size, this.size);
                break;

            case "triangle":
                ctx.beginPath();
                ctx.moveTo(0, -this.size / 2);
                ctx.lineTo(-this.size / 2, this.size / 2);
                ctx.lineTo(this.size / 2, this.size / 2);
                ctx.closePath();
                ctx.fill();
                break;
        }

        ctx.restore();
        ctx.globalAlpha = 1.0;
    }
}

function init() {
    const canvasEl = canvas.value;
    ctx = canvasEl.getContext("2d");

    // Set fixed dimensions
    canvasEl.width = FIXED_WIDTH;
    canvasEl.height = FIXED_HEIGHT;

    particles = [];
    for (let i = 0; i < 60; i++) {
        particles.push(new Particle());
    }

    animate();
}

function animate() {
    ctx.clearRect(0, 0, FIXED_WIDTH, FIXED_HEIGHT);

    particles.forEach(p => {
        p.update();
        p.draw(ctx);
    });

    animationFrame = requestAnimationFrame(animate);
}

function handleResize() {
    // No need to reinitialize particles, just let CSS handle the scaling
}

onMounted(() => {
    init();
    window.addEventListener("resize", handleResize);
});

onBeforeUnmount(() => {
    cancelAnimationFrame(animationFrame);
    window.removeEventListener("resize", handleResize);
});
</script>

<template>
    <canvas
        ref="canvas"
        class="absolute inset-0 -z-10"
        style="width: 100vw; height: 100vh;"
    ></canvas>
</template>

<style scoped>
canvas {
    background: white;
    position: absolute;
    top: 0;
    left: 0;
    display: block;
    /* Let the browser handle scaling via CSS */
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    image-rendering: pixelated;
}
</style>
