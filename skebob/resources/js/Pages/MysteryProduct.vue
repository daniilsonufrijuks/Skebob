<template>
    <Navbar :routes="routes" />
    <Search />

    <div class="main-container">
        <MysteryBoxProduct :box="selectedBox"/>

        <Testimonial />
        <Contact />
    </div>

    <Footer />
</template>

<script>
import Navbar from "@/Components/Navbar.vue";
import Search from "@/Components/Search.vue";
import Testimonial from "@/Components/Testimonial.vue";
import Contact from "@/Components/Contact.vue";
import Footer from "@/Components/Footer.vue";
import MysteryBoxProduct from "@/Components/MysteryBoxProduct.vue";

export default {
    name: "MysteryBoxPage",
    components: {
        Navbar,
        Search,
        Testimonial,
        Contact,
        Footer,
        MysteryBoxProduct,
    },
    props: {
        routes: Object,
        boxId: {
            type: [String, Number],
            required: true,
        },
    },
    data() {
        return {
            selectedBox: null,
        };
    },
    mounted() {
        const boxId = this.$props.boxId || null;
        if (boxId) {
            this.fetchBoxDetails(boxId);
        } else {
            console.error("Mystery Box ID not found in props.");
        }
    },
    methods: {
        fetchBoxDetails(boxId) {
            fetch(`/mystery-boxes/${boxId}`)
                .then((response) => {
                    if (!response.ok) throw new Error("Failed to fetch box");
                    return response.json();
                })
                .then((data) => {
                    this.selectedBox = data;
                    console.log("Fetched mystery box:", data);
                })
                .catch((error) => {
                    console.error("Error fetching mystery box details:", error);
                });
        },
    },
};
</script>

<style scoped>
.main-container {
    display: flex;
    flex-direction: column;
    gap: 70px;
}
</style>
