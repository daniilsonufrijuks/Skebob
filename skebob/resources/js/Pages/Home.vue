<template>
<!--    <Navbar :routes="routes" />-->
<!--    <Banner/>-->
<!--    <RobotAssistant />-->
    <Navbar :routes="routes"/>
    <Search />
    <Slider/>
    <div class="main-container">
        <Visitit />
        <div class="products">
            <ProductCardDB v-for="product in products" :key="product.id" :product="product" />
        </div>
<!--        <Productsintro />-->
        <Testimonial />
        <chatwithai />
        <SectionCom />
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
import ProductCardDB from "@/Components/ProductCardDB.vue";
import chatwithai from "@/Components/chatwithai.vue";
import SectionCom from "@/Components/SectionCom.vue";

export default {
    name: 'Home',
    components: {
        SectionCom,
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
        chatwithai,
    },
    props: {
        routes: Object
    },
    data() {
        return {
            products: [], // Store products fetched from API
            filters: {
                price_min: 0,
                price_max: 100000,
            },
        };
    },
    mounted() {
        this.fetchProducts();
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

            fetch(`/products/laptops?${params}`)
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
    },
};
</script>

<style scoped>
.main-container {
    display: flex;
    flex-direction: column;
    gap: 70px; /* Adjust as needed */
}

.products {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Two equal columns */
    gap: 20px; /* Adjust spacing between product cards */
    justify-content: center; /* Center product cards */
    max-width: 1000px; /* Optional: Set a max width for better alignment */
    margin: 0 auto; /* Center the grid */
}

@media (max-width: 1120px) {
    .products {
        grid-template-columns: 1fr; /* One column on smaller screens */
    }
}
</style>
