<template>
    <section class="about-section">
        <div class="about-container">
            <!-- Main About Content -->
            <div class="about-content">
                <div class="welcome-section">
                    <h2 class="about-title">{{ $t('AboutWelcome') }}</h2>
<!--                    <h2 class="about-title">Welcome to Skebob Market</h2>-->
                    <div class="title-decoration"></div>

                    <p class="welcome-message">
                        {{ $t('AboutWelcomeMessage') }}
                    </p>

                    <p class="mission-message">
                        {{ $t('AboutMissionMessage') }}
                    </p>
<!--                    <p class="welcome-message">-->
<!--                        Welcome to Skebob Market – your one-stop destination for unique and delicious snacks!-->
<!--                        Thank you for choosing us. We're excited to be part of your snacking journey and bring-->
<!--                        you flavors that surprise, delight, and inspire every bite.-->
<!--                    </p>-->

<!--                    <p class="mission-message">-->
<!--                        Explore our carefully curated selection and discover why Skebob Market is more than-->
<!--                        just snacks – it's an experience!-->
<!--                    </p>-->

                    <div class="cta-section">
                        <button class="explore-btn">
                            <span>{{ $t('StartExploring') }}</span>
<!--                            <span>Start Exploring</span>-->
                            <svg class="arrow-icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="stats-section">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">{{ $t('AboutUniqueSnacks') }}</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">{{ $t('countries') }}</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">{{ $t('AboutHappyCustomers') }}</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">{{ $t('support') }}</div>
                    </div>
                </div>

                <!-- Our Values -->
                <div class="values-section">
                    <h3 class="values-title">{{ $t('WhatMakesUsSpecial') }}</h3>
<!--                    <h3 class="values-title">What Makes Us Special</h3>-->

                    <div class="values-grid">
                        <div class="value-card">
                            <div class="value-icon">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                            <h4 class="value-title">{{ $t('AboutValueTitle1') }}</h4>
<!--                            <h4 class="value-title">Premium Quality</h4>-->

                            <p class="value-description">
                                {{ $t('AboutValueDescription1') }}
                            </p>
<!--                            <p class="value-description">-->
<!--                                Every snack is carefully selected for exceptional taste and quality standards.-->
<!--                            </p>-->
                        </div>

                        <div class="value-card">
                            <div class="value-icon">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h4 class="value-title">{{ $t('AboutValueTitle2') }}</h4>
<!--                            <h4 class="value-title">Global Sourcing</h4>-->

                            <p class="value-description">
                                {{ $t('AboutValueDescription2') }}
                            </p>
<!--                            <p class="value-description">-->
<!--                                We travel the world to bring you authentic flavors from every corner of the globe.-->
<!--                            </p>-->
                        </div>

                        <div class="value-card">
                            <div class="value-icon">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h4 class="value-title">{{ $t('AboutValueTitle3') }}</h4>
<!--                            <h4 class="value-title">Customer Love</h4>-->

                            <p class="value-description">
                                {{ $t('AboutValueDescription3') }}
                            </p>
<!--                            <p class="value-description">-->
<!--                                Your satisfaction is our priority. We're here to make every bite memorable.-->
<!--                            </p>-->
                        </div>

                        <div class="value-card">
                            <div class="value-icon">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h4 class="value-title">{{ $t('AboutValueTitle4') }}</h4>
<!--                            <h4 class="value-title">Trusted Brand</h4>-->

                            <p class="value-description">
                                {{ $t('AboutValueDescription4') }}
                            </p>
<!--                            <p class="value-description">-->
<!--                                Join thousands who trust Skebob for their snacking adventures and discoveries.-->
<!--                            </p>-->
                        </div>
                    </div>
                </div>

                <!-- Company Info -->
                <div class="company-section">
                    <div class="company-card">
                        <div class="company-content">
                            <h3 class="company-title">{{ $t('CompanyTitle') }}</h3>
<!--                            <h3 class="company-title">Powered by Innovation</h3>-->
                            <p class="company-description">
                                {{ $t('CompanyDescription') }}
                            </p>
<!--                            <p class="company-description">-->
<!--                                Skebob Market is proudly developed and maintained-->
<!--                            </p>-->
                            <div class="company-brand">
                                <div class="brand-logo">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="brand-text">
                                    <div class="brand-name">{{ $t('BrandName') }}</div>
                                    <div class="brand-tagline">{{ $t('BrandTagline') }}</div>
<!--                                    <div class="brand-name">Braincell DEV GROUP</div>-->
<!--                                    <div class="brand-tagline">Crafting Digital Experiences</div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
// Component logic can be added here if needed
</script>

<style scoped>
.about-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

.about-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

@media (min-width: 640px) {
    .about-container {
        padding: 0 1.5rem;
    }
}

@media (min-width: 1024px) {
    .about-container {
        padding: 0 2rem;
    }
}

.about-content {
    display: flex;
    flex-direction: column;
    gap: 4rem;
}

/* Welcome Section */
.welcome-section {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.about-title {
    font-size: 3rem;
    font-weight: bold;
    color: #d87220;
    margin-bottom: 1rem;
    position: relative;
}

@media (max-width: 768px) {
    .about-title {
        font-size: 2.5rem;
    }
}

.title-decoration {
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #d87220, #f59e0b);
    margin: 0 auto 2rem;
    border-radius: 2px;
}

.welcome-message {
    font-size: 1.25rem;
    color: #374151;
    line-height: 1.7;
    margin-bottom: 1.5rem;
}

.mission-message {
    font-size: 1.125rem;
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.cta-section {
    margin-top: 2rem;
}

.explore-btn {
    background: linear-gradient(135deg, #d87220, #f59e0b);
    color: white;
    padding: 1rem 2rem;
    border-radius: 0.75rem;
    border: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(216, 114, 32, 0.3);
}

.explore-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(216, 114, 32, 0.4);
}

.arrow-icon {
    width: 1rem;
    height: 1rem;
    transition: transform 0.3s ease;
}

.explore-btn:hover .arrow-icon {
    transform: translateX(4px);
}

/* Stats Section */
.stats-section {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
    max-width: 600px;
    margin: 0 auto;
}

@media (min-width: 768px) {
    .stats-section {
        grid-template-columns: repeat(4, 1fr);
    }
}

.stat-item {
    text-align: center;
    padding: 1.5rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-4px);
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #d87220;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
}

/* Values Section */
.values-section {
    text-align: center;
}

.values-title {
    font-size: 2.5rem;
    font-weight: bold;
    color: #1f2937;
    margin-bottom: 3rem;
}

.values-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    max-width: 1000px;
    margin: 0 auto;
}

@media (min-width: 768px) {
    .values-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .values-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

.value-card {
    background: white;
    padding: 2rem 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    text-align: center;
}

.value-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.value-icon {
    width: 3rem;
    height: 3rem;
    margin: 0 auto 1rem;
    color: #d87220;
}

.value-icon svg {
    width: 100%;
    height: 100%;
}

.value-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #1f2937;
    margin-bottom: 0.75rem;
}

.value-description {
    font-size: 0.875rem;
    color: #6b7280;
    line-height: 1.5;
}

/* Company Section */
.company-section {
    max-width: 600px;
    margin: 0 auto;
}

.company-card {
    background: white;
    padding: 3rem 2rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    border: 2px solid #f3f4f6;
}

.company-content {
    max-width: 400px;
    margin: 0 auto;
}

.company-title {
    font-size: 1.75rem;
    font-weight: bold;
    color: #1f2937;
    margin-bottom: 1rem;
}

.company-description {
    font-size: 1rem;
    color: #6b7280;
    margin-bottom: 2rem;
}

.company-brand {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    border-radius: 1rem;
    border: 1px solid #e5e7eb;
}

.brand-logo {
    width: 3rem;
    height: 3rem;
    background: linear-gradient(135deg, #d87220, #f59e0b);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.brand-logo svg {
    width: 1.5rem;
    height: 1.5rem;
}

.brand-text {
    text-align: left;
}

.brand-name {
    font-size: 1.25rem;
    font-weight: bold;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.brand-tagline {
    font-size: 0.875rem;
    color: #6b7280;
}

@media (max-width: 480px) {
    .company-brand {
        flex-direction: column;
        text-align: center;
    }

    .brand-text {
        text-align: center;
    }
}
</style>
