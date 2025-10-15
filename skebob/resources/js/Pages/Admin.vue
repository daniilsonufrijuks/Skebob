<template>
    <div class="admin-dashboard">
        <button @click="$inertia.visit('/')" class="back-button">Back to user page</button>
        <h1 class="title">Admin Dashboard</h1>

        <!-- Navigation Tabs -->
        <div class="navigation-tabs">
            <button
                @click="activeTab = 'orders'"
                :class="['tab-button', { active: activeTab === 'orders' }]"
            >
                Orders
            </button>
            <button
                @click="activeTab = 'orderItems'"
                :class="['tab-button', { active: activeTab === 'orderItems' }]"
            >
                Order Items
            </button>
            <button
                @click="activeTab = 'users'"
                :class="['tab-button', { active: activeTab === 'users' }]"
            >
                Users
            </button>
            <button
                @click="activeTab = 'products'"
                :class="['tab-button', { active: activeTab === 'products' }]"
            >
                Products
            </button>
            <button
                @click="activeTab = 'addProduct'"
                :class="['tab-button', { active: activeTab === 'addProduct' }]"
            >
                Add Product
            </button>
        </div>

        <!-- Orders -->
        <section v-if="activeTab === 'orders'" class="section">
            <h2 class="section-title">Orders</h2>
            <div class="scrollable-container">
                <div class="card-grid">
                    <div class="card" v-for="order in orders" :key="order.id">
                        <p><strong>ID:</strong> {{ order.id }}</p>
                        <p><strong>Customer ID:</strong> {{ order.user_id }}</p>
                        <p><strong>Status:</strong> {{ order.status }}</p>
                        <p><strong>Total Price:</strong> ${{ order.total_price }}</p>
                        <p><strong>Shipping Address:</strong> {{ order.shipping_address }}</p>
                        <p><strong>Ordered At:</strong> {{ formatDate(order.ordered_at) }}</p>
                        <p><strong>Created:</strong> {{ formatDate(order.created_at) }}</p>
                        <div class="actions">
                            <button @click="deleteRecord('order', order.id)" class="delete-btn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Order Items -->
        <section v-if="activeTab === 'orderItems'" class="section">
            <h2 class="section-title">Order Items</h2>
            <div class="scrollable-container">
                <div class="card-grid">
                    <div class="card" v-for="orderItem in orderItems" :key="orderItem.id">
                        <p><strong>ID:</strong> {{ orderItem.id }}</p>
                        <p><strong>Order ID:</strong> {{ orderItem.order_id }}</p>
                        <p><strong>Product ID:</strong> {{ orderItem.product_id }}</p>
                        <p><strong>Quantity:</strong> {{ orderItem.quantity }}</p>
                        <p><strong>Unit Price:</strong> ${{ orderItem['unit-price'] }}</p>
                        <p><strong>Subtotal:</strong> ${{ orderItem.subtotal }}</p>
                        <p><strong>Created:</strong> {{ formatDate(orderItem.created_at) }}</p>
                        <div class="actions">
                            <button @click="deleteRecord('orderitem', orderItem.id)" class="delete-btn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Users -->
        <section v-if="activeTab === 'users'" class="section">
            <h2 class="section-title">Users</h2>
            <div class="scrollable-container">
                <div class="card-grid">
                    <div class="card" v-for="user in users" :key="user.id">
                        <p><strong>ID:</strong> {{ user.id }}</p>
                        <p><strong>Name:</strong> {{ user.name }}</p>
                        <p><strong>Email:</strong> {{ user.email }}</p>
                        <p><strong>Subscription:</strong>
                            <span :class="['subscription-badge', user.has_subscription ? 'active' : 'inactive']">
                        {{ user.has_subscription ? 'Active' : 'Inactive' }}
                    </span>
                        </p>
                        <p><strong>Created:</strong> {{ formatDate(user.created_at) }}</p>
                        <p><strong>Updated:</strong> {{ formatDate(user.updated_at) }}</p>
                        <div class="actions">
                            <button @click="deleteRecord('user', user.id)" class="delete-btn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products -->
        <section v-if="activeTab === 'products'" class="section">
            <h2 class="section-title">Products</h2>
            <div class="scrollable-container">
                <div class="card-grid">
                    <div class="card" v-for="product in products" :key="product.id">
                        <template v-if="editProduct && editProduct.id === product.id">
                            <div class="edit-form">
                                <input v-model="editProduct.name" placeholder="Name" class="form-input" />
                                <input v-model="editProduct.price" type="number" step="0.01" placeholder="Price" class="form-input" />
                                <input v-model="editProduct.amount_value" type="number" step="0.01" placeholder="Amount Value" class="form-input" />
                                <select v-model="editProduct.amount_unit" class="form-input">
                                    <option value="g">g</option>
                                    <option value="kg">kg</option>
                                    <option value="ml">ml</option>
                                    <option value="l">l</option>
                                    <option value="gab">gab</option>
                                </select>
                                <input v-model="editProduct.country_origin" placeholder="Country Origin" class="form-input" />
                                <textarea v-model="editProduct.ingredients" placeholder="Ingredients" class="form-input"></textarea>
                                <textarea v-model="editProduct.nutritional_info" placeholder="Nutritional Info" class="form-input"></textarea>
                                <input v-model="editProduct.storage_conditions" placeholder="Storage Conditions" class="form-input" />

                                <!-- Current Image Preview -->
                                <div v-if="product.image && !editImageFile" class="current-image">
                                    <p><strong>Current Image:</strong></p>
                                    <img :src="'/' + product.image" alt="Current Product Image" />
                                    <p class="image-path">{{ product.image }}</p>
                                </div>

                                <!-- New Image Preview -->
                                <div v-if="editImageFile" class="new-image">
                                    <p><strong>New Image:</strong></p>
                                    <img :src="editImagePreview" alt="New Product Image" />
                                    <p class="image-name">{{ editImageFile.name }}</p>
                                </div>

                                <!-- File Upload -->
                                <div class="file-upload">
                                    <label>Update Image (optional):</label>
                                    <input type="file" @change="handleEditImageUpload" accept="image/*" />
                                    <small>Leave empty to keep current image</small>
                                </div>

                                <div class="edit-actions">
                                    <button @click="updateProduct" class="save-btn">Save Changes</button>
                                    <button @click="cancelEdit" class="cancel-btn">Cancel</button>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <p><strong>Name:</strong> {{ product.name }}</p>
                            <p><strong>Price:</strong> ${{ product.price }}</p>
                            <p><strong>Amount:</strong> {{ product.amount_value }} {{ product.amount_unit }}</p>
                            <p><strong>Country Origin:</strong> {{ product.country_origin || 'N/A' }}</p>
                            <p><strong>Ingredients:</strong> {{ product.ingredients || 'N/A' }}</p>
                            <p><strong>Nutritional Info:</strong> {{ product.nutritional_info || 'N/A' }}</p>
                            <p><strong>Storage:</strong> {{ product.storage_conditions || 'N/A' }}</p>
                            <div v-if="product.image" class="product-image">
                                <img :src="'/' + product.image" alt="Product Image" />
                            </div>
                            <div class="actions">
                                <button @click="startEdit(product)" class="edit-btn">Edit</button>
                                <button @click="deleteRecord('product', product.id)" class="delete-btn">Delete</button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </section>

        <!-- Add Product -->
        <section v-if="activeTab === 'addProduct'" class="section">
            <h2 class="section-title">Add Product</h2>
            <div class="scrollable-container">
                <form @submit.prevent="addProduct" class="form">
                    <div class="form-group">
                        <label>Product Name *</label>
                        <input v-model="newProduct.name" type="text" placeholder="Product Name" required />
                    </div>

                    <div class="form-group">
                        <label>Price *</label>
                        <input v-model="newProduct.price" type="number" step="0.01" placeholder="Price" required />
                    </div>

                    <div class="form-group">
                        <label>Amount Value *</label>
                        <input v-model="newProduct.amount_value" type="number" step="0.01" placeholder="Amount Value" required />
                    </div>

                    <div class="form-group">
                        <label>Amount Unit *</label>
                        <select v-model="newProduct.amount_unit" required>
                            <option value="">Select Unit</option>
                            <option value="g">g</option>
                            <option value="kg">kg</option>
                            <option value="ml">ml</option>
                            <option value="l">l</option>
                            <option value="gab">gab</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Country Origin</label>
                        <input v-model="newProduct.country_origin" type="text" placeholder="Country Origin" />
                    </div>

                    <div class="form-group">
                        <label>Ingredients</label>
                        <textarea v-model="newProduct.ingredients" placeholder="Ingredients"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Nutritional Info</label>
                        <textarea v-model="newProduct.nutritional_info" placeholder="Nutritional Info"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Storage Conditions</label>
                        <input v-model="newProduct.storage_conditions" type="text" placeholder="Storage Conditions" />
                    </div>

                    <div class="form-group">
                        <label>Product Image *</label>
                        <input type="file" @change="handleFileUpload" accept="image/*" required />
                        <small>Supported formats: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                    </div>

                    <div v-if="imageFile" class="image-preview">
                        <p><strong>Image Preview:</strong></p>
                        <img :src="imagePreview" alt="Product Image Preview" />
                        <p class="image-name">{{ imageFile.name }}</p>
                    </div>

                    <button type="submit" class="submit-btn" :disabled="isAdding">
                        {{ isAdding ? 'Adding Product...' : 'Add Product' }}
                    </button>
                </form>
            </div>
        </section>

        <!-- Notification -->
        <div v-if="notification.show" :class="['notification', notification.type]">
            {{ notification.message }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        orders: {
            type: Array,
            default: () => []
        },
        products: {
            type: Array,
            default: () => []
        },
        orderItems: {
            type: Array,
            default: () => []
        },
        users: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            activeTab: 'orders',
            newProduct: {
                name: '',
                price: '',
                amount_value: '',
                amount_unit: '',
                country_origin: '',
                ingredients: '',
                nutritional_info: '',
                storage_conditions: ''
            },
            imageFile: null,
            imagePreview: null,
            editProduct: null,
            editImageFile: null,
            editImagePreview: null,
            isAdding: false,
            notification: {
                show: false,
                message: '',
                type: 'success'
            }
        };
    },
    methods: {
        startEdit(product) {
            // create a clean copy without the image path string
            this.editProduct = {
                id: product.id,
                name: product.name,
                price: product.price,
                amount_value: product.amount_value,
                amount_unit: product.amount_unit,
                country_origin: product.country_origin,
                ingredients: product.ingredients,
                nutritional_info: product.nutritional_info,
                storage_conditions: product.storage_conditions
            };
            this.editImageFile = null;
            this.editImagePreview = null;
        },

        cancelEdit() {
            this.editProduct = null;
            this.editImageFile = null;
            this.editImagePreview = null;
        },

        async updateProduct() {
            if (!this.editProduct) return;

            const formData = new FormData();

            // only append the fields that should be updated
            const productData = {
                name: this.editProduct.name,
                price: this.editProduct.price,
                amount_value: this.editProduct.amount_value,
                amount_unit: this.editProduct.amount_unit,
                country_origin: this.editProduct.country_origin,
                ingredients: this.editProduct.ingredients,
                nutritional_info: this.editProduct.nutritional_info,
                storage_conditions: this.editProduct.storage_conditions,
                _method: 'PUT'
            };

            // append all data to FormData
            Object.keys(productData).forEach(key => {
                if (productData[key] !== null && productData[key] !== undefined) {
                    formData.append(key, productData[key]);
                }
            });

            // only append image if a new one was selected
            if (this.editImageFile) {
                formData.append('image', this.editImageFile);
            }

            console.log('Updating product with data:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            try {
                await this.$inertia.post(`/admin/products/${this.editProduct.id}`, formData, {
                    onSuccess: () => {
                        this.showNotification('Product updated successfully!', 'success');
                        this.editProduct = null;
                        this.editImageFile = null;
                        this.editImagePreview = null;
                    },
                    onError: (errors) => {
                        console.error('Update errors:', errors);
                        this.showNotification('Error updating product: ' + JSON.stringify(errors), 'error');
                    }
                });

            } catch (error) {
                console.error('Error updating product:', error);
                this.showNotification('Error updating product: ' + error.message, 'error');
            }
        },

        async addProduct() {
            // validate required fields
            if (!this.newProduct.name || !this.newProduct.price || !this.newProduct.amount_value || !this.newProduct.amount_unit || !this.imageFile) {
                this.showNotification('Please fill all required fields and select an image', 'error');
                return;
            }

            this.isAdding = true;

            const formData = new FormData();

            // append all product data
            Object.keys(this.newProduct).forEach((key) => {
                if (this.newProduct[key] !== null && this.newProduct[key] !== undefined && this.newProduct[key] !== '') {
                    formData.append(key, this.newProduct[key]);
                }
            });

            // append image file
            if (this.imageFile) {
                formData.append('image', this.imageFile);
            }

            // set default values for required foreign keys
            formData.append('brand_id', '1');
            formData.append('category_id', '1');
            formData.append('admin_id', '1');

            console.log('Adding new product with data:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            try {
                await this.$inertia.post('/admin/products', formData, {
                    onSuccess: () => {
                        this.showNotification('Product added successfully!', 'success');
                        this.resetForm();
                        this.isAdding = false;
                        // switch to products tab to see the new product
                        this.activeTab = 'products';
                    },
                    onError: (errors) => {
                        console.error('Add product errors:', errors);
                        this.showNotification('Failed to add product: ' + JSON.stringify(errors), 'error');
                        this.isAdding = false;
                    }
                });
            } catch (error) {
                console.error('Error adding product:', error);
                this.showNotification('Error adding product: ' + error.message, 'error');
                this.isAdding = false;
            }
        },

        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.imageFile = file;

                // Create preview
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);

                console.log('Image selected:', file.name);
            } else {
                this.imageFile = null;
                this.imagePreview = null;
            }
        },

        handleEditImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.editImageFile = file;

                // create preview
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.editImagePreview = e.target.result;
                };
                reader.readAsDataURL(file);

                console.log('New image selected for edit:', file.name);
            } else {
                this.editImageFile = null;
                this.editImagePreview = null;
            }
        },

        deleteRecord(type, id) {
            if (confirm(`Are you sure you want to delete this ${type}?`)) {
                this.$inertia.delete(`/admin/${type}s/${id}`, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showNotification(`${type} deleted successfully!`, 'success');
                        // the page data will be refreshed automatically by Inertia
                    },
                    onError: (err) => {
                        this.showNotification(`Error deleting ${type}: ${err}`, 'error');
                    },
                });
            }
        },

        resetForm() {
            this.newProduct = {
                name: '',
                price: '',
                amount_value: '',
                amount_unit: '',
                country_origin: '',
                ingredients: '',
                nutritional_info: '',
                storage_conditions: ''
            };
            this.imageFile = null;
            this.imagePreview = null;
            // reset file input
            const fileInput = document.querySelector('input[type="file"]');
            if (fileInput) fileInput.value = '';
        },

        showNotification(message, type = 'success') {
            this.notification = {
                show: true,
                message,
                type
            };
            setTimeout(() => {
                this.notification.show = false;
            }, 3000);
        },

        formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
        }
    }
};
</script>

<style scoped>
.admin-dashboard {
    padding: 20px;
    font-family: Arial, sans-serif;
    max-width: 1200px;
    margin: 0 auto;
}

.title {
    text-align: center;
    color: #420d65;
    margin-bottom: 30px;
}

.navigation-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 30px;
    flex-wrap: wrap;
    justify-content: center;
}

.tab-button {
    padding: 12px 24px;
    border: 2px solid #420d65;
    background-color: white;
    color: #420d65;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: all 0.3s ease;
}

.tab-button:hover {
    background-color: #f0e6f7;
}

.tab-button.active {
    background-color: #420d65;
    color: white;
}

.section {
    margin: 20px 0;
    padding: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    background-color: #f9f9f9;
}

.section-title {
    margin-bottom: 20px;
    color: #333;
    border-bottom: 2px solid #420d65;
    padding-bottom: 10px;
}

.scrollable-container {
    max-height: 70vh;
    overflow-y: auto;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    background-color: white;
    padding: 15px;
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 20px;
}

.card {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.actions {
    margin-top: 15px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.edit-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.actions button, .edit-actions button {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.edit-btn {
    background-color: #4CAF50;
    color: white;
}

.edit-btn:hover {
    background-color: #45a049;
}

.delete-btn {
    background-color: #e63946;
    color: white;
}

.delete-btn:hover {
    background-color: #d62828;
}

.save-btn {
    background-color: #2196F3;
    color: white;
}

.save-btn:hover {
    background-color: #1976D2;
}

.cancel-btn {
    background-color: #757575;
    color: white;
}

.cancel-btn:hover {
    background-color: #616161;
}

.form {
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 500px;
    margin: 0 auto;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.form-group label {
    font-weight: bold;
    color: #333;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
}

.form-group textarea {
    min-height: 80px;
    resize: vertical;
}

.form-group small {
    color: #666;
    font-size: 12px;
    font-style: italic;
}

.submit-btn {
    background-color: #420d65;
    color: white;
    cursor: pointer;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    border-radius: 6px;
}

.submit-btn:hover:not(:disabled) {
    background-color: #330a4f;
}

.submit-btn:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
}

.back-button {
    background-color: #420d65;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 20px;
    font-size: 14px;
}

.back-button:hover {
    background-color: #330a4f;
}

.product-image {
    margin: 10px 0;
    text-align: center;
}

.product-image img {
    max-width: 100px;
    max-height: 100px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.edit-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.form-input {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.current-image, .new-image, .image-preview {
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.current-image img, .new-image img, .image-preview img {
    max-width: 150px;
    max-height: 150px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.image-path, .image-name {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
    word-break: break-all;
}

.file-upload {
    margin: 10px 0;
}

.file-upload label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.file-upload small {
    color: #666;
    font-style: italic;
}

.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 20px;
    border-radius: 5px;
    color: white;
    z-index: 1000;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.notification.success {
    background-color: #4CAF50;
}

.notification.error {
    background-color: #e63946;
}

input[type="file"] {
    padding: 8px;
}

.subscription-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
}

.subscription-badge.active {
    background-color: #4CAF50;
    color: white;
}

.subscription-badge.inactive {
    background-color: #757575;
    color: white;
}

@media (max-width: 768px) {
    .card-grid {
        grid-template-columns: 1fr;
    }

    .admin-dashboard {
        padding: 10px;
    }

    .section {
        margin: 20px 0;
        padding: 15px;
    }

    .current-image img, .new-image img, .image-preview img {
        max-width: 100px;
        max-height: 100px;
    }

    .navigation-tabs {
        flex-direction: column;
        align-items: center;
    }

    .tab-button {
        width: 100%;
        max-width: 300px;
    }

    .scrollable-container {
        max-height: 60vh;
    }
}

.scrollable-container::-webkit-scrollbar {
    width: 8px;
}

.scrollable-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.scrollable-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.scrollable-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
