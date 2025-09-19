<script setup>
import { onMounted, onBeforeUnmount, ref } from "vue";

const canvas = ref(null);
let ctx, animationFrame, particles = [];

const shapes = ["circle", "square", "triangle"];

class Particle {
    constructor(width, height) {
        this.x = Math.random() * width;
        this.y = height + 20;
        this.size = (Math.random() * 10 + 10) * 3;
        this.speedY = Math.random() * 1 + 0.5;
        this.opacity = 0;
        this.life = 0;
        this.shape = shapes[Math.floor(Math.random() * shapes.length)];

        this.angle = 0; // rotation angle in radians
        this.rotationSpeed = (2 * Math.PI) / (60 * 5);
        // 1 rotation every 5 seconds @ ~60fps
    }

    update(height) {
        this.y -= this.speedY;
        this.life += 0.02;
        this.angle += this.rotationSpeed;

        if (this.life < 1) {
            this.opacity = this.life;
        } else {
            this.opacity = Math.max(0, 2 - this.life);
        }

        if (this.y < -20 || this.opacity <= 0) {
            this.reset(height);
        }
    }

    reset(height) {
        this.x = Math.random() * canvas.value.width;
        this.y = height + 20;
        this.size = (Math.random() * 10 + 10) * 3;
        this.speedY = Math.random() * 2 + 0.5;
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
    const width = canvas.value.width = window.innerWidth;
    const height = canvas.value.height = window.innerHeight;
    ctx = canvas.value.getContext("2d");

    particles = [];
    for (let i = 0; i < 60; i++) {
        particles.push(new Particle(width, height));
    }

    animate();
}

function animate() {
    const width = canvas.value.width;
    const height = canvas.value.height;

    ctx.clearRect(0, 0, width, height);

    particles.forEach(p => {
        p.update(height);
        p.draw(ctx);
    });

    animationFrame = requestAnimationFrame(animate);
}

onMounted(() => {
    init();
    window.addEventListener("resize", init);
});

onBeforeUnmount(() => {
    cancelAnimationFrame(animationFrame);
    window.removeEventListener("resize", init);
});
</script>

<template>
    <canvas ref="canvas" class="absolute inset-0 -z-10"></canvas>
</template>

<style scoped>
canvas {
    background: white; /* or transparent if you want overlay effect */
    position: absolute;
    top: 0;
    left: 0;
    width: 100vw;   /* viewport width */
    height: 100vh;  /* viewport height */
    display: block;
}
</style>
