<template>
    <!--    <Navbar :routes="routes" />-->
    <Navbar :routes="routes"/>
    <Search />
<!--    <Slider/>-->
    <div class="main-container">
<!--        <Visitit />-->
<!--        <Productsintro />-->
        <ProductCard :product="selectedProduct"/>
        <Testimonial />
        <Contact />
    </div>
    <Footer />
</template>

<script>
import Visitit from '../Components/Visitit.vue';
import Slider from '../Components/Slider.vue';
import Productsintro from "../Components/Productsintro.vue";
import Contact from "../Components/Contact.vue";
import Search from "../Components/Search.vue";
import Testimonial from "../Components/Testimonial.vue";
import AboutUsText from "../Components/AboutUsText.vue";
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import ProductCard from "@/Components/ProductCard.vue";
//import {useRoute} from "ziggy-js";
export default {
    name: 'Home',
    components: {
        Navbar,
        Visitit,
        Slider,
        Productsintro,
        Contact,
        Search,
        Testimonial,
        AboutUsText,
        Footer,
        ProductCard
    },
    props: {
        routes: Object,
        product: {
            type: Object,
            required: true
        },
        productId: {
            type: [String, Number],
            required: true
        }
    },
    data() {
        return {
            selectedProduct: null, // Store the selected product data here
        };
    },
    mounted() {
        const productId = this.$props.productId || null;
        console.log('Product ID:', productId);
        //const productId = 1;

        if (productId) {
            this.fetchProductDetails(productId);
        } else {
            console.error('Product ID not found in query parameters.');
        }
        // if (productId) {
        //     this.fetchProductDetails(productId);
        // } else {
        //     console.error('Product ID not found in query parameters.');
        // }
    },
    methods: {
        fetchProductDetails(productId) {
            // Fetch product details from an API endpoint
            fetch(`/products/${productId}`)  // Adjust the API endpoint
                .then((response) => response.json())
                .then((data) => {
                    this.selectedProduct = data;
                    console.log('Fetched product:', this.selectedProduct);
                })
                .catch((error) => {
                    console.error('Error fetching product details:', error);
                });
        }
    }
}
</script>

<style scoped>
.main-container {
    display: flex;
    flex-direction: column;
    gap: 70px; /* Adjust as needed */
}
</style>
