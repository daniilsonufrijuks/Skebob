<script setup>
const goToMysteryBox = () => {
    window.location.href = "/mystery-box"; // 🔗 Link to your mystery box page
};
</script>

<template>
    <section class="mystery-banner" @click="goToMysteryBox">
        <div class="content">
            <h2>🎁 Mystery Box</h2>
            <p>Get exclusive snacks & drinks inside every box!</p>
            <button>Shop Now</button>
        </div>
        <img src="/images/front/mysterybox.png" alt="Mystery Box" class="mystery-img" />
    </section>
</template>

<style scoped>
.mystery-banner {
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #ff914d, #ff3c6e);
    color: #fff;
    padding: 30px;
    border-radius: 15px;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    max-width: 1000px;
    margin: 20px auto;
    width: 100%;
    justify-content: space-between
}
.mystery-banner:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}
.content {
    max-width: 60%;
}
.content h2 {
    font-size: 2rem;
    margin: 0 0 10px;
}
.content p {
    font-size: 1rem;
    margin-bottom: 15px;
}
.content button {
    background: #fff;
    color: #ff3c6e;
    border: none;
    padding: 10px 18px;
    font-size: 1rem;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
}
.content button:hover {
    background: #f0f0f0;
}
.mystery-img {
    width: 150px;
    height: auto;
    border-radius: 10px;
}
@media (max-width: 768px) {
    .mystery-banner {
        flex-direction: column;
        text-align: center;
    }
    .content {
        max-width: 100%;
        margin-bottom: 20px;
    }
    .mystery-img {
        width: 120px;
    }
}
</style>
