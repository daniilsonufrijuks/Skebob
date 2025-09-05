<template>
    <!--    <Navbar :routes="routes" />-->
    <Navbar :routes="routes"/>
    <Search />
    <Slider/>
    <div class="main-container">
        <Visitit />
<!--        <div class="video-section">-->
<!--            <h2>Watch Our Videos</h2>-->
<!--            <div class="videos">-->
<!--                <iframe-->
<!--                    width="560"-->
<!--                    height="315"-->
<!--                    src="https://youtube.com/embed/b85h_ujZ_vg?si=TxTPv8ABd8wJOF4t"-->
<!--                    title="YouTube video player"-->
<!--                    frameborder="0"-->
<!--                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"-->
<!--                    allowfullscreen>-->
<!--                </iframe>-->
<!--                <iframe-->
<!--                    width="560"-->
<!--                    height="315"-->
<!--                    src="https://youtube.com/embed/beW8pCezrdI?si=_6FoX2LEQJmPHtQC"-->
<!--                    title="YouTube video player"-->
<!--                    frameborder="0"-->
<!--                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"-->
<!--                    allowfullscreen>-->
<!--                </iframe>-->
<!--                <iframe-->
<!--                    width="560"-->
<!--                    height="315"-->
<!--                    src="https://youtube.com/embed/WpnLehvOM6E?si=kWKwhcBmqfGb-j0O"-->
<!--                    title="YouTube video player"-->
<!--                    frameborder="0"-->
<!--                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"-->
<!--                    allowfullscreen>-->
<!--                </iframe>-->
<!--            </div>-->
<!--        </div>-->
        <VideosTutor />
        <BooksLibrary />
        <!--        <Productsintro />-->
        <Testimonial />
        <!--        <chatwithai />-->
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
import VideosTutor from "@/Components/VideosTutor.vue";
import BooksLibrary from "@/Components/BooksLib.vue";

export default {
    name: 'Home',
    components: {
        BooksLibrary,
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
        VideosTutor,
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
.video-section {
    text-align: center;
    margin: 50px 0;
}

.video-section h2 {
    font-size: 24px;
    margin-bottom: 20px;
}

.videos {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
}

iframe {
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
</style>
