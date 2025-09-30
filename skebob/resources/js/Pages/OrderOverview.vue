<template>
    <Navbar :routes="routes"/>
    <Search />
    <div class="main-container">
        <div class="order-container">
            <h2 class="order-title">Order Overview</h2>

            <!-- Products Overview Section -->
            <div class="products-section">
                <h3>Products in Your Order</h3>
                <div v-if="cartItems.length > 0">
                    <div class="order-item" v-for="item in cartItems" :key="item.id">
                        <img :src="item.image" alt="Product Image" class="order-item-img" />
                        <div class="order-item-details">
                            <h4>{{ item.name }}</h4>
                            <p>{{ item.description }}</p>
                            <p>Price: ${{ item.price }}</p>
                            <p>Quantity: {{ item.quantity }}</p>
                            <p class="item-total">Item Total: ${{ (item.price * item.quantity).toFixed(2) }}</p>
                        </div>
                    </div>
                </div>
                <p v-else class="empty-message">No items in your order.</p>
            </div>

            <!-- Shipping Address Section -->
            <div class="shipping-section">
                <h3>Shipping Information</h3>
                <form @submit.prevent="validateAndProceed" class="shipping-form">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input
                                type="email"
                                id="email"
                                v-model="shippingAddress.email"
                                required
                                placeholder="Enter your email"
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Street Address *</label>
                        <input
                            type="text"
                            id="address"
                            v-model="shippingAddress.address"
                            required
                            placeholder="Enter your street address"
                        >
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City *</label>
                            <input
                                type="text"
                                id="city"
                                v-model="shippingAddress.city"
                                required
                                placeholder="Enter your city"
                            >
                        </div>
                        <div class="form-group">
                            <label for="zipCode">ZIP Code *</label>
                            <input
                                type="text"
                                id="zipCode"
                                v-model="shippingAddress.zipCode"
                                required
                                placeholder="Enter ZIP code"
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="country">Country *</label>
                        <input
                            type="text"
                            id="country"
                            v-model="shippingAddress.country"
                            required
                            placeholder="Enter your country"
                        >
                    </div>
                </form>
            </div>

            <!-- Order Summary Section -->
            <div class="order-summary">
                <h3>Order Summary</h3>
                <div class="summary-details">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>${{ cartTotal.toFixed(2) }}</span>
                    </div>
                    <div class="summary-row total-row">
                        <span><strong>Total:</strong></span>
                        <span><strong>${{ orderTotal.toFixed(2) }}</strong></span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="order-actions">
                <button @click="goBackToCart" class="back-button">
                    ← Back to Cart
                </button>
                <button @click="validateAndProceed" class="checkout-button">
                    Proceed to Checkout
                </button>
            </div>
        </div>
        <Contact />
    </div>
    <Footer />
</template>

<script>
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import Search from "../Components/Search.vue";
import Contact from "../Components/Contact.vue";
import { useStore } from "vuex";
import { computed, ref } from "vue";
import { useRouter } from "vue-router";
import {loadStripe} from "@stripe/stripe-js";

export default {
    name: 'OrderOverview',
    components: {
        Navbar,
        Footer,
        Search,
        Contact
    },
    props: {
        routes: Object,
    },
    setup() {
        const store = useStore();
        const router = useRouter();

        const cartItems = computed(() => store.getters.cartItems);
        const cartTotal = computed(() => store.getters.cartTotal);

        const orderTotal = cartTotal;

        // Shipping address form
        const shippingAddress = ref({
            email: '',
            address: '',
            city: '',
            zipCode: '',
            country: '',
        });

        const validateAndProceed = async () => {
            const requiredFields = ['email', 'address', 'city', 'zipCode', 'country'];
            const missingFields = requiredFields.filter(field => !shippingAddress.value[field]);
            if (missingFields.length > 0) {
                alert('Please fill in all required fields.');
                return;
            }
            if (cartItems.value.length === 0) {
                alert('Your cart is empty. Please add items before proceeding.');
                return;
            }
            try {
                const orderData = {
                    items: cartItems.value.map(item => ({
                        id: item.id,
                        name: item.name,
                        price: parseFloat(item.price),
                        quantity: parseInt(item.quantity),
                        image: item.image || '',
                        total_price: parseFloat(item.price) * item.quantity
                    })),
                    shipping_address: shippingAddress.value,
                    subtotal: cartTotal.value,
                    total: orderTotal.value
                };

                const orderResponse = await axios.post('/order', {
                    items: orderData,
                    // total: store.state.cart.reduce((sum, item) => sum + item.price * item.quantity, 0),
                    total: store.state.cart.reduce(
                        (sum, item) => sum + parseFloat(item.price) * parseInt(item.quantity),
                        0
                    ),
                });

                // stripe
                const response = await axios.post('/stripe/checkout', {
                    items: orderData,
                });
                // const stripe = await loadStripe(import.meta.env.VITE_STRIPE_KEY); // public key
                const stripeKey = import.meta.env.VITE_STRIPE_KEY;

                if (!stripeKey) {
                    console.error('Stripe public key is not defined in the environment variables.');
                    return;
                }
                const stripe = await loadStripe(stripeKey);
                await stripe.redirectToCheckout({ sessionId: response.data.id });
                console.log('Order Response:', orderResponse.data);

                // Optionally clear cart after successful checkout
                store.commit('CLEAR_CART');
                // const stripe = await loadStripe("");
                // await stripe.redirectToCheckout({ sessionId: response.data.id });
                // Redirect to home page
                // window.location.href = `/`;

            } catch (error) {
                console.error('Error processing order:', error);
                alert('There was an error processing your order. Please try again.');
            }
        };

        const goBackToCart = () => {
            window.history.back();
        };

        return {
            cartItems,
            cartTotal,
            orderTotal,
            shippingAddress,
            validateAndProceed,
            goBackToCart
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

.order-container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.order-title {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
    font-size: 2rem;
}

.products-section,
.shipping-section,
.order-summary {
    background: #f9f9f9;
    padding: 25px;
    border-radius: 8px;
    margin-bottom: 25px;
    border: 1px solid #e0e0e0;
}

.products-section h3,
.shipping-section h3,
.order-summary h3 {
    color: #333;
    margin-bottom: 20px;
    border-bottom: 2px solid #d87220;
    padding-bottom: 10px;
}

/* Order Items Styling */
.order-item {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    padding: 15px;
    background: white;
    border-radius: 6px;
    margin-bottom: 15px;
    border-left: 4px solid #d87220;
}

.order-item-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
}

.order-item-details {
    flex-grow: 1;
}

.order-item-details h4 {
    margin: 0 0 8px 0;
    color: #333;
}

.order-item-details p {
    margin: 4px 0;
    color: #666;
}

.item-total {
    font-weight: bold;
    color: #d87220 !important;
}

.empty-message {
    text-align: center;
    color: #666;
    font-style: italic;
}

/* Form Styling */
.shipping-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
}

.form-group input,
.form-group textarea {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #d87220;
    box-shadow: 0 0 0 2px rgba(216, 114, 32, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 80px;
}

/* Order Summary Styling */
.summary-details {
    background: white;
    padding: 20px;
    border-radius: 6px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.total-row {
    border-top: 2px solid #d87220;
    border-bottom: none;
    font-size: 1.1rem;
    margin-top: 10px;
    padding-top: 15px;
}

/* Action Buttons */
.order-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.back-button {
    padding: 12px 24px;
    background-color: #6c757d;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.back-button:hover {
    background-color: #545b62;
}

.checkout-button {
    padding: 15px 30px;
    background-color: #d87220;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 18px;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

.checkout-button:hover {
    background-color: #a5500d;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .order-item {
        flex-direction: column;
        text-align: center;
    }

    .order-item-img {
        align-self: center;
    }

    .order-actions {
        flex-direction: column;
        gap: 15px;
    }

    .back-button,
    .checkout-button {
        width: 100%;
    }
}
</style>
