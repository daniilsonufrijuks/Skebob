<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import {route} from "ziggy-js";
import Wave from "../../Components/Wave.vue";
import Particles from "../../Components/BG_Particles.vue";
import {computed, ref, watch} from 'vue';
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
    // name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

// Check if email error is about duplicate
const isEmailAlreadyRegistered = computed(() => {
    const emailError = form.errors.email;
    console.log('Email error:', emailError); // DEBUG
    if (!emailError) return false;

    const errorText = String(emailError).toLowerCase();
    return errorText.includes('already') || errorText.includes('taken') || errorText.includes('exists');
});

// Password strength indicators
const passwordStrength = computed(() => {
    if (!form.password) return { strength: 0, message: '' };

    let strength = 0;
    let message = '';

    // Check length
    if (form.password.length >= 8) strength += 25;

    // Check for letters
    if (/[a-zA-Z]/.test(form.password)) strength += 25;

    // Check for numbers
    if (/\d/.test(form.password)) strength += 25;

    // Check for symbols
    if (/[@$!%*?&]/.test(form.password)) strength += 25;

    // Determine message
    if (strength <= 25) message = 'Very Weak';
    else if (strength <= 50) message = 'Weak';
    else if (strength <= 75) message = 'Good';
    else message = 'Strong';

    return { strength, message };
});

const submit = () => {
    form.post(route('registration'), {
        onError: (errors) => console.log(errors),
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

// defineProps({
//     routes: {
//         type: Object,
//         required: true,
//     },
// });
</script>

<template>
    <section class="container forms">
        <Particles/>

        <Link :href="route('home')" class="back-button">
            {{ $t('BackToHome') }}
        </Link>

        <select
            v-model="currentLang"
            class="lang-switcher"
        >
            <option value="en">EN</option>
            <option value="lv">LV</option>
        </select>

        <div class="form registration">
            <img class="imglogo" src="/skebob.png"/>
            <div class="form-content">
                <header>{{ $t('Registration') }}</header>

                <!-- Show specific message for duplicate email -->
                <div v-if="isEmailAlreadyRegistered"
                     class="error-message general-error email-exists-error">
                    <div class="email-exists-content">
                        <strong>Email Already Registered</strong>
                        <p>{{ form.errors.email }}</p>
                        <div class="suggestion-links">
                            <Link :href="route('login')" class="suggestion-link">
                                Try logging in instead
                            </Link>
                            <span class="suggestion-divider">or</span>
                            <button type="button" @click="form.email = ''; form.clearErrors('email')" class="suggestion-link">
                                Use a different email
                            </button>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="submit">
                    <div class="field input-field">
                        <input
                            type="email"
                            v-model="form.email"
                            :placeholder="$t('FormEmail')"
                            class="input"
                            :class="{ 'error': form.errors.email }"
                            required
                        >
                        <!-- Show regular error only if it's NOT the "already registered" error -->
                        <div v-if="form.errors.email && !isEmailAlreadyRegistered"
                             class="error-message">
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="field input-field">
                        <input
                            type="password"
                            v-model="form.password"
                            :placeholder="$t('Password')"
                            class="password"
                            :class="{ 'error': form.errors.password }"
                            required
                        >
                        <div v-if="form.errors.password" class="error-message">
                            {{ form.errors.password }}
                        </div>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div v-if="form.password" class="password-strength">
                        <div class="strength-bar">
                            <div
                                class="strength-fill"
                                :style="{ width: passwordStrength.strength + '%' }"
                                :class="{
                                    'very-weak': passwordStrength.strength <= 25,
                                    'weak': passwordStrength.strength > 25 && passwordStrength.strength <= 50,
                                    'good': passwordStrength.strength > 50 && passwordStrength.strength <= 75,
                                    'strong': passwordStrength.strength > 75
                                }"
                            ></div>
                        </div>
                        <span class="strength-text">{{ passwordStrength.message }}</span>
                    </div>

                    <!-- Password Requirements -->
                    <div class="password-requirements">
                        <p>Password must contain:</p>
                        <ul>
                            <li :class="{ 'met': form.password.length >= 8 }">At least 8 characters</li>
                            <li :class="{ 'met': /[a-zA-Z]/.test(form.password) }">At least one letter</li>
                            <li :class="{ 'met': /\d/.test(form.password) }">At least one number</li>
                            <li :class="{ 'met': /[@$!%*?&]/.test(form.password) }">At least one symbol (@$!%*?&)</li>
                        </ul>
                    </div>

                    <!-- Password Confirmation Field -->
                    <div class="field input-field">
                        <input
                            type="password"
                            v-model="form.password_confirmation"
                            :placeholder="$t('RepeatPassword')"
                            class="password"
                            :class="{ 'error': form.errors.password_confirmation }"
                            required
                        >
                        <div v-if="form.errors.password_confirmation" class="error-message">
                            {{ form.errors.password_confirmation }}
                        </div>
                    </div>

                    <div class="field button-field">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            :class="{ 'loading': form.processing }"
                        >
                            <span v-if="form.processing">Creating Account...</span>
                            <span v-else>{{ $t('signup') }}</span>
                        </button>
                    </div>
                </form>

                <div class="form-link">
                    <span>{{ $t('AlreadyHaveAnAccount') }}? <a href="/login" class="link signup-link">{{ $t('login') }}</a></span>
                </div>
            </div>
        </div>
    </section>

    <br><br>
    <Wave/>
</template>


<style scoped>
body {
    background-color: #7e411e;
}

/* ========== General Layout ========== */
.container {
    min-height: 100vh;
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
    margin: 20px 0;
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

/* ========== Password Strength Indicator ========== */
.password-strength {
    margin-top: 10px;
}

.strength-bar {
    width: 100%;
    height: 5px;
    background-color: #e0e0e0;
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 5px;
}

.strength-fill {
    height: 100%;
    transition: width 0.3s ease, background-color 0.3s ease;
}

.strength-fill.very-weak {
    background-color: #dc3545;
}

.strength-fill.weak {
    background-color: #fd7e14;
}

.strength-fill.good {
    background-color: #ffc107;
}

.strength-fill.strong {
    background-color: #28a745;
}

.strength-text {
    font-size: 12px;
    color: #666;
}

/* ========== Password Requirements ========== */
.password-requirements {
    margin-top: 10px;
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 4px;
    border-left: 4px solid #985016;
}

.password-requirements p {
    margin: 0 0 8px 0;
    font-size: 12px;
    font-weight: 600;
    color: #495057;
}

.password-requirements ul {
    margin: 0;
    padding-left: 20px;
}

.password-requirements li {
    font-size: 11px;
    color: #6c757d;
    margin-bottom: 4px;
    transition: color 0.3s ease;
}

.password-requirements li.met {
    color: #28a745;
    text-decoration: line-through;
}

/* ========== Email Exists Error ========== */
.email-exists-error {
    background-color: #fff3cd;
    border-color: #ffeaa7;
    color: #856404;
}

.email-exists-content {
    padding: 10px;
}

.email-exists-content strong {
    display: block;
    margin-bottom: 8px;
    font-size: 16px;
}

.email-exists-content p {
    margin-bottom: 12px;
    font-size: 14px;
}

.suggestion-links {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.suggestion-link {
    color: #985016;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    padding: 4px 8px;
    border-radius: 4px;
    background-color: rgba(152, 80, 22, 0.1);
    transition: all 0.3s ease;
}

.suggestion-link:hover {
    background-color: #985016;
    color: white;
    text-decoration: none;
}

.suggestion-divider {
    color: #666;
    font-size: 12px;
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
