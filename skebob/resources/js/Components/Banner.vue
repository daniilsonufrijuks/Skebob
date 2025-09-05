<template>
    <div v-if="showBanner" class="banner">
        <div class="banner-content">
            <p>🔥 Limited-Time Offer! Get <strong>70% OFF</strong> on all items! 🔥</p>
            <button @click="closeBanner">X</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showBanner: true
        };
    },
    methods: {
        closeBanner() {
            this.showBanner = false;
            localStorage.setItem("bannerDismissed", "true");
        }
    },
    mounted() {
        // if (localStorage.getItem("bannerDismissed") === "true") {
        //     this.showBanner = false;
        // }
        // Ensure this is checked after the page is fully loaded
        // setTimeout(() => {
        //     if (localStorage.getItem("bannerDismissed") === "true") {
        //         this.showBanner = false;
        //     }
        // }, 10000); // Add a small delay for better reliability
        // console.log("Component mounted"); // Debugging log
        // // Check localStorage after the component is mounted
        // this.$nextTick(() => {
        //     if (localStorage.getItem("bannerDismissed") === "true") {
        //         this.showBanner = false;
        //         console.log("Banner already dismissed"); // Debugging log
        //     } else {
        //         console.log("Banner will be shown"); // Debugging log
        //     }
        // });
    }
};
</script>

<style scoped>
.banner {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    /*background: red;*/
    background: linear-gradient(135deg, #ed5f7f, #9a1b06); /* Gradient from red to a lighter shade */
    color: white;
    text-align: center;
    padding: 10px;
    font-size: 18px;
    font-weight: bold;
    z-index: 1000;
}
.banner-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 90%;
    margin: auto;
}
button {
    background: white;
    color: red;
    border: none;
    padding: 5px 10px;
    font-size: 16px;
    cursor: pointer;
}
</style>
