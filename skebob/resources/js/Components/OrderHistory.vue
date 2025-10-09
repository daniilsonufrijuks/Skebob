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
    async mounted() {
        await this.fetchOrders();
    },
    methods: {
        async fetchOrders() {
            try {
                const response = await fetch("/orders/user", {
                    credentials: "include", // important for Laravel session auth
                    headers: {
                        "Accept": "application/json",
                    },
                });

                if (!response.ok) {
                    if (response.status === 401) {
                        throw new Error("Please log in to view your orders.");
                    }
                    throw new Error("Failed to fetch orders.");
                }

                const data = await response.json();
                console.log("Fetched orders:", data);

                this.orders = Array.isArray(data) ? data : [];
            } catch (err) {
                console.error("Error loading orders:", err);
                this.error = err.message;
            } finally {
                this.loading = false;
            }
        },
        formatDate(dateStr) {
            return new Date(dateStr).toLocaleString("en-US", {
                year: "numeric",
                month: "short",
                day: "numeric",
                hour: "2-digit",
                minute: "2-digit",
            });
        },
    },
};
</script>

<template>
    <div class="order-history">
        <h2 class="title">Your Order History</h2>

        <div v-if="loading" class="loading">Loading your orders...</div>

        <div v-else-if="error" class="error">
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
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
}

.title {
    text-align: center;
    color: #333;
    margin-bottom: 1rem;
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
    color: #333;
}

.loading,
.empty,
.error {
    text-align: center;
    padding: 1.5rem;
    color: #555;
}
.error p {
    color: #d9534f;
}
</style>
