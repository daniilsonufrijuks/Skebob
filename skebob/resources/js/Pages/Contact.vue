<template>
    <Navbar :routes="routes"/>
    <Search />
    <Slider/>
    <div class="main-container">
        <Visitit />
<!--        <Productsintro />-->
        <Contacts />
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
import Contacts from "../Components/Contacts.vue";
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";

export default {
    name: 'Home',
    components: {
        Navbar,
        Visitit,
        Slider,
        Productsintro,
        Contact,
        Search,
        Contacts,
        Footer
    },
    props: {
        routes: Object
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
