<template>
    <!--    <div class="product-card">-->
    <!--        <img :src="product.img" alt="Product Image" class="product-img" />-->
    <!--        <h5>{{ product.name }}</h5>-->
    <!--        <p>{{ product.description }}</p>-->
    <!--        <p><strong>Price:</strong> {{ product.price }}</p>-->
    <!--    </div>-->

    <div class="product-cards">
        <div class="product-card">
            <img :src="item.img" style="justify-content: center; align-items: center" class="product-img" alt="Product 4">
            <h5>{{ item.name }}</h5>
            <p>{{ item.description }}.</p>
<!--            <p>Starting Bid: ${{ item.starting_bid }}</p>-->
            <p><strong>Starting Bid: $</strong> {{ item.starting_bid }}</p>
            <p><strong>Start date: {{ item.start_time}}</strong></p>
            <p><strong>End date: {{ item.end_time}}</strong></p>
            <button  @click="goToItemPage(this.item.id)">Inspect</button>
        </div>
    </div>

</template>

<script>
import { useRouter } from 'vue-router';
import {Inertia} from "@inertiajs/inertia";

export default {
    props: {
        item: {
            type: Object,
            required: true,
        },
    },
    methods: {
        goToItemPage(productId) {
            if (!productId) {
                console.error('Item ID is missing!');
                return;
            }
            console.log(productId);
            console.log(`/auctionitem?id=${productId}`);
            //Inertia.visit(`/product/${productId}`);
            //Inertia.visit(`/product?id=${productId}`);
            window.location.href = `/auctionitem?id=${productId}`;
            //this.$router.push({ path: '/product', query: { id: productId } });
        },
    },
};
</script>

<style scoped>
.product-card {
    margin: 10px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    text-align: center;
}
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
}

.product-card{
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 15px;
    width: 23%;
    text-align: center;
    align-items: center;
    justify-content: center;
    padding: 15px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    flex: 1 1 calc(50% - 10px); /* Каждая карточка занимает 50% ширины с небольшим отступом */
    margin-bottom: 50px; /* Отступ между карточками */
    flex-direction: column; /* Ensures the image and text stack */
}

.product-card:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.product-card img {
    max-width: 100%;
    height: fit-content;
    border-radius: 10px;

    /* Center the image */
    display: block;
    margin: 0 auto; /* Horizontally centers the image */
}

.product-img {
    align-self: center;
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
