<script setup>
import {route} from "ziggy-js";
import { Head, Link, useForm } from '@inertiajs/vue3';
import Wave from "../../Components/Wave.vue";
import Particles from "../../Components/BG_Particles.vue";
import {ref, watch} from 'vue';
import { useI18n } from 'vue-i18n';     // For translating stuff

// For translating function
const { locale } = useI18n({ useScope: 'global' });
const currentLang = ref(localStorage.getItem('lang') || 'en');

// Sync Vue i18n locale with stored value on mount
locale.value = currentLang.value;

// Reactively change locale when dropdown changes
watch(currentLang, (newLang) => {
    locale.value = newLang;
    localStorage.setItem('lang', newLang);
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});
const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <section class="container forms">
        <Particles/>

        <Link :href="route('home')" class="back-button">
            {{ $t('BackToHome') }}
        </Link>

        <select
            v-model="currentLang"
            @change="switchLanguage"
            class="lang-switcher"
        >
            <option value="en">EN</option>
            <option value="lv">LV</option>
        </select>

        <div class="form login">
            <img class="imglogo" src="/skebob.png"/>
            <div class="form-content">
                <header>{{ $t('Login') }}</header>
<!--                <header>Login</header>-->

                <form @submit.prevent="submit"  autocomplete="off">
                    <div class="field input-field">
                        <input type="email" v-model="form.email" :placeholder="$t('FormEmail')" class="input" required autocomplete="off">
                    </div>
                    <div class="field input-field">
                        <input type="password" v-model="form.password" :placeholder="$t('Password')" class="password" required autocomplete="off">
                        <i class='bx bx-hide eye-icon'></i>
                    </div>
                    <div class="form-link">
                        <a href="#" class="forgot-pass">{{ $t('ForgotPassword') }}?</a>
<!--                        <a href="#" class="forgot-pass">Forgot password?</a>-->
                    </div>
                    <div class="field button-field">
                        <button type="submit"
                                :disabled="form.processing"
                        >{{ $t('login') }}</button>
                    </div>
                </form>
                <div class="form-link">
                    <span>{{ $t('DontHaveAnAccount') }}? <a href="/registration" class="link signup-link">{{ $t('signup') }}</a></span>
<!--                    <span>Don't have an account? <a href="/registration" class="link signup-link">Signup</a></span>-->
                </div>
            </div>
<!--            <div class="line"></div>-->
<!--            <div class="media-options">-->
<!--                <a href="#" class="field facebook">-->
<!--                    <i class='bx bxl-facebook facebook-icon'></i>-->
<!--                    <span>Login with Facebook</span>-->
<!--                </a>-->
<!--            </div>-->
<!--            <div class="media-options">-->
<!--                <a href="#" class="field google">-->
<!--                    <img src="#" alt="" class="google-img">-->
<!--                    <span>Login with Google</span>-->
<!--                </a>-->
<!--            </div>-->
        </div>
    </section>
    <Wave/>
</template>


<style scoped>
body {
    background-color: #7e411e;
}

.imglogo {
    max-width: 50px;
    height: auto;
    display: block;
    margin: 0 auto;
}

.container{
    height: 100vh;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    /*background-color: #d87220;*/
    column-gap: 30px;
}

.link:hover {
    cursor: pointer;
}
.form{
    position: absolute;
    max-width: 430px;
    width: 100%;
    padding: 30px;
    border-radius: 6px;
    background: #FFF;
    outline: #d87220 solid 2px;
}
.form.signup{
    opacity: 0;
    pointer-events: none;
}
.forms.show-signup .form.signup{
    opacity: 1;
    pointer-events: auto;
}
.forms.show-signup .form.login{
    opacity: 0;
    pointer-events: none;
}
header{
    font-size: 28px;
    font-weight: 600;
    color: #232836;
    text-align: center;
}
form{
    margin-top: 30px;
}
.form .field{
    position: relative;
    height: 50px;
    width: 100%;
    margin-top: 20px;
    border-radius: 6px;
}
.field input,
.field button{
    height: 100%;
    width: 100%;
    border: none;
    font-size: 16px;
    font-weight: 400;
    border-radius: 6px;
}
.field input{
    outline: none;
    padding: 0 15px;
    border: 1px solid#CACACA;
}
.field input:focus{
    border-bottom-width: 2px;
}
.eye-icon{
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    font-size: 18px;
    color: #8b8b8b;
    cursor: pointer;
    padding: 5px;
}
.field button{
    color: #fff;
    background-color: #985016;
    transition: all 0.3s ease;
    cursor: pointer;
}
.field button:hover{
    background-color: #d87220;
}
.form-link{
    text-align: center;
    margin-top: 10px;
}
.form-link span,
.form-link a{
    font-size: 14px;
    font-weight: 400;
    color: #232836;
}
.form a{
    color: #d87220;
    text-decoration: none;
}
.form-content a:hover{
    text-decoration: underline;
}
.line{
    position: relative;
    height: 1px;
    width: 100%;
    margin: 36px 0;
    background-color: #d4d4d4;
}
.line::before{
    content: 'Or';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #FFF;
    color: #8b8b8b;
    padding: 0 15px;
}
.media-options a{
    display: flex;
    align-items: center;
    justify-content: center;
}
a.facebook{
    color: #fff;
    background-color: #d87220;
}
a.facebook .facebook-icon{
    height: 28px;
    width: 28px;
    color: #d87220;
    font-size: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fff;
}
.facebook-icon,
img.google-img{
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
}
img.google-img{
    height: 20px;
    width: 20px;
    object-fit: cover;
}
a.google{
    border: 1px solid #CACACA;
}
a.google span{
    font-weight: 500;
    opacity: 0.6;
    color: #232836;
}

/* BACK BUTTON */
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

.lang-switcher {
    position: absolute;
    top: 20px;
    right: 20px;
    background-color: #fff;
    color: #985016;
    padding: 8px 12px;
    border-radius: 6px;
    border: 2px solid #985016;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
}

.lang-switcher:hover {
    background-color: #985016;
    color: #fff;
}

@media screen and (max-width: 400px) {
    .form{
        padding: 20px 10px;
    }

}
</style>
