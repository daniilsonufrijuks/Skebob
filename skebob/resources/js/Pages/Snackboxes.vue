<template>
    <Navbar :routes="routes" />
    <Search />
    <Slider />
    <div class="main-container">
        <Visitit />
        <!-- Filter Inputs -->
        <div class="filters">
            <input
                v-model.number="filters.price_min"
                type="number"
                :placeholder="$t('MinPrice')"
                @input="fetchProducts"
            />
            <input
                v-model.number="filters.price_max"
                type="number"
                :placeholder="$t('MaxPrice')"
                @input="fetchProducts"
            />
            <!-- Sorting Dropdown -->
            <select v-model="sortOrder" @change="sortProducts">
                <option value="asc">{{ $t('LowestPriceFirst') }}</option>
                <option value="desc">{{ $t('HighestPriceFirst') }}</option>
                <!--                <option value="asc">Lowest Price First</option>-->
                <!--                <option value="desc">Highest Price First</option>-->
            </select>
        </div>
        <div class="products">
            <ProductCardDB v-for="product in sortedProducts" :key="product.id" :product="product" />
        </div>
        <Contact />
    </div>
    <Footer />
</template>

<script>
import Visitit from '../Components/Visitit.vue';
import Slider from '../Components/Slider.vue';
import Contact from '../Components/Contact.vue';
import Search from '../Components/Search.vue';
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import ProductCard from "@/Components/ProductCard.vue";
import ProductCardDB from "@/Components/ProductCardDB.vue";

export default {
    name: 'ComponentsPage',
    components: {
        ProductCardDB,
        ProductCard,
        Navbar,
        Visitit,
        Slider,
        Contact,
        Search,
        Footer,
    },
    props: {
        routes: Object,
    },
    data() {
        return {
            products: [], // Store products fetched from API
            filters: {
                price_min: 0,
                price_max: 100000,
            },
            sortOrder: "asc", // Default sorting order
        };
    },
    mounted() {
        this.fetchProducts();

    },
    computed: {
        // Sort products based on the selected order
        sortedProducts() {
            return [...this.products].sort((a, b) => {
                if (this.sortOrder === "asc") {
                    return a.price - b.price;
                } else {
                    return b.price - a.price;
                }
            });
        },
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
                // sort_order: this.sortOrder,
            }).toString();

            // https://www.tofucute.com/lotte-pepero-cookie-cream-biscuit-sticks~p1809.html
            //https://www.tofucute.com/pocky-cloud-biscuit-sticks-cheesecake~p16759.html
            // https://www.tofucute.com/glico-pretz-pretzel-sticks-salt-lemon~p16658.html
            fetch(`/products/snackboxes?${params}`)
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
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Adjust spacing between product cards */
    justify-content: center; /* Center product cards */
}
.filters {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1rem;
}
@media screen and (max-width: 768px) {
    .filters {
        flex-direction: column; /* Stack filters vertically */
        align-items: center;   /* Center the filters horizontally */
        gap: 0.5rem;           /* Adjust spacing between inputs */
    }

    .filters input,
    .filters select {
        width: 100%;          /* Make inputs and select dropdown full-width */
        max-width: 300px;     /* Optionally limit the maximum width */
    }
}
</style>
