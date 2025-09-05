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
            // routes: {}  // Assuming you have some routing data
        };
    },
    mounted() {
        // const productId = this.product.id;
        //const productId = this.product.id; // does not work: app-CT79SxUy.js:94 TypeError: Cannot read properties of undefined (reading 'id')
        //this.fetchProductDetails(productId);  // Example: fetch the product details for product ID = 1
        //const route = useRoute();
        //const productId = route.query.id ; // Get the 'id' from the query params
        //this.fetchProductDetails(productId); // need to write productId variable, but it does not work??? (for example e can write 1, fetch works nice)
        //const { productId } = usePage().props.value; // Retrieve productId from server-side props
        //const { productId = null } = this.$props?.value || {};
        //console.log("Query Parameters:", this.$route.query);
        //const productId = this.$route.query.productId;
        // const route = useRoute();
        // const productId = route.query.productId;
        // console.log('Props received:', usePage().props.value);
        // //const { productId } = usePage().props.value;
        //const props = usePage().props.value || {};
        //console.log('Props received from Inertia:', props);

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
    // data() {
    //     return {
    //         products: [] // The array of products
    //     };
    // },
    // mounted() {
    //     this.fetchProducts();
    // },
    // methods: {
    //     fetchProducts() {
    //         fetch('/products/${this.productId}') // Or the appropriate endpoint
    //             .then((response) => response.json())
    //             .then((data) => {
    //                 this.products = data;
    //                 console.log('Fetched products:', this.products);  // Log the products array
    //             })
    //             .catch((error) => console.error('Error fetching products:', error));
    //     }
    // }
    // mounted() {
    //     this.fetchProducts();
    // },
    // methods: {
    //     fetchProducts() {
    //         fetch('/products/{id}') // Or the appropriate endpoint
    //             .then((response) => response.json())
    //             .then((data) => {
    //                 this.products = data;
    //                 console.log('Fetched products:', this.products);  // Log the products array
    //             })
    //             .catch((error) => console.error('Error fetching products:', error));
    //     }
    // },
    // data() {
    //     return {
    //         products: [] // The array of products
    //     };
    // },
}
</script>

<style scoped>
.main-container {
    display: flex;
    flex-direction: column;
    gap: 70px; /* Adjust as needed */
}
</style>
