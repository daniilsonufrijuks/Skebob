<template>
    <section id="productdetails" v-if="product">
        <div class="single-pro-image">
            <img :src="product.image || ''" width="50%" id="MainImg" alt="">
            <div class="small-image-group">
                <div class="small-img-col" v-for="i in 4" :key="i">
                    <img :src="product.image || '' " width="100%" class="small-img" alt="">
                </div>
            </div>
        </div>
        <div class="single-pro-details">
            <h6>{{ product.category }}</h6>
            <h4>{{ product.name }}</h4>
            <h2>${{ product.price }}</h2>
            <!--            <select>-->
            <!--                <option>Select option</option>-->
            <!--                <option>Box</option>-->
            <!--                <option>Single</option>-->
            <!--            </select>-->
            <input
                type="number"
                v-model.number="quantity"
                min="1"
                @input="handleInput"
                @blur="validateQuantity"
            >
<!--            <button class="normal" @click="addToCart(product)">Add to Cart</button>-->
<!--            <h4>Product Details</h4>-->
            <button class="normal" @click="addToCart(product)">{{ $t('AddToCart') }}</button>
            <h4>{{ $t('ProductDetails') }}</h4>
            <span class="gcardt">{{ product.ingredients }}. </span>
            <span class="gcardt">{{ product.country_origin }}.</span>
        </div>
    </section>
    <p v-else>Loading product details...</p>

    <!-- Notification Slider -->
    <transition name="slide">
        <div v-if="showNotification" class="notification">
            {{ $t('ItemAddedToCart') }}!
        </div>
<!--        <div v-if="showNotification" class="notification">-->
<!--            Item added to cart!-->
<!--        </div>-->
    </transition>
</template>

<script>
import { useStore } from 'vuex';
import {ref} from "vue";

export default {
    props: ['product'],
    setup(props) {
        console.log('ProductDetails props:', props.product);
        const store = useStore();
        const quantity = ref(1);
        const showNotification = ref(false);
        let isUserTyping = ref(false);

        const handleInput = (event) => {
            const value = event.target.value;
            if (value === '') {
                isUserTyping = true;
                return;
            }
            const numValue = parseInt(value);
            if (isNaN(numValue) || numValue < 1) {
                quantity.value = 1;
                isUserTyping = false;
            } else {
                quantity.value = numValue;
                isUserTyping = false;
            }
        };

        const validateQuantity = () => {
            if (quantity.value < 1 || isNaN(quantity.value)) {
                quantity.value = 1;
            }
            isUserTyping = false;
        };

        const addToCart = (product) => {
            validateQuantity();
            store.commit('ADD_TO_CART', { ...product, quantity: quantity.value });
            console.log("added", product);
            showNotification.value = true;
            setTimeout(() => {
                showNotification.value = false;
            }, 3000);
        };

        return {
            quantity,
            addToCart,
            showNotification,
            handleInput,
            validateQuantity,
        };
    },
};
</script>

<style scoped>

.notification {
    position: fixed;
    bottom: 100px;
    right: 20px;
    background-color: #7a3a7b;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    z-index: 1000;
    transform: translateX(10%);
    transition: transform 0.5s ease-in-out;
}

.notification-enter-active, .notification-leave-active {
    transition: transform 0.5s ease-in-out;
}

.notification-enter, .notification-leave-to {
    transform: translateX(100%);
}

.notification-enter-to, .notification-leave {
    transform: translateX(0);
}

/* product */
#productdetails {
    display: flex;
    margin-top: 110px;
    margin-bottom: 110px;
    justify-content: center;
    align-items: center;
    width: 80%;
    max-width: 1200px;
    padding: 50px;
    box-sizing: border-box;
    /* left: 100px; */
    left: 15%;
    position: relative;
}

.single-pro-image {
    justify-content: center;
    align-items: center;
}

#productdetails .single-pro-image{
    width: 40%;
    margin-right: 50px;
}

.small-image-group {
    display: flex;
    justify-content: space-between;
}

.small-img-col {
    flex-basis: 24%;
    cursor: pointer;
}

#productdetails .single-pro-details {
    width: 50%;
    padding-top: 30px;
}

#productdetails .single-pro-details h4 {
    padding: 40px 0 20px 0;
    font-weight: 700;
}

#productdetails .single-pro-details h2 {
    font-size: 26px;
    font-weight: 700;
}

#productdetails .single-pro-details select {
    display: block;
    padding: 5px 10px;
    margin-bottom: 10px;
}

#productdetails .single-pro-details input {
    width: 50px;
    height: 47px;
    padding-left: 10px;
    font-size: 16px;
    margin-right: 10px;
}

#productdetails .single-pro-details button {
    background-color: #7a3a7b;
    color: #e8e8e8;
    border-radius: 5px;
    padding: 5px 15px;
}

#productdetails .single-pro-details input:focus {
    outline: none;
}

#productdetails .single-pro-details span {
    line-height: 25px;
}

.gcardt {
    animation: animt 5s ease-in-out infinite;
}

@keyframes animt {
    0% {
        color: #9a73a1;
    }

    50% {
        color: #8b2c84;
    }

    100% {
        color: #5c0a55;
    }
}

@media (max-width: 768px) {
    #productdetails {
        display: flex;
        flex-direction: column;
    }

    #productdetails .single-pro-image {
        width: 100%;
        margin-right: 0px;
    }

    #productdetails .single-pro-details {
        width: 100%;
    }
}

</style>
