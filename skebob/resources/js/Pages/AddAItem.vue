<template>
    <Navbar/>
    <Search />
    <Slider />

    <div class="main-container">
        <div class="add-auction-page">
            <h1>Add New Auction Item</h1>
            <form @submit.prevent="submitForm">
                <div>
                    <label>Title:</label>
                    <input type="text" v-model="form.name" required>
                </div>
                <div>
                    <label>Description:</label>
                    <textarea v-model="form.description" required></textarea>
                </div>
                <div>
                    <label>Starting Price:</label>
                    <input type="number" v-model="form.starting_bid" required>
                </div>
                <div>
                    <label>Starting Date:</label>
                    <input type="date" v-model="form.start_time" required>
                </div>
                <div>
                    <label>Ending Date:</label>
                    <input type="date" v-model="form.end_time" required>
                </div>
                <div>
                    <label>Image:</label>
                    <input type="file" @change="handleFileUpload">
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
        <Contact />
    </div>
    <Footer/>
</template>

<script>
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import {router, usePage} from '@inertiajs/vue3';
import Slider from "@/Components/Slider.vue";
import Search from "@/Components/Search.vue";
import Contact from "@/Components/Contact.vue";

export default {
    components: {Contact, Search, Slider, Navbar, Footer },
    data() {
        return {
            user: usePage().props.auth.user,
            form: {
                name: '',
                description: '',
                starting_bid: '',
                img: null,
                start_time: '',
                end_time: '',
            }
        };
    },
    mounted() {
        // Check if user is authenticated
        this.isAuthenticated = !!usePage().props.auth.user;
    },
    methods: {
        handleFileUpload(event) {
            // this.form.img = event.target.files[0];
            const file = event.target.files[0];
            if (file) {
                this.form.img = file; // Ensure img is a File object
            }
        },
        submitForm() {
            if (!this.isAuthenticated) {
                alert("You must be logged in to add an auction item.");
                window.location.href = "/login"; // Redirect to login
                return;
            }

            const formData = new FormData();
            formData.append('name', this.form.name);
            formData.append('description', this.form.description);
            formData.append('starting_bid', this.form.starting_bid);
            formData.append('img', this.form.img);
            formData.append('start_time', this.form.start_time);
            formData.append('end_time', this.form.end_time);
            console.log([...formData.entries()]);

            // fetch('/auction/store', {
            //     method: 'POST',
            //     body: formData,
            //     headers: {
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //     }
            // })
            //     .then(response => response.json())
            //     .then(data => {
            //         console.log('Auction item added:', data);
            //         // router.get('/auction'); // Redirect back to the auction page
            //     })
            //     .catch(error => console.error('Error adding auction item:', error));
            this.$inertia.post('/auction/store', formData, {
                onSuccess: () => {
                    // Clear the form on success
                    this.form = {
                        name: '',
                        description: '',
                        starting_bid: '',
                        img: null,
                        start_time: '',
                        end_time: '',
                    };
                },
                onError: (errors) => {
                    console.error('Failed to add auction item:', errors);
                },
            });
        }
    }
};
</script>

<style scoped>
.add-auction-page {
    max-width: 600px;
    margin: auto;
    padding: 20px;
}

input, textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background-color: #0056b3;
}
</style>
