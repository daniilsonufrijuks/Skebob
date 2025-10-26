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

                <!-- Display general errors -->
                <div v-if="form.hasErrors" class="error-message general-error">
                    <div v-if="form.errors.email && !form.errors.password">
                        {{ form.errors.email }}
                    </div>
                    <div v-else-if="Object.keys(form.errors).length > 0">
                        Invalid credentials. Please try again.
                    </div>
                </div>

                <form @submit.prevent="submit"  autocomplete="off">
                    <div class="field input-field">
                        <input
                            type="email"
                            v-model="form.email"
                            :placeholder="$t('FormEmail')"
                            class="input"
                            :class="{ 'error': form.errors.email }"
                            required
                            autocomplete="off"
                        >
                        <div v-if="form.errors.email" class="error-message">
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <div class="field input-field">
                        <input
                            type="password"
                            v-model="form.password"
                            :placeholder="$t('Password')"
                            class="password"
                            :class="{ 'error': form.errors.password }"
                            required
                            autocomplete="off"
                        >
                        <i class='bx bx-hide eye-icon'></i>
                        <div v-if="form.errors.password" class="error-message">
                            {{ form.errors.password }}
                        </div>
                    </div>
<!--                    <div class="form-link">-->
<!--                        <a href="#" class="forgot-pass">{{ $t('ForgotPassword') }}?</a>-->
<!--&lt;!&ndash;                        <a href="#" class="forgot-pass">Forgot password?</a>&ndash;&gt;-->
<!--                    </div>-->
                    <div class="field button-field">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            :class="{ 'loading': form.processing }"
                        >
                            <span v-if="form.processing">Logging in...</span>
                            <span v-else>{{ $t('login') }}</span>
                        </button>
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

/* ========== General Layout ========== */
.container {
    height: 100vh;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

/* ========== Form Styles ========== */
.form {
    position: relative;
    width: 100%;
    max-width: 400px;
    padding: 2rem;
    border-radius: 12px;
    background: #fff;
    outline: 2px solid #d87220;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.form.signup {
    opacity: 0;
    pointer-events: none;
}

.forms.show-signup .form.signup {
    opacity: 1;
    pointer-events: auto;
}

.forms.show-signup .form.login {
    opacity: 0;
    pointer-events: none;
}

/* ========== Logo ========== */
.imglogo {
    max-width: 60px;
    height: auto;
    display: block;
    margin: 0 auto;
}

/* ========== Text + Headers ========== */
header {
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 600;
    color: #232836;
    text-align: center;
}

/* ========== Form Inputs & Buttons ========== */
form {
    margin-top: 30px;
}

.field {
    position: relative;
    height: 50px;
    width: 100%;
    margin-top: 20px;
    border-radius: 6px;
}

.field input,
.field button {
    height: 100%;
    width: 100%;
    border: none;
    font-size: clamp(0.9rem, 2.5vw, 1rem);
    font-weight: 400;
    border-radius: 6px;
}

.field input {
    outline: none;
    padding: 0 15px;
    border: 1px solid #cacaca;
    background-color: #fff;
    transition: border-color 0.2s ease;
}

.field input:focus {
    border-color: #985016;
    border-bottom-width: 2px;
}

.eye-icon {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    font-size: 18px;
    color: #8b8b8b;
    cursor: pointer;
    padding: 5px;
}

.field button {
    color: #fff;
    background-color: #985016;
    transition: all 0.3s ease;
    cursor: pointer;
}

.field button:hover {
    background-color: #d87220;
    transform: translateY(-1px);
}

.field button.loading,
.field button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* ========== Form Links ========== */
.form-link {
    text-align: center;
    margin-top: 15px;
}

.form-link span,
.form-link a {
    font-size: 14px;
    font-weight: 400;
    color: #232836;
}

.form a {
    color: #d87220;
    text-decoration: none;
}

.form-content a:hover {
    text-decoration: underline;
}

/* ========== Error Messages ========== */
.error-message {
    color: #dc3545;
    font-size: 14px;
    margin-top: 5px;
    padding: 5px;
    border-radius: 4px;
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
}

.general-error {
    margin-bottom: 15px;
    text-align: center;
}

.input.error,
.password.error {
    border-color: #dc3545 !important;
    border-width: 2px !important;
}

/* ========== Back Button ========== */
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

/* ========== Language Switcher ========== */
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

/* ========== Focus Styles (Accessibility) ========== */
input:focus,
button:focus,
select:focus {
    outline: 2px solid #985016;
    outline-offset: 2px;
}

/* ========== Media Queries ========== */

/* Small devices (phones) */
@media (max-width: 600px) {
    .form {
        padding: 1.5rem;
        margin: 0 1rem;
    }

    .field {
        margin-top: 15px;
    }

    .field button {
        height: 48px;
        font-size: 1rem;
    }

    .lang-switcher,
    .back-button {
        position: fixed;
        z-index: 50;
        top: 10px;
        font-size: 0.9rem;
    }

    .lang-switcher {
        right: 10px;
        padding: 6px 10px;
    }

    .back-button {
        left: 10px;
        padding: 6px 10px;
    }
}

/* Medium screens (tablets) */
@media (min-width: 600px) and (max-width: 900px) {
    .form {
        max-width: 480px;
        padding: 2rem 2.5rem;
    }
}

/* Extra small screens */
@media (max-width: 400px) {
    .form {
        padding: 20px 10px;
    }
}
</style>
