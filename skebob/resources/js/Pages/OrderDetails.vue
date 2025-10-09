<script setup>
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import Navbar from "../Components/Navbar.vue";
import Footer from "../Components/Footer.vue";

const props = defineProps({ orderId: Number });

const order = ref({});
const items = ref([]);

function formatDate(dateStr) {
    return new Date(dateStr).toLocaleString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
}

onMounted(async () => {
    const response = await fetch(`/orders/${props.orderId}`, { credentials: "include" });
    const data = await response.json();
    order.value = data.order || {};
    items.value = data.items || [];
});
</script>

<template>
    <Navbar/>

    <div class="order-details-wrapper">
        <div class="order-details-card">
            <h2>Order #{{ order.id }}</h2>

            <p><strong>Status:</strong> {{ order.status }}</p>
            <p><strong>Total:</strong> ${{ Number(order.total_price).toFixed(2) }}</p>
            <p><strong>Shipping Address:</strong> {{ order.shipping_address }}</p>
            <p><strong>Date:</strong> {{ formatDate(order.ordered_at) }}</p>

            <h3>Items</h3>
            <ul>
                <li v-for="item in items" :key="item.id">
                    <strong>{{ item.name }}</strong> — {{ item.quantity }} × ${{ Number(item.price).toFixed(2) }}
                </li>

                <li>
                    <strong>Tax Fee</strong> — $5.99
                </li>
            </ul>

            <button @click="$inertia.visit('/user')" class="back-btn">
                ← Back to Order History
            </button>
        </div>
    </div>

    <Footer/>
</template>

<style scoped>
/* 🟢 Center everything in the middle of the screen */
.order-details-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh; /* full screen height */
    background-color: #f9f9f9; /* optional, subtle background */
}

/* 🟢 The card itself */
.order-details-card {
    background: #fff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    max-width: 600px;
    width: 90%;
    text-align: left;
    animation: fadeIn 0.4s ease;
}

/* 🟢 Nice typography */
.order-details-card h2 {
    text-align: center;
    margin-bottom: 1rem;
}

.order-details-card h3 {
    margin-top: 1.5rem;
}

/* 🟢 Button styling */
.back-btn {
    margin-top: 2rem;
    background-color: #333;
    color: #fff;
    padding: 0.6rem 1.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.2s;
}

.back-btn:hover {
    background-color: #555;
}

/* 🟢 Smooth fade-in animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
