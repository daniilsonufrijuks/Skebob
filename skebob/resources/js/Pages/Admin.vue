<template>
    <div class="admin-dashboard">
        <button @click="$inertia.visit('/')" class="back-button">Back to user page</button>
        <h1 class="title">Admin Dashboard</h1>

        <!-- Orders -->
        <section class="section">
            <h2 class="section-title">Orders</h2>
            <div class="card-grid">
                <div class="card" v-for="order in orders" :key="order.id">
                    <p><strong>ID:</strong> {{ order.id }}</p>
                    <p><strong>Customer ID:</strong> {{ order.user_id }}</p>
                    <p><strong>Status:</strong> {{ order.status }}</p>
                    <p><strong>Total:</strong> {{ order.total }}</p>
                    <p><strong>Ordered At:</strong> {{ order.created_at }}</p>
                    <div class="actions">
                        <button @click="deleteRecord('order', order.id)">Delete</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Orders with User Details -->
        <section class="section">
            <h2 class="section-title">Orders with User Details</h2>
            <div class="card-grid">
                <div class="card" v-for="order in ordersj" :key="order.id">
                    <p><strong>Order ID:</strong> {{ order.order_id }}</p>
                    <p><strong>Customer:</strong> {{ order.customer_name }} ({{ order.customer_email }})</p>
                    <p><strong>Item:</strong> {{ order.item_name }}</p>
                    <p><strong>Status:</strong> {{ order.status }}</p>
                    <p><strong>Total Price:</strong> {{ order.total_price }}</p>
                    <p><strong>Category:</strong> {{ order.category }}</p>
                    <div class="actions">
                        <button @click="deleteRecord('orderj', order.id)">Delete</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products -->
        <section class="section">
            <h2 class="section-title">Products</h2>
            <div class="card-grid">
                <div class="card" v-for="product in products" :key="product.id">
                    <template v-if="editProduct && editProduct.id === product.id">
                        <input v-model="editProduct.name" placeholder="Name" />
                        <input v-model="editProduct.price" type="number" placeholder="Price" />
                        <input v-model="editProduct.category" placeholder="Category" />
                        <textarea v-model="editProduct.description" placeholder="Description"></textarea>
                        <button @click="updateProduct">Save</button>
                        <button @click="editProduct = null">Cancel</button>
                    </template>
                    <template v-else>
                        <p><strong>Name:</strong> {{ product.name }}</p>
                        <p><strong>Price:</strong> ${{ product.price }}</p>
                        <p><strong>Category:</strong> {{ product.category }}</p>
                        <p><strong>Description:</strong> {{ product.description }}</p>
                        <div class="actions">
                            <button @click="editProduct = { ...product }">Edit</button>
                            <button @click="deleteRecord('product', product.id)">Delete</button>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <!-- Add Product -->
        <section class="section">
            <h2 class="section-title">Add Product</h2>
            <form @submit.prevent="addProduct" class="form">
                <input v-model="newProduct.name" type="text" placeholder="Name" required />
                <input v-model="newProduct.price" type="number" placeholder="Price" required />
                <input v-model="newProduct.category" type="text" placeholder="Category" required />
                <textarea v-model="newProduct.description" placeholder="Description"></textarea>
                <input id="img" name="image" type="file" @change="handleFileUpload" />
                <button type="submit">Add Product</button>
            </form>
        </section>
    </div>
</template>

<script>
import product from "@/Pages/Product.vue";

export default {
    // props: ['orders', 'products', 'ordersj'],
    props: {
        orders: {
            type: Array,
            required: true,
        },
        products: {
            type: Array,
            required: true,
        },
        ordersj: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            newProduct: { name: '', price: '', category: '', description: '' },
            imageFile: null,
            editProduct: null, // for editing
        };
    },
    methods: {
        addProduct() {
            const formData = new FormData();
            Object.keys(this.newProduct).forEach((key) => {
                formData.append(key, this.newProduct[key]);
            });
            if (this.imageFile) {
                formData.append('image', this.imageFile);
            }
            console.log(formData);  // Add this to see the data being sent
            // Log the FormData contents
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            this.$inertia.post('/admin/products', formData, {
                onSuccess: () => {
                    // Clear the form on success
                    this.newProduct = {
                        name: '',
                        price: '',
                        category: '',
                        description: '',
                    };
                    this.imageFile = null;
                    // Fetch updated products
                    // this.fetchProducts();
                },
                onError: (errors) => {
                    console.error('Failed to add product:', errors);
                },
            });
        },
        handleFileUpload(event) {
            // this.imageFile = event.target.files[0];
            const file = event.target.files[0];
            if (file) {
                this.imageFile = file; // Ensure img is a File object
            }
        },
        deleteRecord(type, id) {
            if (confirm('Are you sure you want to delete this record?')) {
                this.$inertia.delete(`/admin/${type}s/${id}`, {
                    onSuccess: () => console.log(`${type} deleted.`),
                    onError: err => console.error('Error deleting:', err),
                });
            }
        },
        updateProduct() {
            this.$inertia.put(`/admin/products/${this.editProduct.id}`, this.editProduct, {
                onSuccess: () => {
                    this.editProduct = null;
                },
                onError: err => console.error('Error updating product:', err),
            });
        },
    },
};
</script>

<style scoped>
.admin-dashboard {
    padding: 20px;
    font-family: Arial, sans-serif;
}

.title {
    text-align: center;
    color: #420d65;
}

.section {
    margin: 40px 0;
}

.section-title {
    margin-bottom: 20px;
    color: #333;
}

.card-grid {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.card {
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 15px;
    background-color: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    height: 230px;
}

.actions {
    margin-top: 10px;
    display: flex;
    justify-content: flex-end;
}

.actions button {
    background-color: #e63946;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
}

.actions button:hover {
    background-color: #d62828;
}

.form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-width: 400px;
}

.form input,
.form textarea,
.form button {
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.form button {
    background-color: #420d65;
    color: white;
    cursor: pointer;
}

.back-button {
    background-color: #420d65;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 20px;
}

.back-button:hover {
    background-color: #330a4f;
}
</style>
