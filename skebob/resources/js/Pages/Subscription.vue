<template>
    <Navbar :routes="routes" />
    <Search />
    <Slider />
    <div class="main-container">
        <Visitit />

        <!-- Authentication check -->
        <div v-if="!isAuthenticated" class="auth-required">
            <div class="auth-message">
                <h3>{{ $t('AuthenticationRequired') }}</h3>
                <p>{{ $t('Please Log In To Subscribe') }}</p>
                <div class="auth-actions">
                    <button @click="redirectToLogin" class="login-button">
                        {{ $t('login') }}
                    </button>
                    <button @click="redirectToRegister" class="register-button">
                        {{ $t('CreateAccount') }}
                    </button>
                </div>
            </div>
        </div>

        <div v-else class="subscription-container">
            <!-- Already Subscribed view -->
            <div v-if="userHasSubscription" class="already-subscribed">
                <div class="subscription-image">
                    <img :src="'/' + subscription.image" :alt="subscription.name" />
                </div>
                <div class="subscription-status">
                    <div class="status-icon">✅</div>
                    <h2 class="status-title">You're Already Subscribed!</h2>
                    <p class="status-message">
                        Thank you for being a valued SNACKtastic subscriber!
                        You're all set to enjoy your exclusive benefits, including your <strong>free Mystery Box every 2 months</strong>.
                    </p>
                    <div class="active-benefits">
                        <h3>Your Active Benefits:</h3>
                        <ul class="benefits-list">
                            <li>🎁 <strong>FREE Mystery Box every 2 months</strong></li>
                            <li>🚚 With free express shipping for it</li>
                            <li>📞 And constant priority customer support</li>
                        </ul>
                    </div>
                    <p class="next-box-info">
                        Your next Mystery Box is scheduled to arrive in the coming weeks.
                        Keep an eye on your email for shipping updates!
                    </p>
                </div>
            </div>

            <!-- Subscribe view -->
            <div v-else-if="subscription" class="subscription-card">
                <div class="subscription-image">
                    <img :src="'/' + subscription.image" :alt="subscription.name" />
                </div>
                <div class="subscription-details">
                    <h2 class="subscription-title">{{ subscription.name }}</h2>
                    <p class="subscription-price">${{ subscription.price }}</p>

                    <div class="subscription-benefits">
                        <h3>Unlock Exclusive Benefits:</h3>
                        <ul class="benefits-list">
                            <li>🎁 <strong>FREE Mystery Box every 2 months</strong> - Discover surprise products worth up to $50!</li>
                            <li>🚚 With free express shipping for it</li>
                            <li>📞 And constant priority customer support</li>
                        </ul>
                    </div>

                    <div class="mystery-box-highlight">
                        <div class="highlight-icon">🎁</div>
                        <div class="highlight-text">
                            <strong>BONUS:</strong> Your first Mystery Box ships immediately after subscription!
                        </div>
                    </div>

                    <p class="subscription-description">
                        Join thousands of satisfied members who enjoy the thrill of surprise and the best deals!
                        Every two months, we curate a special Mystery Box filled with premium products tailored to your preferences.
                        It's not just a subscription - it's an experience that keeps giving!
                    </p>

                    <div class="subscription-cta">
                        <button
                            class="buy-subscription-btn"
                            @click="processSubscription"
                            :disabled="processing"
                        >
                            <span v-if="processing">
                                {{ $t('Processing') }}...
                            </span>
                            <span v-else>
                                🔥 {{ $t('Get Subscription Now') }}!
                            </span>
                        </button>
                        <p class="cta-note">{{ $t('Cancel Anytime') }} • {{ $t('No Commitment') }} • {{ $t('First Mystery Box Ships Today') }}!</p>
                    </div>
                </div>
            </div>

            <div v-else-if="loading" class="loading">
                {{ $t('Loading Subscription') }}...
            </div>

            <div v-else class="error">
                {{ $t('Subscription Not Available') }}
            </div>
        </div>

        <Contact />
    </div>
    <Footer />
</template>

<script>
import Visitit from '../Components/Visitit.vue';
import Slider from '../Components/Slider.vue';
import Contact from '../Components/Contact.vue';
import Search from '../Components/Search.vue';
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import { useUser } from "../Composables/useUser.js";
import { computed, ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { loadStripe } from "@stripe/stripe-js";

export default {
    name: 'SubscriptionPage',
    components: {
        Navbar,
        Visitit,
        Slider,
        Contact,
        Search,
        Footer,
    },
    props: {
        routes: Object,
    },
    setup() {
        const { isLoggedIn, user } = useUser();
        const router = useRouter();
        const subscription = ref(null);
        const loading = ref(true);
        const processing = ref(false);
        const isAuthenticated = computed(() => isLoggedIn.value);

        // check if user already has subscription
        const userHasSubscription = computed(() => {
            return user.value?.has_subscription === true;
        });
        onMounted(() => {
            fetchSubscription();
        });
        const fetchSubscription = async () => {
            loading.value = true;
            try {
                const response = await fetch('/products/subscription');
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                const data = await response.json();
                console.log("Fetched subscription:", data);
                subscription.value = data;
            } catch (error) {
                console.error("Error fetching subscription:", error);
            } finally {
                loading.value = false;
            }
        };

        const processSubscription = async () => {
            if (processing.value || !subscription.value) return;
            // double-check authentication
            if (!isAuthenticated.value) {
                alert('Please log in to subscribe.');
                redirectToLogin();
                return;
            }
            // double-check that user doesn't already have subscription
            if (userHasSubscription.value) {
                alert('You already have an active subscription!');
                return;
            }
            processing.value = true;
            try {
                // prepare subscription data for Stripe
                const subscriptionData = {
                    subscription_id: subscription.value.id,
                    name: subscription.value.name,
                    price: parseFloat(subscription.value.price),
                    type: 'subscription'
                };
                console.log('Sending subscription data to Stripe:', subscriptionData);
                // create Stripe session
                const response = await axios.post('/subscription/checkout', subscriptionData);
                if (!response.data.id) {
                    throw new Error('No session ID received from server');
                }
                // redirect to Stripe checkout
                const stripeKey = import.meta.env.VITE_STRIPE_KEY;
                if (!stripeKey) {
                    throw new Error('Stripe public key is not defined');
                }
                const stripe = await loadStripe(stripeKey);
                if (!stripe) {
                    throw new Error('Failed to load Stripe');
                }
                const { error } = await stripe.redirectToCheckout({
                    sessionId: response.data.id
                });
                if (error) {
                    throw new Error(error.message);
                }
            } catch (error) {
                console.error('Error processing subscription:', error);
                if (error.response && error.response.status === 401) {
                    alert('Your session has expired. Please log in again.');
                    redirectToLogin();
                } else if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    const errorMessage = Object.values(errors).flat().join(', ');
                    alert('Please check your information: ' + errorMessage);
                } else {
                    alert('There was an error processing your subscription: ' + error.message);
                }
                processing.value = false;
            }
        };

        const redirectToLogin = () => {
            window.location.href = '/login';
        };

        const redirectToRegister = () => {
            window.location.href = '/registration';
        };
        return {
            subscription,
            loading,
            processing,
            isAuthenticated,
            userHasSubscription,
            processSubscription,
            redirectToLogin,
            redirectToRegister
        };
    }
};
</script>

<style scoped>
.main-container {
    display: flex;
    flex-direction: column;
    gap: 70px;
}

/* authentication styles */
.auth-required {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 50vh;
    padding: 40px 20px;
}

.auth-message {
    text-align: center;
    background: #f9f9f9;
    padding: 40px;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    max-width: 500px;
    width: 100%;
}

.auth-message h3 {
    color: #333;
    margin-bottom: 15px;
    font-size: 1.5rem;
}

.auth-message p {
    color: #666;
    margin-bottom: 25px;
    font-size: 1.1rem;
}

.auth-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.login-button,
.register-button {
    padding: 12px 24px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    min-width: 140px;
}

.login-button {
    background-color: #d87220;
    color: white;
}

.login-button:hover {
    background-color: #a5500d;
}

.register-button {
    background-color: #6c757d;
    color: white;
}

.register-button:hover {
    background-color: #545b62;
}

/* subscription container */
.subscription-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
    padding: 20px;
}

.subscription-card {
    display: flex;
    max-width: 1000px;
    width: 100%;
    border: 1px solid #e0e0e0;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
}

.subscription-image {
    flex: 0 0 400px;
    width: 400px;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 0;
}

.subscription-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
}

.subscription-details {
    flex: 1;
    padding: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.subscription-title {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #333;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.subscription-price {
    font-size: 32px;
    font-weight: bold;
    color: #420d65;
    margin-bottom: 25px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.subscription-benefits {
    margin-bottom: 20px;
}

.subscription-benefits h3 {
    font-size: 18px;
    color: #333;
    margin-bottom: 15px;
    font-weight: 600;
}

.benefits-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.benefits-list li {
    padding: 8px 0;
    font-size: 14px;
    color: #555;
    line-height: 1.4;
    border-bottom: 1px solid #f0f0f0;
}

.benefits-list li:last-child {
    border-bottom: none;
}

.mystery-box-highlight {
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #fff9c4 0%, #ffeb3b 100%);
    padding: 15px;
    border-radius: 10px;
    margin: 20px 0;
    border: 2px solid #ffd600;
}

.highlight-icon {
    font-size: 24px;
    margin-right: 15px;
}

.highlight-text {
    font-size: 14px;
    color: #333;
    font-weight: 500;
}

.subscription-description {
    font-size: 15px;
    line-height: 1.6;
    color: #666;
    margin-bottom: 25px;
    font-style: italic;
    text-align: center;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #420d65;
}

.subscription-cta {
    text-align: center;
}

.buy-subscription-btn {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    color: white;
    border: none;
    padding: 18px 40px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
    margin-bottom: 15px;
    width: 100%;
}

.buy-subscription-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
    background: linear-gradient(135deg, #ff5252 0%, #e74c3c 100%);
}

.buy-subscription-btn:disabled {
    background: #cccccc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.cta-note {
    font-size: 12px;
    color: #888;
    font-style: italic;
}

.loading, .error {
    text-align: center;
    font-size: 18px;
    color: #666;
    padding: 40px;
}

.loading {
    color: #420d65;
}

.error {
    color: #e74c3c;
}

.already-subscribed {
    display: flex;
    max-width: 1000px;
    width: 100%;
    border: 1px solid #e0e0e0;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
}

.subscription-status {
    flex: 1;
    padding: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
}

.status-icon {
    font-size: 48px;
    margin-bottom: 20px;
}

.status-title {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 15px;
    color: #4CAF50;
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.status-message {
    font-size: 16px;
    line-height: 1.6;
    color: #666;
    margin-bottom: 25px;
}

.active-benefits {
    margin: 25px 0;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #4CAF50;
}

.active-benefits h3 {
    color: #333;
    margin-bottom: 15px;
    font-size: 18px;
}

.active-benefits .benefits-list {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: left;
}

.active-benefits .benefits-list li {
    padding: 8px 0;
    font-size: 14px;
    color: #555;
    line-height: 1.4;
}

.next-box-info {
    font-size: 14px;
    color: #666;
    font-style: italic;
    padding: 15px;
    background: #e8f5e8;
    border-radius: 8px;
    border: 1px solid #4CAF50;
}

@media screen and (max-width: 768px) {
    .subscription-card {
        flex-direction: column;
        max-width: 400px;
    }

    .subscription-image {
        flex: 0 0 300px;
        width: 100%;
        height: 300px;
        max-width: 100%;
    }

    .subscription-details {
        padding: 25px;
    }

    .subscription-title {
        font-size: 24px;
    }

    .subscription-price {
        font-size: 28px;
    }

    .benefits-list li {
        font-size: 13px;
    }

    .buy-subscription-btn {
        padding: 15px 30px;
        font-size: 16px;
    }

    .already-subscribed {
        flex-direction: column;
        max-width: 400px;
    }

    .subscription-status {
        padding: 25px;
    }
}

@media screen and (max-width: 480px) {
    .subscription-image {
        flex: 0 0 250px;
        height: 250px;
    }
}

@keyframes pulse-glow {
    0% { box-shadow: 0 0 0 0 rgba(255, 214, 0, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(255, 214, 0, 0); }
    100% { box-shadow: 0 0 0 0 rgba(255, 214, 0, 0); }
}

.mystery-box-highlight {
    animation: pulse-glow 2s infinite;
}
</style>
