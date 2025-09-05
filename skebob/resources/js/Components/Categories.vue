<template>
    <!-- Categories -->
    <div class="product-cards">
        <div class="product-card">
            <img src="/images/front/asuslaptop.png" alt="Product 1">
            <p>LAPTOPS</p>
            <button onclick="location.href='/laptops'">VISIT</button>
        </div>

        <div class="product-card">
            <img src="/images/front/pc.png" alt="Product 2">
            <p>PC</p>
            <button onclick="location.href='/pcs'">VISIT</button>
        </div>

        <div class="product-card">
            <img src="/images/front/inteli5.png" alt="Product 3">
            <p>COMPONENTS</p>
            <button onclick="location.href='/components'">VISIT</button>
        </div>

        <div class="product-card">
            <img src="/images/front/phones.png" alt="Product 5">
            <p>PHONES</p>
            <button onclick="location.href='/phones'">VISIT</button>
        </div>

        <div class="product-card">
            <img src="/images/front/keyboard.png" alt="Product 6">
            <p>PERIPHERALS</p>
            <button onclick="location.href='/peripherals'">VISIT</button>
        </div>

        <div class="product-card">
            <img src="/images/front/table.png" alt="Product 5">
            <p>FURNITURE</p>
            <button onclick="location.href='/furniture'">VISIT</button>
        </div>

        <div class="product-card">
            <img src="/images/front/cables.png" alt="Product 6">
            <p>CABLES</p>
            <button onclick="location.href='/cables'">VISIT</button>
        </div>

        <div class="product-card">
            <img src="/images/front/games.png" alt="Product 7">
            <p>GAME ZONE</p>
            <button onclick="location.href='/games'">VISIT</button>
        </div>
    </div>
    <!-- Categories -->
</template>


<style scoped>
.product-cards {
    display: flex;
    justify-content: space-between;
    margin: 20px auto;
    max-width: 1200px;
    gap: 20px;
    flex-wrap: wrap;
    position: relative;
}

.product-card{
    display: flex; /* Enables flexbox for centering */
    flex-direction: column; /* Ensures content stacks vertically */
    align-items: center; /* Centers items horizontally */
    justify-content: center; /* Centers items vertically */
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 15px;
    width: 23%;
    text-align: center;
    padding: 15px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    flex: 1 1 calc(50% - 10px); /* Each card takes 50% width with a small gap */
    margin-bottom: 50px; /* Spacing between cards */
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
</style>
