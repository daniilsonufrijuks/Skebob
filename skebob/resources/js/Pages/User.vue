<template>
    <!--    <Navbar :routes="routes" />-->
    <Navbar :routes="routes"/>
    <Search />
    <div class="main-container">
        <div class="col-xl-6 col-md-12">
            <div class="card user-card-full">
                <div class="row m-l-0 m-r-0">
                    <div class="col-sm-4 bg-c-lite-green user-profile">
                        <div class="card-block text-center text-white">
                            <div class="m-b-25">
                                <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image">
                            </div>
                            <h6 class="f-w-600">{{ user.name }}</h6>
                            <i class="fas fa-edit edit-icon m-t-10 f-16" @click="toggleEditMode"></i>
                            <p class="m-t-10">
                                {{ isEditing ? $t('EditingMode') : $t('ClickPencilToEdit') }}
                            </p>
<!--                            <p class="m-t-10">{{ isEditing ? 'Editing Mode' : 'Click pencil to edit' }}</p>-->
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card-block">
                            <h6 class="m-b-20 p-b-5 b-b-default f-w-600">{{ $t('userInformation') }}</h6>
<!--                            <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>-->

                            <!-- Success/Error Messages -->
                            <div v-if="successMessage" class="alert alert-success">
                                <i class="fas fa-check-circle"></i> {{ successMessage }}
                            </div>
                            <div v-if="errorMessage" class="alert alert-error">
                                <i class="fas fa-exclamation-circle"></i> {{ errorMessage }}
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">{{ $t('FormEmail') }}</p>
<!--                                    <p class="m-b-10 f-w-600">Email</p>-->
                                    <div v-if="!isEditing">
                                        <h6 class="text-muted f-w-400">{{ user.email }}</h6>
                                    </div>
                                    <div v-else>
                                        <input type="email" v-model="editForm.email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">{{ $t('FormName') }}</p>
<!--                                    <p class="m-b-10 f-w-600">Name</p>-->
                                    <div v-if="!isEditing">
                                        <h6 class="text-muted f-w-400">{{ user.name }}</h6>
                                    </div>
                                    <div v-else>
                                        <input type="text" v-model="editForm.name" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- Subscription Status -->
                            <div class="row m-t-20">
                                <div class="col-sm-12">
                                    <p class="m-b-10 f-w-600">{{ $t('SNACKtasticSubscriptionStatus') }}</p>
                                    <div class="subscription-status-display">
                                        <span :class="['status-badge', user.has_subscription ? 'status-active' : 'status-inactive']">
                                            <i :class="user.has_subscription ? 'fas fa-crown' : 'fas fa-hourglass-half'"></i>
                                            {{ user.has_subscription ? $t('Active') : $t('Inactive') }}
                                        </span>
                                        <div v-if="!user.has_subscription" class="subscription-cta">
                                            <a href="/subscriptions" class="btn btn-primary btn-sm">
                                                <i class="fas fa-gift"></i> {{ $t('Get SNACKtastic subscription') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit buttons -->
                            <div class="row m-t-20" v-if="isEditing">
                                <div class="col-sm-12">
                                    <button class="btn btn-primary btn-sm" @click="updateProfile" :disabled="loading">
                                        <span v-if="loading">{{ $t('Updating') }}...</span>
                                        <span v-else>{{ $t('SaveChanges') }}</span>
<!--                                        <span v-if="loading">Updating...</span>-->
<!--                                        <span v-else>Save Changes</span>-->
                                    </button>
                                    <button class="btn btn-secondary btn-sm m-l-10" @click="cancelEdit">{{ $t('Cancel') }}</button>
<!--                                    <button class="btn btn-secondary btn-sm m-l-10" @click="cancelEdit">Cancel</button>-->
                                </div>
                            </div>
                            <!-- Delete Account Section -->
                            <div class="row m-t-30">
                                <div class="col-sm-12">
                                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 text-danger">{{ $t('DangerZone') }}</h6>
<!--                                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 text-danger">Danger Zone</h6>-->
                                    <p class="text-muted m-b-15">{{ $t('DeleteAccWarning') }}</p>
<!--                                    <p class="text-muted m-b-15">Once you delete your account, there is no going back. Please be certain.</p>-->
                                    <button class="btn btn-danger btn-sm" @click="confirmDelete" :disabled="deleting">
                                        <span v-if="deleting">{{ $t('Deleting') }}...</span>
                                        <span v-else>{{ $t('DeleteAccount') }}</span>
<!--                                        <span v-if="deleting">Deleting...</span>-->
<!--                                        <span v-else>Delete Account</span>-->
                                    </button>
                                </div>
                            </div>

                            <!-- Delete Confirmation Modal -->
                            <div v-if="showDeleteModal" class="modal-backdrop">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $t('ConfirmAccountDeletion') }}</h5>
<!--                                        <h5 class="modal-title">Confirm Account Deletion</h5>-->
                                    </div>
                                    <div class="modal-body">
                                        <p>{{ $t('AreYouSureDelete') }}</p>
<!--                                        <p>Are you sure you want to delete your account? This action cannot be undone.</p>-->
                                        <div class="form-group">
                                            <label for="password">{{ $t('EnterYourPasswordToConfirm') }}:</label>
<!--                                            <label for="password">Enter your password to confirm:</label>-->
                                            <input type="password" v-model="deletePassword" class="form-control" id="password" :placeholder="$t('YourPassword')">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" @click="cancelDelete">{{ $t('Cancel') }}</button>
<!--                                        <button type="button" class="btn btn-secondary" @click="cancelDelete">Cancel</button>-->
                                        <button type="button" class="btn btn-danger" @click="deleteAccount" :disabled="!deletePassword || deleting">
                                            <span v-if="deleting">{{ $t('Deleting') }}...</span>
                                            <span v-else>{{ $t('DeleteAccount') }}</span>
<!--                                            <span v-if="deleting">Deleting...</span>-->
<!--                                            <span v-else>Delete Account</span>-->
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--        <Visitit />-->
        <OrderHistory />
        <Visitit />
        <div class="products">
            <ProductCardDB v-for="product in products" :key="product.id" :product="product" />
        </div>
<!--        <Productsintro />-->
<!--        <Contact />-->
    </div>
    <Footer />
</template>

<script>
import OrderHistory from "../Components/OrderHistory.vue";
import Visitit from '../Components/Visitit.vue';
import Slider from '../Components/Slider.vue';
import Productsintro from "../Components/Productsintro.vue";
import Contact from "../Components/Contact.vue";
import Search from "../Components/Search.vue";
import Testimonial from "../Components/Testimonial.vue";
import AboutUsText from "../Components/AboutUsText.vue";
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import ProductCardDB from "@/Components/ProductCardDB.vue";
import Roulette from "@/Components/Roulette.vue";

export default {
    name: 'Home',
    components: {
        Roulette,
        ProductCardDB,
        Navbar,
        Visitit,
        Slider,
        Productsintro,
        Contact,
        Search,
        Testimonial,
        AboutUsText,
        Footer,
        OrderHistory,
    },
    props: {
        routes: Object,
        user: Object // Accept the user data
    },
    data() {
        return {
            products: [], // Store products fetched from API
            filters: {
                price_min: 0,
                price_max: 100000,
            },
            isEditing: false,
            editForm: {
                name: '',
                email: ''
            },
            successMessage: '',
            errorMessage: '',
            loading: false,
            deleting: false,
            showDeleteModal: false,
            deletePassword: ''
        };
    },
    mounted() {
        // this.fetchProducts();
        this.editForm.name = this.user?.name || '';
        this.editForm.email = this.user?.email || '';
    },
    methods: {
        // fetchProducts() {
        //     fetch('/products/laptops') // Adjust API endpoint if necessary
        //         .then((response) => response.json())
        //         .then((data) => {
        //             console.log('Fetched products:', data);
        //             this.products = data;
        //         })
        //         .catch((error) => {
        //             console.error('Error fetching products:', error);
        //         });
        // },
        fetchProducts() {
            const params = new URLSearchParams({
                price_min: this.filters.price_min ?? 0,
                price_max: this.filters.price_max ?? 100000,
            }).toString();

            fetch(`/products/drinks?${params}`)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log("Fetched products:", data);
                    this.products = data;
                })
                .catch((error) => {
                    console.error("Error fetching products:", error);
                });
        },
        toggleEditMode() {
            this.isEditing = !this.isEditing;
            // Reset messages when toggling edit mode
            this.successMessage = '';
            this.errorMessage = '';

            // If entering edit mode, populate form with current data
            if (this.isEditing) {
                this.editForm.name = this.user.name;
                this.editForm.email = this.user.email;
            }
        },

        cancelEdit() {
            this.isEditing = false;
            // Reset form to original values
            this.editForm.name = this.user.name;
            this.editForm.email = this.user.email;
            this.successMessage = '';
            this.errorMessage = '';
        },

        updateProfile() {
            this.loading = true;
            this.successMessage = '';
            this.errorMessage = '';

            // Simple validation
            if (!this.editForm.name || !this.editForm.email) {
                this.errorMessage = 'Name and email are required';
                this.loading = false;
                return;
            }

            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('name', this.editForm.name);
            formData.append('email', this.editForm.email);

            fetch('/profile/update', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => {
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            if (!response.ok) {
                                throw new Error(JSON.stringify(data));
                            }
                            return data;
                        });
                    } else {
                        // Handle non-JSON response (HTML error page)
                        return response.text().then(text => {
                            throw new Error(`Server returned HTML instead of JSON. Status: ${response.status}`);
                        });
                    }
                })
                .then((data) => {
                    // this.successMessage = 'Profile updated successfully!';
                    this.successMessage = this.$t('ProfileUpdated');

                    // Update the user data with new values
                    this.user.name = this.editForm.name;
                    this.user.email = this.editForm.email;

                    // Exit edit mode after a short delay
                    setTimeout(() => {
                        this.isEditing = false;
                    }, 1500);
                })
                .catch(error => {
                    console.error('Error updating profile:', error);

                    // Check if it's a validation error from Laravel
                    try {
                        const errorData = JSON.parse(error.message.replace('Server error: 500 - ', ''));
                        if (errorData.errors) {
                            // Display validation errors
                            this.errorMessage = Object.values(errorData.errors)[0][0];
                            return;
                        }
                    } catch (e) {
                        // Not a JSON response, use generic error message
                    }

                    // this.errorMessage = 'Failed to update profile. Please check your inputs and try again.';

                    // Check for specific error messages
                    if (error.message.includes('HTML instead of JSON')) {
                        this.errorMessage = 'Server error occurred. Please check your Laravel logs for details.';
                    } else {
                        this.errorMessage = 'Failed to update profile. Please try again.';
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        // Delete account methods
        confirmDelete() {
            this.showDeleteModal = true;
            this.deletePassword = '';
        },

        cancelDelete() {
            this.showDeleteModal = false;
            this.deletePassword = '';
            this.errorMessage = '';
        },

        deleteAccount() {
            this.deleting = true;
            this.errorMessage = '';

            const formData = new FormData();
            formData.append('_method', 'DELETE');
            formData.append('password', this.deletePassword);

            fetch('/profile-delete', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => {
                    if (response.redirected) {
                        // Account was deleted successfully, redirect to home page
                        window.location.href = '/';
                        return;
                    }

                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            if (!response.ok) {
                                throw new Error(JSON.stringify(data));
                            }
                            return data;
                        });
                    } else {
                        return response.text().then(text => {
                            throw new Error(`Server returned HTML instead of JSON. Status: ${response.status}`);
                        });
                    }
                })
                .then(() => {
                    // If we get JSON response instead of redirect
                    window.location.href = '/';
                })
                .catch(error => {
                    console.error('Error deleting account:', error);

                    try {
                        const errorData = JSON.parse(error.message);
                        if (errorData.errors && errorData.errors.password) {
                            this.errorMessage = errorData.errors.password[0];
                            return;
                        }
                        if (errorData.message) {
                            this.errorMessage = errorData.message;
                            return;
                        }
                    } catch (e) {
                        // Not a JSON response
                    }

                    this.errorMessage = 'Failed to delete account. Please check your password and try again.';
                })
                .finally(() => {
                    this.deleting = false;
                });
        }
    },
}
</script>

<style scoped>
.main-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 70px; /* Adjust as needed */
}

.user-card-full {
    overflow: hidden;
}

.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 20px 0 rgba(69,90,100,0.08);
    box-shadow: 0 1px 20px 0 rgba(69,90,100,0.08);
    border: none;
    margin-bottom: 30px;
}

.m-r-0 {
    margin-right: 0px;
}

.m-l-0 {
    margin-left: 0px;
}

.user-card-full .user-profile {
    border-radius: 5px 0 0 5px;
}

.bg-c-lite-green {
    background: #A34FAFFF;
}

.user-profile {
    padding: 20px 0;
}

.card-block {
    padding: 1.25rem;
}

.m-b-25 {
    margin-bottom: 25px;
    justify-self: center;
}

.img-radius {
    border-radius: 5px;
}

h6 {
    font-size: 14px;
}

.card .card-block p {
    line-height: 25px;
}

@media only screen and (min-width: 1400px){
    p {
        font-size: 14px;
    }
}

.card-block {
    padding: 1.25rem;
}

.b-b-default {
    border-bottom: 1px solid #e0e0e0;
}

.m-b-20 {
    margin-bottom: 20px;
}

.p-b-5 {
    padding-bottom: 5px !important;
}

.card .card-block p {
    line-height: 25px;
}

.m-b-10 {
    margin-bottom: 10px;
}

.text-muted {
    color: #919aa3 !important;
}

.b-b-default {
    border-bottom: 1px solid #e0e0e0;
}

.f-w-600 {
    font-weight: 600;
}

.m-b-20 {
    margin-bottom: 20px;
}

.m-t-40 {
    margin-top: 20px;
}

.p-b-5 {
    padding-bottom: 5px !important;
}

.m-b-10 {
    margin-bottom: 10px;
}

.m-t-40 {
    margin-top: 20px;
}

.user-card-full .social-link li {
    display: inline-block;
}

.user-card-full .social-link li a {
    font-size: 20px;
    margin: 0 10px 0 0;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.form-control {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
}

.btn-primary {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    color: #fff;
    background-color: #0069d9;
    border-color: #0062cc;
}

.btn-secondary {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    color: #fff;
    background-color: #5a6268;
    border-color: #545b62;
}

.m-l-10 {
    margin-left: 10px;
}

.m-t-20 {
    margin-top: 20px;
}

.alert {
    position: relative;
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.25rem;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.alert-error {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.edit-icon {
    cursor: pointer;
    transition: color 0.3s;
}

.edit-icon:hover {
    color: #ffc107;
}

.subscription-status-display {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 10px;
}

.status-active {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-inactive {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.subscription-cta {
    margin-top: 10px;
}

.subscription-cta .btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
}

/* CONFIRM DELETION MODAL */
/* === Modal Backdrop === */
.modal-backdrop {
    position: fixed;
    inset: 0; /* shorthand for top/right/bottom/left = 0 */
    background: rgba(0, 0, 0, 0.5); /* dark transparent overlay */
    backdrop-filter: blur(4px); /* soft blur effect */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1050; /* above everything else */
    animation: fadeIn 0.3s ease;
}

/* === Modal Content === */
.modal-content {
    background: #ffffff;
    border-radius: 12px;
    width: 90%;
    max-width: 400px;
    padding: 1.5rem;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    animation: slideUp 0.3s ease;
}

/* === Modal Header === */
.modal-header {
    border-bottom: 1px solid #eee;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #333;
}

/* === Modal Body === */
.modal-body {
    margin-bottom: 1.25rem;
    color: #555;
}

.modal-body p {
    margin-bottom: 0.75rem;
    line-height: 1.5;
}

/* === Modal Footer === */
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

/* === Form Group === */
.modal-body .form-group {
    margin-top: 10px;
}

.modal-body label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.modal-body input[type="password"] {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    transition: border-color 0.2s;
}

.modal-body input[type="password"]:focus {
    border-color: #007bff;
    outline: none;
}

/* === Buttons inside modal === */
.modal-footer .btn {
    padding: 0.4rem 0.9rem;
    border-radius: 6px;
    font-size: 0.95rem;
}

.modal-footer .btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.modal-footer .btn-secondary:hover {
    background-color: #5a6268;
}

.modal-footer .btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.modal-footer .btn-danger:hover {
    background-color: #c82333;
}

/* === Animations === */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

</style>
