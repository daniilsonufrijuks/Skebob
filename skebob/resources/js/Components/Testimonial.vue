<template>
    <section class="testimonials-section">
        <div class="testimonials-container">
            <div class="testimonials-header">
                <h2 class="testimonials-title">What Our Customers Say</h2>
                <p class="testimonials-subtitle">
                    Join thousands of satisfied snack lovers who have discovered their new favorites with Skebob.
                </p>
            </div>

            <div class="main-testimonial">
                <div class="main-testimonial-content">
                    <div class="testimonial-inner">
                        <svg class="quote-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"></path>
                        </svg>

                        <div class="welcome-message">
                            <p class="welcome-text">
                                Dear valued customer,<br/><br/>
                                We are thrilled to welcome you to Skebob – your ultimate destination for unique and flavorful snacks!
                                Whether you're craving something sweet, savory, or adventurous, our carefully curated collection is
                                designed to satisfy every taste bud. From rare international treats to exclusive Skibob specialties,
                                we make snacking an experience you'll love.
                            </p>
                        </div>

                        <div class="star-rating">
                            <svg v-for="n in 5" :key="n" class="star" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>

                        <div class="testimonial-author">
                            <p class="author-name">Skebob Snack Group</p>
                            <p class="author-role">Official Welcome Message</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional customer testimonials -->
            <div class="additional-testimonials">
                <div
                    v-for="testimonial in additionalTestimonials"
                    :key="testimonial.id"
                    class="customer-testimonial"
                >
                    <div class="customer-testimonial-content">
                        <div class="customer-star-rating">
                            <svg v-for="n in testimonial.rating" :key="n" class="customer-star" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <p class="customer-text">{{ testimonial.text }}</p>
                        <div class="customer-author">
                            <p class="customer-author-name">{{ testimonial.author }}</p>
                            <p class="customer-author-role">{{ testimonial.role }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';

const additionalTestimonials = ref([
    {
        id: 1,
        text: "Absolutely amazing selection! I discovered snacks I never knew existed. The mystery box was such a fun surprise!",
        author: "Sarah M.",
        role: "Verified Customer",
        rating: 5
    },
    {
        id: 2,
        text: "The quality is exceptional and the international variety is incredible. Skebob has become my go-to for unique treats!",
        author: "Mike T.",
        role: "Verified Customer",
        rating: 5
    }
]);
</script>

<style scoped>
/* Testimonials Section Styles */
.testimonials-section {
    padding: 4rem 0;
    background-color: #d87220;
    color: white;
}

.testimonials-container {
    max-width: 64rem;
    margin: 0 auto;
    padding: 0 1rem;
}

.testimonials-header {
    text-align: center;
    margin-bottom: 3rem;
}

.testimonials-title {
    margin-bottom: 1rem;
    color: white;
    font-size: var(--text-xl);
    font-weight: var(--font-weight-medium);
    line-height: 1.5;
}

.testimonials-subtitle {
    color: rgba(255, 237, 213, 1); /* orange-100 */
    max-width: 32rem;
    margin: 0 auto;
    font-size: var(--text-base);
    font-weight: var(--font-weight-normal);
    line-height: 1.5;
}

/* Main Testimonial Styles */
.main-testimonial {
    background-color: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.5rem;
    margin-bottom: 3rem;
}

.main-testimonial-content {
    padding: 2rem;
}

.testimonial-inner {
    text-align: center;
}

.quote-icon {
    width: 3rem;
    height: 3rem;
    color: rgba(254, 215, 170, 1); /* orange-200 */
    margin: 0 auto 1.5rem auto;
    display: block;
}

.welcome-message {
    margin-bottom: 1.5rem;
}

.welcome-text {
    color: white;
    font-size: 1.125rem;
    line-height: 1.625;
    font-weight: var(--font-weight-normal);
}

.star-rating {
    display: flex;
    justify-content: center;
    margin-bottom: 1rem;
    gap: 0.25rem;
}

.star {
    width: 1.25rem;
    height: 1.25rem;
    color: #facc15; /* yellow-400 */
    fill: currentColor;
}

.testimonial-author {
    color: rgba(255, 237, 213, 1); /* orange-100 */
}

.author-name {
    font-weight: var(--font-weight-medium);
    margin-bottom: 0.25rem;
    font-size: var(--text-base);
    line-height: 1.5;
}

.author-role {
    font-size: 0.875rem;
    font-weight: var(--font-weight-normal);
    line-height: 1.5;
}

/* Additional Testimonials Styles */
.additional-testimonials {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .additional-testimonials {
        grid-template-columns: repeat(2, 1fr);
    }
}

.customer-testimonial {
    background-color: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.5rem;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.customer-testimonial:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.customer-testimonial-content {
    padding: 1.5rem;
}

.customer-star-rating {
    display: flex;
    justify-content: center;
    margin-bottom: 1rem;
    gap: 0.25rem;
}

.customer-star {
    width: 1rem;
    height: 1rem;
    color: #facc15; /* yellow-400 */
    fill: currentColor;
}

.customer-text {
    color: white;
    margin-bottom: 1rem;
    font-size: var(--text-base);
    font-weight: var(--font-weight-normal);
    line-height: 1.5;
}

.customer-author {
    color: rgba(255, 237, 213, 1); /* orange-100 */
}

.customer-author-name {
    font-weight: var(--font-weight-medium);
    margin-bottom: 0.25rem;
    font-size: var(--text-base);
    line-height: 1.5;
}

.customer-author-role {
    font-size: 0.875rem;
    font-weight: var(--font-weight-normal);
    line-height: 1.5;
}

/* Responsive Design */
@media (max-width: 767px) {
    .testimonials-section {
        padding: 2rem 0;
    }

    .testimonials-container {
        padding: 0 0.5rem;
    }

    .testimonials-header {
        margin-bottom: 2rem;
    }

    .main-testimonial-content {
        padding: 1.5rem;
    }

    .welcome-text {
        font-size: 1rem;
    }

    .quote-icon {
        width: 2.5rem;
        height: 2.5rem;
        margin-bottom: 1rem;
    }
}

/* Animation Effects */
.main-testimonial {
    animation: fadeInUp 0.6s ease-out;
}

.customer-testimonial {
    animation: fadeInUp 0.6s ease-out;
}

.customer-testimonial:nth-child(1) {
    animation-delay: 0.1s;
}

.customer-testimonial:nth-child(2) {
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

/* Focus and Accessibility */
.customer-testimonial:focus-within {
    outline: 2px solid rgba(255, 255, 255, 0.5);
    outline-offset: 2px;
}

/* Print Styles */
@media print {
    .testimonials-section {
        background-color: transparent !important;
        color: black !important;
    }

    .main-testimonial,
    .customer-testimonial {
        background-color: transparent !important;
        border: 1px solid #ccc !important;
    }

    .testimonials-title,
    .welcome-text,
    .customer-text {
        color: black !important;
    }

    .testimonials-subtitle,
    .testimonial-author,
    .customer-author {
        color: #666 !important;
    }
}
</style>
