<!-- resources/js/Layouts/DefaultLayout.vue -->
<template>
    <div>
<!--        <Navbar :routes="routes"/>-->
        <slot />
        <!--         slot used to make opportunity for home or others pages put other objects inside default layout tags-->
<!--        <Footer />-->
    </div>
</template>

<script>
import Navbar from '../Components/Navbar.vue';
import Footer from "../Components/Footer.vue";

export default {
    components: {
        Footer,
        Navbar
    },
    props: {
        routes: Object
    }
};
</script>
