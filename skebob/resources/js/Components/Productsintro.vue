
<template>
    <div class="product-cards">
        <div class="product-card">
            <img src="https://mdbootstrap.com/img/new/standard/city/041.webp" alt="Product 1">
            <p>Best quality product at an affordable price.</p>
            <button onclick="location.href='/product'">Buy</button>
        </div>

        <div class="product-card">
            <img src="https://mdbootstrap.com/img/new/standard/city/041.webp" alt="Product 2">
            <p>Limited time offer, hurry up!</p>
            <button onclick="location.href='/product'">Buy</button>
        </div>

        <div class="product-card">
            <img src="https://mdbootstrap.com/img/new/standard/city/041.webp" alt="Product 3">
            <p>Top choice among customers this month.</p>
            <button onclick="location.href='/product'">Buy</button>
        </div>

        <div class="product-card">
            <img src="https://mdbootstrap.com/img/new/standard/city/041.webp" alt="Product 4">
            <p>Special discount for a limited period.</p>
            <button onclick="location.href='/product'">Buy</button>
        </div>
    </div>

    <div class="product-cards">
        <div class="product-card">
            <img src="https://mdbootstrap.com/img/new/standard/city/041.webp" alt="Product 1">
            <p>Best quality product at an affordable price.</p>
            <button onclick="location.href='/product'">Buy</button>
        </div>

        <div class="product-card">
            <img src="https://mdbootstrap.com/img/new/standard/city/041.webp" alt="Product 2">
            <p>Limited time offer, hurry up!</p>
            <button onclick="location.href='/product'">Buy</button>
        </div>

        <div class="product-card">
            <img src="https://mdbootstrap.com/img/new/standard/city/041.webp" alt="Product 3">
            <p>Top choice among customers this month.</p>
            <button onclick="location.href='/product'">Buy</button>
        </div>

        <div class="product-card">
            <img src="https://mdbootstrap.com/img/new/standard/city/041.webp" alt="Product 4">
            <p>Special discount for a limited period.</p>
            <button onclick="location.href='/product'">Buy</button>
        </div>
    </div>
</template>


<style scoped>
.product-cards {
    display: flex;
    justify-content: space-between;
    margin: 20px auto;
    max-width: 1200px;
    gap: 20px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    position: relative;
    margin-bottom: 70px;
}

.product-card{
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 15px;
    width: 23%;
    text-align: center;
    padding: 15px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    flex: 1 1 calc(50% - 10px); /* Каждая карточка занимает 50% ширины с небольшим отступом */
    margin-bottom: 50px; /* Отступ между карточками */
}

.product-card:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.product-card img {
    max-width: 100%;
    height: fit-content;
    border-radius: 10px;
}


.product-card p {
    font-size: 0.9em;
    color: #666;
    margin: 10px 0;
}

.product-card button {
    padding: 10px 20px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.product-card button:hover {
    background-color: #0056b3;
}


/* Media query for screens 500px or less */
@media (max-width: 500px) {
    .product-card {
        flex: 1 1 calc(50% - 5px); /* Для экранов меньше 500px, делаем карточки немного уже */
        margin-bottom: 15px;
    }
}
/* Cards near footer */
</style>
