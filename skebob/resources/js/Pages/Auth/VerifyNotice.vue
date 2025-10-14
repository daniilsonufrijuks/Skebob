<template>
    <div class="verification-page">
        <Particles/>

        <Link :href="route('home')" class="back-button">
            Back to Home
        </Link>

        <div class="verification-container">
            <img class="logo" src="/skebob.png" alt="Logo" />
            <h1>Email Verification</h1>
            <p>
                We’ve sent a verification link to your email.
                Please check your inbox and click the link to confirm your account.
            </p>

            <form @submit.prevent="resend">
                <button type="submit" :disabled="status === 'sending'">
                    Resend verification email
                </button>
            </form>

            <p v-if="status === 'verification-link-sent'" class="status success">
                A new verification link has been sent!
            </p>
            <p v-if="status === 'verified'" class="status verified">
                Your email has been verified! You can now log in.
            </p>

        </div>
    </div>
    <Wave/>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import {Link, router, usePage} from '@inertiajs/vue3'
import {route} from "ziggy-js";
import Particles from "../../Components/BG_Particles.vue";
import Wave from "../../Components/Wave.vue";

const status = ref('')
const page = usePage()

onMounted(() => {
    if (page.props.verified) {
        status.value = 'verified'
    }
})

function resend() {
    status.value = 'sending'
    router.post('/resend', {}, {
        onSuccess: () => {
            status.value = 'verification-link-sent'
        },
        onFinish: () => {
            if (status.value !== 'verification-link-sent') status.value = ''
        },
    })
}
</script>

<style scoped>
.verification-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    position: relative;
    overflow: hidden;
}

.verification-container {
    max-width: 400px;
    width: 100%;
    background-color: #fff;
    padding: 30px 25px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    text-align: center;
    position: relative;
    z-index: 1;
    outline: #d87220 solid 2px;
}

.logo {
    max-width: 50px;
    margin: 0 auto 20px;
    display: block;
}

h1 {
    font-size: 26px;
    margin-bottom: 15px;
    color: #232836;
}

p {
    font-size: 16px;
    color: #555;
    margin-bottom: 20px;
}

form button {
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #985016;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #d87220;
}

form button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.status {
    margin-top: 15px;
    font-weight: 500;
}

.status.success {
    color: #28a745;
}

.status.verified {
    color: #1d4ed8;
}

.login-link {
    margin-top: 20px;
    font-size: 14px;
    color: #232836;
}

.login-link a {
    color: #d87220;
    text-decoration: none;
    font-weight: 500;
}

.login-link a:hover {
    text-decoration: underline;
}

.back-button {
    position: absolute;
    top: 20px;
    left: 20px;
    background-color: #fff;
    color: #985016;
    padding: 8px 16px;
    border-radius: 6px;
    border: 2px solid #985016;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    z-index: 10;
}

.back-button:hover {
    background-color: #985016;
    color: #fff;
    cursor: pointer;
}
</style>
