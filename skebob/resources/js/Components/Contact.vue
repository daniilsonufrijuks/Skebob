<template>
    <section class="contact-section">
        <div class="contact-container">
            <div class="contact-header">
                <h2 class="contact-title">Get in Touch</h2>
                <p class="contact-subtitle">
                    Have questions about our snacks or need help with your order? We'd love to hear from you!
                </p>
            </div>

            <div class="contact-grid">
                <!-- Contact Form -->
                <div class="contact-form-card">
                    <div class="form-header">
                        <h3 class="form-title">Send Us a Message</h3>
                    </div>
                    <div class="form-content">
                        <form @submit.prevent="submit" class="contact-form">
                            <div class="form-row">
                                <div class="form-field">
                                    <label for="name" class="field-label">Name *</label>
                                    <input
                                        id="name"
                                        v-model="form.name"
                                        required
                                        name="name"
                                        placeholder="Name"
                                        class="form-input"
                                    />
                                </div>
                                <div class="form-field">
                                    <label for="email" class="field-label">Email *</label>
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        name="email"
                                        required
                                        placeholder="Email"
                                        class="form-input"
                                    />
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="message" class="field-label">Message *</label>
                                <textarea
                                    id="message"
                                    v-model="form.body"
                                    required
                                    rows="6"
                                    name="message"
                                    placeholder="Message"
                                    class="form-textarea"
                                ></textarea>
                            </div>

                            <button type="submit" class="submit-button">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Contact Info & Map -->
                <div class="contact-info-section">
                    <!-- Contact Information -->
                    <div class="contact-info-card">
                        <div class="info-header">
                            <h3 class="info-title">Contact Information</h3>
                        </div>
                        <div class="info-content">
                            <div class="info-item">
                                <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div class="info-text">
                                    <h4 class="info-label">Address</h4>
                                    <p class="info-value">
                                        123 Snack Street<br />
                                        Flavor District, FD 12345<br />
                                        United States
                                    </p>
                                </div>
                            </div>

                            <div class="info-item">
                                <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <div class="info-text">
                                    <h4 class="info-label">Phone</h4>
                                    <p class="info-value">+1 (555) 123-SNACK</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <div class="info-text">
                                    <h4 class="info-label">Email</h4>
                                    <p class="info-value">hello@skebob.com</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="info-text">
                                    <h4 class="info-label">Business Hours</h4>
                                    <p class="info-value">
                                        Monday - Friday: 9:00 AM - 6:00 PM<br />
                                        Saturday: 10:00 AM - 4:00 PM<br />
                                        Sunday: Closed
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Placeholder -->
                    <div class="map-card">
                        <div class="map-container">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2175.752002814705!2d24.101903377117267!3d56.95305007355204!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46eecf7bac058ce9%3A0x96a8a0e931b27448!2z0KDQuNC20YHQutC40Lkg0LPQvtGB0YPQtNCw0YDRgdGC0LLQtdC90L3Ri9C5INGC0LXRhdC90LjQutGD0Lw!5e0!3m2!1sru!2slv!4v1725731560133!5m2!1sen!2slv"  width="600" height="300" frameborder="0" style="border:0; width: 100%; height:100%" allowfullscreen></iframe>

                            <!-- Interactive map note -->
                            <div class="map-note">
                                <p class="map-note-text">📍 Interactive map</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import {route} from "ziggy-js";
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    //subject: '',
    body: '',
});

const submit = () => {
    form.post(route('contact'), {

    });
};
</script>


<style scoped>
/* Contact Section Styles */
.contact-section {
    background-color: #f9fafb; /* gray-50 */
    padding-bottom: 290px;
}

.contact-container {
    max-width: 80rem;
    margin: 0 auto;
    padding: 0 1rem;
}

.contact-header {
    text-align: center;
    margin-bottom: 3rem;
}

.contact-title {
    margin-bottom: 1rem;
    line-height: 1.5;
}

.contact-subtitle {
    color: #4b5563; /* gray-600 */
    max-width: 32rem;
    margin: 0 auto;
    font-size: var(--text-base);
    font-weight: var(--font-weight-normal);
    line-height: 1.5;
}

/* Contact Grid */
.contact-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 3rem;
}

@media (min-width: 1024px) {
    .contact-grid {
        grid-template-columns: 1fr 1fr;
    }
}

/* Contact Form Card */
.contact-form-card {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

.form-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb; /* gray-200 */
}

.form-title {
    font-size: var(--text-lg);
    font-weight: var(--font-weight-medium);
    line-height: 1.5;
}

.form-content {
    padding: 1.5rem;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
}

@media (min-width: 768px) {
    .form-row {
        grid-template-columns: 1fr 1fr;
    }
}

.form-field {
    display: flex;
    flex-direction: column;
}

.field-label {
    display: block;
    margin-bottom: 0.5rem;
    font-size: var(--text-base);
    font-weight: var(--font-weight-medium);
    line-height: 1.5;
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db; /* gray-300 */
    border-radius: 0.375rem;
    font-size: var(--text-base);
    font-weight: var(--font-weight-normal);
    line-height: 1.5;
    transition: all 0.15s ease-in-out;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: transparent;
    box-shadow: 0 0 0 2px #d87220;
}

.form-textarea {
    resize: vertical;
    min-height: 6rem;
}

.submit-button {
    width: 100%;
    background-color: #d87220;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 0.375rem;
    transition: background-color 0.15s ease-in-out;
    border: none;
    cursor: pointer;
    font-size: var(--text-base);
    font-weight: var(--font-weight-medium);
    line-height: 1.5;
}

.submit-button:hover {
    background-color: #b45c1c; /* darker orange */
}

/* Contact Info Section */
.contact-info-section {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.contact-info-card {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

.info-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb; /* gray-200 */
}

.info-title {
    font-size: var(--text-lg);
    font-weight: var(--font-weight-medium);
    line-height: 1.5;
}

.info-content {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.info-icon {
    width: 1.25rem;
    height: 1.25rem;
    color: #d87220;
    margin-top: 0.25rem;
    flex-shrink: 0;
}

.info-text {
    flex: 1;
}

.info-label {
    font-weight: var(--font-weight-medium);
    margin-bottom: 0.25rem;
    font-size: var(--text-base);
    line-height: 1.5;
}

.info-value {
    color: #4b5563; /* gray-600 */
    font-size: var(--text-base);
    font-weight: var(--font-weight-normal);
    line-height: 1.5;
}

/* Map Card */
.map-card {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.map-container {
    height: 16rem;
    background: linear-gradient(to bottom right, #fed7aa, #fdba74); /* orange gradient */
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.map-background {
    position: absolute;
    inset: 0;
    opacity: 0.2;
}

.map-dot {
    position: absolute;
    background-color: white;
    border-radius: 50%;
}

.map-dot-1 {
    top: 1rem;
    left: 1rem;
    width: 4rem;
    height: 4rem;
}

.map-dot-2 {
    top: 3rem;
    right: 2rem;
    width: 2rem;
    height: 2rem;
}

.map-dot-3 {
    bottom: 2rem;
    left: 3rem;
    width: 3rem;
    height: 3rem;
}

.map-dot-4 {
    bottom: 1rem;
    right: 1rem;
    width: 1.5rem;
    height: 1.5rem;
}

.map-content {
    text-align: center;
    z-index: 10;
    position: relative;
}

.map-icon {
    width: 2rem;
    height: 2rem;
    color: #d87220;
    margin: 0 auto 0.5rem auto;
}

.map-title {
    color: #374151; /* gray-700 */
    font-weight: var(--font-weight-medium);
    margin-bottom: 0.25rem;
    font-size: var(--text-base);
    line-height: 1.5;
}

.map-address {
    color: #4b5563; /* gray-600 */
    font-size: 0.875rem;
    font-weight: var(--font-weight-normal);
    line-height: 1.5;
}

.map-note {
    position: absolute;
    bottom: 1rem;
    left: 1rem;
    background-color: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(4px);
    border-radius: 0.5rem;
    padding: 0.5rem;
}

.map-note-text {
    font-size: 0.75rem;
    color: #4b5563; /* gray-600 */
    margin: 0;
}

/* Responsive Design */
@media (max-width: 767px) {
    .contact-section {
        padding: 2rem 0;
    }

    .contact-container {
        padding: 0 0.5rem;
    }

    .contact-header {
        margin-bottom: 2rem;
    }

    .contact-grid {
        gap: 2rem;
    }

    .form-content,
    .info-content {
        padding: 1rem;
    }

    .form-header,
    .info-header {
        padding: 1rem;
    }
}

/* Focus and Accessibility */
.submit-button:focus {
    outline: 2px solid #d87220;
    outline-offset: 2px;
}

.form-input:focus,
.form-textarea:focus {
    box-shadow: 0 0 0 2px #d87220;
}

/* Animation Effects */
.contact-form-card,
.contact-info-card,
.map-card {
    animation: fadeInUp 0.6s ease-out;
}

.contact-info-card {
    animation-delay: 0.1s;
}

.map-card {
    animation-delay: 0.2s;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Form Validation Styles */
.form-input:invalid:not(:focus):not(:placeholder-shown) {
    border-color: #ef4444; /* red-500 */
}

.form-input:valid:not(:focus):not(:placeholder-shown) {
    border-color: #10b981; /* green-500 */
}

/* Print Styles */
@media print {
    .contact-section {
        background-color: transparent !important;
    }

    .contact-form-card,
    .contact-info-card,
    .map-card {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
    }

    .submit-button {
        display: none;
    }
}
</style>
