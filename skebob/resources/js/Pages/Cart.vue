<template>
    <!--    <Navbar :routes="routes" />-->
    <Navbar :routes="routes"/>
    <Search />
    <div class="main-container">
        <div class="cart-container">
            <h2>{{ $t('YourShoppingCart') }}</h2>
<!--            <h2>Your Shopping Cart</h2>-->

            <div v-if="cartItems.length > 0">
                <div class="cart-item" v-for="item in cartItems" :key="item.id">
                    <img :src="item.image" alt="Product Image" class="cart-item-img" />
                    <div class="cart-item-details">
                        <h3>{{ item.name }}</h3>
                        <p>{{ item.description }}</p>
                        <p>{{ $t('Price') }}: ${{ item.price }}</p>
                        <p>{{ $t('Quantity') }}: {{ item.quantity }}</p>
                        <button @click="removeFromCart(item.id)" class="remove-btn">{{ $t('RemoveItem') }}</button>
<!--                        <button @click="removeFromCart(item.id)" class="remove-btn">Remove Item</button>-->
                    </div>
                </div>
                <div class="clear-cart">
                    <button @click="clearCart" class="clear-btn">{{ $t('ClearEntireCart') }}</button>
<!--                    <button @click="clearCart" class="clear-btn">Clear Entire Cart</button>-->
                </div>
            </div>
            <p v-else style="text-align: center;">{{ $t('YourCartIsEmpty') }}.</p>
<!--            <p v-else style="text-align: center;">Your cart is empty.</p>-->

            <div class="cart-total" v-if="cartItems.length > 0">
                <span>{{ $t('total') }}: ${{ cartTotal.toFixed(2) }}</span>
<!--                <span>Total: ${{ cartTotal.toFixed(2) }}</span>-->
                <button @click="proceedToCheckout" class="checkout-btn">{{ $t('ProceedToCheckout') }}</button>
<!--                <button @click="proceedToCheckout" class="checkout-btn">Proceed to Checkout</button>-->
            </div>
        </div>
        <Contact />
    </div>
    <Footer />
</template>

<script>
import Visitit from '../Components/Visitit.vue';
import Slider from '../Components/Slider.vue';
import Productsintro from "../Components/Productsintro.vue";
import Contact from "../Components/Contact.vue";
import Search from "../Components/Search.vue";
import Testimonial from "../Components/Testimonial.vue";
import AboutUsText from "../Components/AboutUsText.vue";
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import ProductCard from "@/Components/ProductCard.vue";
import {mapState, useStore} from "vuex";
import {computed} from "vue";
import {usePage} from "@inertiajs/vue3";
import {loadStripe} from "@stripe/stripe-js";
import {useUser} from "../Composables/useUser.js";
// import * as response from "autoprefixer";

export default {
    name: 'Cart',
    components: {
        ProductCard,
        Navbar,
        Visitit,
        Slider,
        Productsintro,
        Contact,
        Search,
        Testimonial,
        AboutUsText,
        Footer
    },
    props: {
        routes: Object,
        cartItems: {
            type: Array,
            required: true,
        },
        products: {
            type: Object,
            required: true,
        },
    },
    setup()
    {
        const { isLoggedIn, user } = useUser();
        const store = useStore();

        const cartItems = computed(() => store.getters.cartItems);
        console.log(cartItems.value);
        const cartTotal = computed(() => store.getters.cartTotal);

        const removeFromCart = (productId) => {
            store.commit('REMOVE_FROM_CART', productId);
        };
        const page = usePage();
        const isAuthenticated = isLoggedIn;
        const clearCart = () => {
            store.commit('CLEAR_CART');
        };

        const proceedToCheckout = async () => {
            try {
                console.log('Cart items before checkout:', store.state.cart, Array.isArray(store.state.cart));
                if (Array.isArray(store.state.cart) && store.state.cart.length > 0) {
                    if (!isAuthenticated.value) {
                        window.location.href = `/login`;
                        console.log("Please log in first.");
                    } else {
                        sessionStorage.setItem('pendingOrder', JSON.stringify(store.state.cart));
                        window.location.href = '/order-overview';
                    }
                }
            } catch (error) {
                console.error("Error during checkout:", error);
            }
        };

        return {
            cartItems,
            cartTotal,
            removeFromCart,
            clearCart,
            proceedToCheckout,
        };
    }
}
</script>

<style scoped>
.main-container {
    display: flex;
    flex-direction: column;
    gap: 70px;
}

.cart-container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.cart-container h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
}

.cart-item {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    padding: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.cart-item-img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 4px;
}

.cart-item-details {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.cart-item-details h3 {
    margin: 0;
    color: #333;
    font-size: 1.2em;
}

.cart-item-details p {
    margin: 0;
    color: #666;
}

.remove-btn {
    align-self: flex-start;
    padding: 8px 16px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9em;
    margin-top: 10px;
    transition: background-color 0.3s;
}

.remove-btn:hover {
    background-color: #c82333;
}

.cart-total {
    margin-top: 30px;
    font-size: 18px;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.clear-cart {
    margin-top: 30px;
    font-size: 18px;
    font-weight: bold;
    display: flex;
    justify-content: center !important;
    align-items: center !important;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.clear-cart button {
    padding: 10px 20px;
    background-color: #d87220;
    color: white;
    border: none;
    cursor: pointer;
}

.clear-cart button:hover {
    background-color: #a5500d;
}

.clear-btn:hover {
    background-color: #5a6268;
}

.cart-total button {
    padding: 10px 20px;
    margin-left: 30px;
    background-color: #d87220;
    color: white;
    border: none;
    cursor: pointer;
}

.cart-total button:hover {
    background-color: #a5500d;
}

.cart-item {
    display: flex;
    gap: 20px;
    align-items: center;
    margin-bottom: 20px;
}

.cart-item-img {
    width: 100px;
    height: auto;
}

.checkout-btn {
    padding: 12px 24px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s;
}

.checkout-btn:hover {
    background-color: #218838;
}

@media (max-width: 768px) {
    .cart-item {
        flex-direction: column;
        text-align: center;
    }

    .cart-item-img {
        width: 100%;
        max-width: 200px;
        margin: 0 auto;
    }

    .cart-total {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .remove-btn {
        align-self: center;
    }
}
</style>
