<script setup>
import { ref } from "vue";

const brands = ref([
    { name: "Coca-Cola", logo: "/images/front/cola.png" },
    { name: "Pepsi", logo: "/images/front/pepsi.png" },
    { name: "Fanta", logo: "/images/front/fanta.png" },
    { name: "Sprite", logo: "/images/front/sprite.png" },
    { name: "Oreo", logo: "/images/front/oreo.png" },
    { name: "Feastables", logo: "/images/front/feast.png" },
    { name: "Doritos", logo: "/images/front/doritos.png" },
    { name: "Pringles", logo: "/images/front/pringles.png" },
]);
</script>

<template>
    <section class="brands">
        <h2>Popular Brands</h2>
        <div class="brand-list">
            <div
                v-for="brand in brands"
                :key="brand.name"
                class="brand-card"
            >
                <img :src="brand.logo" :alt="brand.name" />
                <p>{{ brand.name }}</p>
            </div>
        </div>
    </section>
</template>

<style scoped>
.brands {
    padding: 20px;
    text-align: center;
}
.brands h2 {
    font-size: 1.8rem;
    margin-bottom: 20px;
}
.brand-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}
.brand-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    padding: 15px;
    width: 120px;
    text-align: center;
    transition: transform 0.2s ease;
    cursor: pointer;
}
.brand-card:hover {
    transform: scale(1.05);
}
.brand-card img {
    width: 80px;
    height: auto;
    object-fit: contain;
    margin-bottom: 10px;
}
.brand-card p {
    font-size: 0.9rem;
    font-weight: 500;
}
</style>
