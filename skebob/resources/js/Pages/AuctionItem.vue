<template>
    <!--    <Navbar :routes="routes" />-->
    <Navbar :routes="routes"/>
    <Search />
    <Slider/>
    <div class="main-container">
        <Visitit />
        <!--        <Productsintro />-->
        <AuctionCard :item="selectedProduct"/>
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
// import ProductCard from "@/Components/ProductCard.vue";
import AuctionCard from "@/Components/AuctionCard.vue";
//import {useRoute} from "ziggy-js";
export default {
    name: 'AuctionItem',
    components: {
        AuctionCard,
        Navbar,
        Visitit,
        Slider,
        Productsintro,
        Contact,
        Search,
        Testimonial,
        AboutUsText,
        Footer,
    },
    props: {
        routes: Object,
        productId: {
            type: [String, Number],
            required: true
        }
    },
    data() {
        return {
            selectedProduct: null, // Store the selected product data here
            // routes: {}  // Assuming you have some routing data
        };
    },
    mounted() {

        const productId = this.$props.productId || null;
        console.log('Product ID:', productId);
        //const productId = 1;

        if (productId) {
            this.fetchAuctionItem(productId);
        } else {
            console.error('Product ID not found in query parameters.');
        }
    },
    methods: {
        fetchAuctionItem(productId) {
            // Fetch product details from an API endpoint
            fetch(`/auctionitems/${productId}`)  // Adjust the API endpoint
                .then((response) => response.json())
                .then((data) => {
                    this.selectedProduct = data;
                    console.log('Fetched product:', this.selectedProduct);
                })
                .catch((error) => {
                    console.error('Error fetching product details:', error);
                });
        }
        // async fetchAuctionItem(productId) {
        //     console.log('fetchAuctionItem called');
        //     try {
        //         const response = await fetch(`/auctionitems/${productId}`);
        //         if (!response.ok) {
        //             throw new Error(`HTTP error! Status: ${response.status}`);
        //         }
        //         this.selectedProduct = await response.json();
        //         console.log('Fetched auction item:', this.selectedProduct);
        //     } catch (error) {
        //         console.error('Error fetching auction item details:', error);
        //     }
        // },
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
