<template>
    <!--    <Navbar :routes="routes" />-->
    <Banner/>
    <Navbar :routes="routes"/>
    <Search />
    <div class="main-container">
        <CQuiz/>
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
import Banner from "@/Components/Banner.vue";
import CQuiz from "@/Components/CQuiz.vue";

export default {
    name: 'Home',
    components: {
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
        Banner,
        CQuiz
    },
    props: {
        routes: Object
    },
};
</script>

<style scoped>
.main-container {
    display: flex;
    flex-direction: column;
    gap: 70px; /* Adjust as needed */
}
</style>
