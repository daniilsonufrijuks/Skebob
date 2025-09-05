<template>
    <Navbar/>
    <Search />
    <Slider />

    <div class="main-container">
        <Visitit />
        <div class="auction-page">
<!--            <h1>Auction Listings</h1>-->
            <!-- Add Auction Button -->
            <div class="add-auction-container">
                <button @click="goToAddAuction" class="add-auction-btn">+</button>
            </div>

            <!-- Auction items list -->
            <div class="auction-list">
                <AuctionCardDB v-for="item in auctionItems" :key="item.id" :item="item"/>
            </div>
        </div>
        <Contact />
    </div>
    <Footer/>
</template>

<script>
import ProductCardDB from "@/Components/ProductCardDB.vue";
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import Slider from "@/Components/Slider.vue";
import Search from "@/Components/Search.vue";
import Visitit from "@/Components/Visitit.vue";
import Contact from "@/Components/Contact.vue";
import AuctionCardDB from "@/Components/AuctionCardDB.vue";

export default {
    components: {AuctionCardDB, Contact, Visitit, Search, Slider, Footer, Navbar, ProductCardDB},
    data() {
        return {
            auctionItems: [], // This will hold the auction items
        };
    },
    mounted() {
        this.fetchAuctionItems();
    },
    methods: {
        // async fetchAuctionItems() {
        //     try {
        //         const response = await axios.get('/auctionitems');
        //         this.auctionItems = response.data;
        //     } catch (error) {
        //         console.error('Error fetching auction items:', error);
        //     }
        // },
        fetchAuctionItems() {
            fetch(`/auction/items`)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log("Fetched products:", data);
                    this.auctionItems = data;
                })
                .catch((error) => {
                    console.error("Error fetching products:", error);
                });
        },
        goToAddAuction() {
            window.location.href = `/auction/add`; // Redirect to the add auction page
        },
        placeBid(itemId) {
            // Handle the placing bid logic (You may want to handle this with a modal or a form)
            console.log(`Placing a bid on item ${itemId}`);
        }
    },
};
</script>

<style scoped>
.main-container {
    display: flex;
    flex-direction: column;
    gap: 70px; /* Adjust as needed */
}

.auction-page {
    padding: 20px;
}

.auction-item {
    border: 1px solid #ccc;
    margin-bottom: 20px;
    padding: 10px;
}

.auction-item img {
    width: 100px;
    height: 100px;
}

.auction-item button {
    margin-top: 10px;
}

.add-auction-btn {
    align-items: center;
    appearance: none;
    border-radius: 4px;
    border-style: none;
    box-shadow: rgba(0, 0, 0, .2) 0 3px 1px -2px,rgba(0, 0, 0, .14) 0 2px 2px 0,rgba(0, 0, 0, .12) 0 1px 5px 0;
    box-sizing: border-box;
    color: #fff;
    background-color: #6a0dad;
    cursor: pointer;
    display: inline-flex;
    font-family: Roboto,sans-serif;
    font-size: .875rem;
    font-weight: 500;
    height: 36px;
    justify-content: center;
    letter-spacing: .0892857em;
    line-height: normal;
    min-width: 64px;
    outline: none;
    overflow: visible;
    padding: 0 16px;
    position: relative;
    text-align: center;
    text-decoration: none;
    text-transform: uppercase;
    transition: box-shadow 280ms cubic-bezier(.4, 0, .2, 1);
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    vertical-align: middle;
    will-change: transform,opacity;
}


</style>
