<script>
export default {
    name: "OrderHistory",
    data() {
        return {
            orders: [],
            loading: true,
            error: null,
        };
    },
    mounted() {
        this.fetchOrders();
    },
    methods: {
        async fetchOrders() {
            try {
                const response = await fetch("/orders/user", {
                    credentials: "include", // ⬅️ important for Laravel session auth
                });
                if (!response.ok) throw new Error("Failed to fetch orders");
                const data = await response.json();
                console.log("Fetched orders:", data);
                this.orders = data;
            } catch (error) {
                console.error("Error loading orders:", error);
                this.error = "Could not load your orders. Please log in.";
            } finally {
                this.loading = false;
            }
        },
        formatDate(dateStr) {
            return new Date(dateStr).toLocaleString();
        },
    },
};
</script>

<template>
    <div class="order-history">
        <h3>Your Order History</h3>

        <div v-if="loading" class="loading">Loading your orders...</div>

        <div v-else-if="error" class="empty">
            <p>{{ error }}</p>
        </div>

        <div v-else-if="orders.length === 0" class="empty">
            <p>You haven’t placed any orders yet.</p>
        </div>

        <div v-else>
            <table class="order-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total ($)</th>
                    <th>Status</th>
                    <th>Shipping Address</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(order, index) in orders" :key="order.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ order.id }}</td>
                    <td>{{ formatDate(order.ordered_at) }}</td>
                    <td>{{ Number(order.total_price).toFixed(2) }}</td>
                    <td>{{ order.status }}</td>
                    <td>{{ order.shipping_address }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
.order-history {
    width: 100%;
    max-width: 900px;
    margin: 2rem auto;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
}

.order-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.order-table th,
.order-table td {
    border: 1px solid #eee;
    padding: 0.75rem 1rem;
    text-align: left;
}

.order-table th {
    background-color: #f8f9fa;
}

.loading,
.empty {
    text-align: center;
    padding: 1rem;
    color: #666;
}
</style>
