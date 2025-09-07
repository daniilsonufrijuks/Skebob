<template>
    <!-- Categories -->
    <div class="product-cards">
        <div class="product-card">
            <img src="/images/snacks/chips.png" alt="Chips">
            <p>CHIPS</p>
            <button onclick="location.href='/chips'">SHOP NOW</button>
        </div>

        <div class="product-card">
            <img src="/images/snacks/chocolate.png" alt="Chocolate">
            <p>CHOCOLATES</p>
            <button onclick="location.href='/chocolates'">SHOP NOW</button>
        </div>

        <div class="product-card">
            <img src="/images/snacks/drinks.png" alt="Drinks">
            <p>DRINKS</p>
            <button onclick="location.href='/drinks'">SHOP NOW</button>
        </div>

        <div class="product-card">
            <img src="/images/snacks/nuts.png" alt="Nuts">
            <p>NUTS</p>
            <button onclick="location.href='/nuts'">SHOP NOW</button>
        </div>

        <div class="product-card">
            <img src="/images/snacks/biscuits.png" alt="Biscuits">
            <p>BISCUITS</p>
            <button onclick="location.href='/biscuits'">SHOP NOW</button>
        </div>

        <div class="product-card">
            <img src="/images/snacks/fruit.png" alt="Fruit Snacks">
            <p>FRUIT SNACKS</p>
            <button onclick="location.href='/fruitsnacks'">SHOP NOW</button>
        </div>

        <div class="product-card">
            <img src="/images/snacks/candy.png" alt="Candy">
            <p>CANDY</p>
            <button onclick="location.href='/candy'">SHOP NOW</button>
        </div>

        <div class="product-card">
            <img src="/images/snacks/specials.png" alt="Specials">
            <p>SNACK BOXES</p>
            <button onclick="location.href='/snackboxes'">SHOP NOW</button>
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
        flex: 1 1 calc(50% - 5px);
        margin-bottom: 15px;
    }
}
</style>
