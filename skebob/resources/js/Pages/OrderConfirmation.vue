<template>
    <Navbar :routes="routes"/>
    <Search />
    <div class="main-container">
        <div class="confirmation-container">
            <!-- Success Header -->
            <div class="success-header">
                <div class="success-icon">✓</div>
                <h1 class="success-title">Order Confirmed!</h1>
                <p class="success-message">Thank you for your purchase. Your order has been successfully processed.</p>
            </div>

            <!-- Order Details -->
            <div class="order-details-section">
                <h2 class="section-title">Order Details</h2>

                <div class="details-grid">
                    <div class="detail-item">
                        <span class="detail-label">Order ID:</span>
                        <span class="detail-value">#{{ order?.id || 'Loading...' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Order Date:</span>
                        <span class="detail-value">{{ orderDate }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Order Status:</span>
                        <span class="status-badge paid">Paid</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Total Amount:</span>
                        <span class="detail-value total-amount">${{ order?.total_price?.toFixed(2) || '0.00' }}</span>
                    </div>
                </div>
            </div>

            <!-- Products Summary -->
            <div class="products-section">
                <h3 class="section-title">Order Items</h3>
                <div v-if="orderItems.length > 0">
                    <div class="order-item" v-for="item in orderItems" :key="item.id">
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
                <div v-else class="loading-message">
                    Loading order items...
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="shipping-section" v-if="order?.shipping_address">
                <h3 class="section-title">Shipping Information</h3>
                <div class="shipping-details">
                    <p><strong>Shipping Address:</strong></p>
                    <p>{{ order.shipping_address }}</p>
                </div>
            </div>

            <!-- Order Summary -->
<!--            <div class="order-summary">-->
<!--                <h3 class="section-title">Order Summary</h3>-->
<!--                <div class="summary-details">-->
<!--                    <div class="summary-row">-->
<!--                        <span>Subtotal:</span>-->
<!--                        <span>${{ subtotal.toFixed(2) }}</span>-->
<!--                    </div>-->
<!--                    <div class="summary-row">-->
<!--                        <span>Shipping:</span>-->
<!--                        <span>${{ shippingCost.toFixed(2) }}</span>-->
<!--                    </div>-->
<!--                    <div class="summary-row total-row">-->
<!--                        <span><strong>Total:</strong></span>-->
<!--                        <span><strong>${{ total.toFixed(2) }}</strong></span>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

            <!-- Next Steps -->
            <div class="next-steps-section">
                <h3 class="section-title">What's Next?</h3>
                <div class="steps-grid">
                    <div class="step-item">
                        <div class="step-icon">📧</div>
                        <div class="step-content">
                            <h4>Order Confirmation</h4>
                            <p>You will receive an email confirmation shortly with your order details.</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-icon">🚚</div>
                        <div class="step-content">
                            <h4>Shipping Updates</h4>
                            <p>We'll send you tracking information once your order ships.</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-icon">⏱️</div>
                        <div class="step-content">
                            <h4>Delivery Time</h4>
                            <p>Most orders are delivered within 3-5 business days.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="confirmation-actions">
                <button @click="continueShopping" class="continue-shopping-button">
                    Continue Shopping
                </button>
<!--                <button @click="viewOrderHistory" class="order-history-button">-->
<!--                    View Order History-->
<!--                </button>-->
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
import { useRouter } from "vue-router";
import { ref, onMounted, computed } from "vue";
import { useUser } from "../Composables/useUser.js";

export default {
    name: 'OrderConfirmation',
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
        const router = useRouter();
        const { user } = useUser();

        const order = ref(null);
        const orderItems = ref([]);
        const loading = ref(true);

        const orderDate = computed(() => {
            if (order.value?.ordered_at) {
                return new Date(order.value.ordered_at).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
            return new Date().toLocaleDateString();
        });

        const subtotal = computed(() => {
            return orderItems.value.reduce((total, item) => {
                return total + (item.price * item.quantity);
            }, 0);
        });

        const shippingCost = computed(() => {
            return order.value ? (order.value.total_price - subtotal.value) : 0;
        });

        const total = computed(() => {
            return order.value?.total_price || 0;
        });

        const fetchOrderDetails = async () => {
            try {
                // Try to get order data from URL parameters
                const urlParams = new URLSearchParams(window.location.search);
                const orderId = urlParams.get('order_id');

                console.log('Order ID from URL:', orderId);

                if (orderId) {
                    try {
                        // Fetch order details from API - use the correct endpoint
                        const response = await axios.get(`/api/orders/${orderId}`);
                        console.log('API response:', response.data);

                        if (response.data && response.data.order) {
                            order.value = response.data.order;
                            orderItems.value = response.data.items || [];
                            loading.value = false;

                            // Also store in sessionStorage as backup
                            sessionStorage.setItem('lastOrder', JSON.stringify({
                                order: response.data.order,
                                items: response.data.items
                            }));
                            return;
                        }
                    } catch (apiError) {
                        console.error('API fetch failed:', apiError);
                        // Continue to fallback methods
                    }
                }

                // Fallback 1: Check sessionStorage for last order
                const lastOrder = sessionStorage.getItem('lastOrder');
                if (lastOrder) {
                    try {
                        const orderData = JSON.parse(lastOrder);
                        order.value = orderData.order;
                        orderItems.value = orderData.items || [];
                        loading.value = false;
                        return;
                    } catch (e) {
                        console.error('Error parsing lastOrder from sessionStorage:', e);
                    }
                }

                // Fallback 2: Check for pending order data
                const pendingOrder = sessionStorage.getItem('pendingOrder');
                const shippingInfo = sessionStorage.getItem('shippingInfo');

                console.log('Pending order from session:', pendingOrder);
                console.log('Shipping info from session:', shippingInfo);

                if (pendingOrder) {
                    orderItems.value = JSON.parse(pendingOrder);
                }

                // Create order object from available data
                const calculatedTotal = orderItems.value.reduce((total, item) => {
                    return total + (parseFloat(item.price) * parseInt(item.quantity));
                }, 0);

                order.value = {
                    id: orderId || Math.floor(100000 + Math.random() * 900000),
                    total_price: calculatedTotal,
                    shipping_address: shippingInfo ? JSON.parse(shippingInfo).address : 'Address information will be displayed here',
                    ordered_at: new Date().toISOString(),
                    status: 'paid'
                };

                loading.value = false;

            } catch (error) {
                console.error('Error fetching order details:', error);

                // Final fallback: create empty order
                order.value = {
                    id: Math.floor(100000 + Math.random() * 900000),
                    total_price: 0,
                    shipping_address: 'No shipping address available',
                    ordered_at: new Date().toISOString(),
                    status: 'paid'
                };
                orderItems.value = [];
                loading.value = false;
            }
        };

        const continueShopping = () => {
            sessionStorage.removeItem('pendingOrder');
            sessionStorage.removeItem('shippingInfo');
            window.location.href ='/'
        };

        // const viewOrderHistory = () => {
        //     router.push('/order-history');
        // };

        onMounted(() => {
            fetchOrderDetails();
        });

        return {
            order,
            orderItems,
            orderDate,
            subtotal,
            shippingCost,
            total,
            loading,
            continueShopping,
            // viewOrderHistory
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

.confirmation-container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.success-header {
    text-align: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 40px;
    border-radius: 12px;
    margin-bottom: 40px;
    border: 2px solid #d4edda;
}

.success-icon {
    width: 80px;
    height: 80px;
    background-color: #28a745;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    margin: 0 auto 20px;
    font-weight: bold;
}

.success-title {
    color: #28a745;
    margin-bottom: 15px;
    font-size: 2.5rem;
    font-weight: 700;
}

.success-message {
    color: #666;
    font-size: 1.2rem;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.order-details-section,
.products-section,
.shipping-section,
.order-summary,
.next-steps-section {
    background: #f9f9f9;
    padding: 25px;
    border-radius: 8px;
    margin-bottom: 25px;
    border: 1px solid #e0e0e0;
}

.section-title {
    color: #333;
    margin-bottom: 20px;
    border-bottom: 2px solid #d87220;
    padding-bottom: 10px;
    font-size: 1.5rem;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: white;
    border-radius: 6px;
    border-left: 4px solid #d87220;
}

.detail-label {
    font-weight: 600;
    color: #333;
}

.detail-value {
    color: #666;
}

.total-amount {
    font-weight: bold;
    color: #d87220;
    font-size: 1.2rem;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-badge.paid {
    background-color: #d4edda;
    color: #155724;
}

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

.loading-message {
    text-align: center;
    color: #666;
    font-style: italic;
    padding: 40px;
}

.shipping-details {
    background: white;
    padding: 20px;
    border-radius: 6px;
}

.shipping-details p {
    margin: 8px 0;
    color: #666;
}

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

.steps-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.step-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 20px;
    background: white;
    border-radius: 8px;
    border-left: 4px solid #d87220;
}

.step-icon {
    font-size: 2rem;
    flex-shrink: 0;
}

.step-content h4 {
    margin: 0 0 8px 0;
    color: #333;
}

.step-content p {
    margin: 0;
    color: #666;
    line-height: 1.5;
}

.confirmation-actions {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid #eee;
}

.continue-shopping-button,
.order-history-button {
    padding: 15px 30px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    min-width: 200px;
}

.continue-shopping-button {
    background-color: #d87220;
    color: white;
}

.continue-shopping-button:hover {
    background-color: #a5500d;
}

.order-history-button {
    background-color: #6c757d;
    color: white;
}

.order-history-button:hover {
    background-color: #545b62;
}

@media (max-width: 768px) {
    .confirmation-container {
        padding: 15px;
    }

    .success-header {
        padding: 30px 20px;
    }

    .success-title {
        font-size: 2rem;
    }

    .details-grid {
        grid-template-columns: 1fr;
    }

    .steps-grid {
        grid-template-columns: 1fr;
    }

    .order-item {
        flex-direction: column;
        text-align: center;
    }

    .order-item-img {
        align-self: center;
    }

    .confirmation-actions {
        flex-direction: column;
        align-items: center;
    }

    .continue-shopping-button,
    .order-history-button {
        width: 100%;
        max-width: 300px;
    }

    .step-item {
        flex-direction: column;
        text-align: center;
        align-items: center;
    }
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.loading-message {
    animation: pulse 1.5s ease-in-out infinite;
}
</style>
