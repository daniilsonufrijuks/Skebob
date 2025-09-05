<template>
    <!-- visit this -->
    <div class="product-cards-top">
        <div class="product-card-top">
            <img src="/images/front/prod1.png" alt="Product 1">
            <p>Best quality product at an affordable price.</p>
            <button onclick="location.href='https://www.asus.com/'">Go</button>
        </div>

        <div class="product-card-top">
            <img src="/images/front/prod2.png" alt="Product 2">
            <p>Limited time offer, hurry up!</p>
            <button onclick="location.href='https://www.bequiet.com/en'">Go</button>
        </div>

        <div class="product-card-top">
            <img src="/images/front/prod3.png" alt="Product 3">
            <p>Top choice among customers this month.</p>
            <button onclick="location.href='https://www.apple.com/'">Go</button>
        </div>

        <div class="product-card-top">
            <img src="/images/front/prod4.png" alt="Product 4">
            <p>Special discount for a limited period.</p>
            <button onclick="location.href='https://www.msi.com/index.php'">Go</button>
        </div>
    </div>
    <!-- visit this -->
</template>


<style scoped>
/* Cards near top*/
.product-cards-top {
    display: flex;
    justify-content: space-between;
    margin: 20px auto;
    max-width: 1200px;
    gap: 20px;
    align-items: stretch;
}

/* .product-card-top {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 23%;
    text-align: center;
    padding: 15px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
} */

.product-card-top {
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* This will push the button to the bottom */
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 23%;
    text-align: center;
    padding: 15px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%; /* Ensure cards take full available height */
    /* height: 150px; */
    min-height: 300px;
}

.product-card-top:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.product-card-top img {
    max-width: 100%;
    border-radius: 10px;
}


.product-card-top p {
    font-size: 0.9em;
    color: #666;
    margin: 10px 0;
}

.product-card-top button {
    padding: 10px 20px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.product-card-top button:hover {
    background-color: #0056b3;
}

/* Media query for phones */
@media (max-width: 768px) {
    .product-cards-top {
        flex-direction: column; /* Stack the cards vertically */
        align-items: center; /* Center the cards horizontally */
    }

    .product-card-top {
        width: 80%; /* Adjust the width of the cards */
        margin-bottom: 20px; /* Add space between the cards */
    }
}
/* Cards near top */
</style>
