<template>
    <section id="mysteryboxdetails" v-if="box">
        <div class="single-pro-image">
            <img :src="box.image || ''" width="50%" id="MainImg" alt="">
            <div class="small-image-group">
                <div class="small-img-col" v-for="i in 4" :key="i">
                    <img :src="box.image || ''" width="100%" class="small-img" alt="">
                </div>
            </div>
        </div>
        <div class="single-pro-details">
            <h4>{{ box.name }}</h4>
            <h2>${{ box.price }}</h2>
            <input
                type="number"
                v-model.number="quantity"
                min="1"
                @input="handleInput"
                @blur="validateQuantity"
            >
            <button class="normal" @click="addToCart(box)">Add to Cart</button>
            <h4>Box Details</h4>
            <span class="gcardt">{{ box.description }}.</span>
        </div>
    </section>
    <p v-else>Loading box details...</p>

    <transition name="slide">
        <div v-if="showNotification" class="notification">
            Item added to cart!
        </div>
    </transition>
</template>

<script>
import { useStore } from 'vuex';
import { ref } from 'vue';

export default {
    props: ['box'],
    setup(props) {
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

        const addToCart = (box) => {
            validateQuantity();
            store.commit('ADD_TO_CART', { ...box, quantity: quantity.value, type: 'mystery_box' });
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
            validateQuantity
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
#mysteryboxdetails {
    display: flex;
    margin-top: 110px;
    margin-bottom: 110px;
    justify-content: center;
    align-items: center;
    width: 80%;
    max-width: 1200px;
    padding: 50px;
    box-sizing: border-box;
    left: 15%;
    position: relative;
}

.single-pro-image {
    justify-content: center;
    align-items: center;
}

#mysteryboxdetails .single-pro-image{
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

#mysteryboxdetails .single-pro-details {
    width: 50%;
    padding-top: 30px;
}

#mysteryboxdetails .single-pro-details h4 {
    padding: 40px 0 20px 0;
    font-weight: 700;
}

#mysteryboxdetails .single-pro-details h2 {
    font-size: 26px;
    font-weight: 700;
}

#mysteryboxdetails .single-pro-details input {
    width: 50px;
    height: 47px;
    padding-left: 10px;
    font-size: 16px;
    margin-right: 10px;
}

#mysteryboxdetails .single-pro-details button {
    background-color: #7a3a7b;
    color: #e8e8e8;
    border-radius: 5px;
    padding: 5px 15px;
}

.gcardt {
    animation: animt 5s ease-in-out infinite;
}
</style>
