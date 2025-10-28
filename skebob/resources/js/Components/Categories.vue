<template>
    <section class="categories-section">
        <div class="categories-container">
            <div class="categories-header">
                <h2 class="categories-title">{{ $t('CategoriesTitle') }}</h2>
                <p class="categories-subtitle">
                    {{ $t('CategoriesSubtitle') }}
                </p>
<!--                <h2 class="categories-title">Shop by Category</h2>-->
<!--                <p class="categories-subtitle">-->
<!--                    Explore our wide variety of international snacks and treats from around the world-->
<!--                </p>-->
            </div>

            <div class="categories-grid">
                <div
                    v-for="(category, index) in categories"
                    :key="category.id"
                    :class="[
            'product-card',
            `card-${index + 1}`
          ]"
                    @click="handleCategoryClick(category)"
                >
                    <div class="card-image-container">
                        <img
                            :src="category.image"
                            :alt="$t(`category.${category.key}.name`)"
                            class="card-image"
                        />
                        <div class="image-overlay"></div>
                    </div>

                    <div class="card-content">
                        <p class="category-name">{{ $t(`category.${category.key}.name`) }}</p>
<!--                        <p class="category-name">{{ category.name }}</p>-->

                        <button
                            @click.stop="handleShopNowClick(category)"
                            class="shop-button"
                            :aria-label="$t('CategoriesSHOPNOW')"
                        >
                            <svg class="button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5L2 21m5.5-8v0"></path>
                            </svg>
                            {{ $t('CategoriesSHOPNOW') }}
                        </button>
                    </div>

                    <!-- Hover effect overlay -->
                    <div class="hover-overlay">
                        <div class="hover-content">
                            <h3 class="hover-title">{{ category.name }}</h3>
                            <p class="hover-description">{{ $t(`category.${category.key}.description`) }}</p>
<!--                            <p class="hover-description">{{ category.description }}</p>-->

                            <div class="hover-stats">
                                <span class="stat-item">{{ category.itemCount }}+ {{ $t('items') }}</span>
                                <span class="stat-divider">•</span>
                                <span class="stat-item">{{ category.brands }}+ {{ $t('brands') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Categories Banner -->
            <div class="featured-banner">
                <div class="banner-content">
                    <div class="banner-text">
                        <h3 class="banner-title">{{ $t('BannerTitle') }}</h3>
                        <p class="banner-subtitle">{{ $t('BannerSubtitle') }}</p>
                    </div>
<!--                    <div class="banner-text">-->
<!--                        <h3 class="banner-title">Can't decide? Try our Mystery Boxes!</h3>-->
<!--                        <p class="banner-subtitle">Let us surprise you with a curated selection from multiple categories</p>-->
<!--                    </div>-->
                    <button
                        @click="handleMysteryBoxClick"
                        class="banner-button"
                    >
                        <svg class="banner-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        {{ $t('ExploreMysteryBoxes') }}
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';
// import { useRouter } from 'vue-router';
//
// const router = useRouter();

const categories = ref([
    {
        id: 1,
        key: 'chips',
        // name: "CHIPS",
        // description: "Crispy and crunchy chips from around the world with unique flavors",
        image: "https://images.unsplash.com/photo-1633536705882-d331e8d1858c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxwb3RhdG8lMjBjaGlwcyUyMHNuYWNrcyUyMGNvbG9yZnVsfGVufDF8fHx8MTc1Nzc3MDcyNHww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
        route: "/chips",
        itemCount: 150,
        brands: 25
    },
    {
        id: 2,
        key: 'chocolates',
        // name: "CHOCOLATES",
        // description: "Premium chocolates and cocoa treats from artisan chocolatiers worldwide",
        image: "https://images.unsplash.com/photo-1702743692629-b11e94c63b0a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjaG9jb2xhdGUlMjBiYXJzJTIwY2FuZHklMjBzd2VldHxlbnwxfHx8fDE3NTc3NzA3Mjd8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
        route: "/chocolates",
        itemCount: 120,
        brands: 18
    },
    {
        id: 3,
        key: 'drinks',
        // name: "DRINKS",
        // description: "Refreshing beverages and unique drinks you won't find anywhere else",
        image: "https://images.unsplash.com/photo-1634825881542-9bd54ca437ea?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxlbmVyZ3klMjBkcmlua3MlMjBiZXZlcmFnZXMlMjBjb2xvcmZ1bHxlbnwxfHx8fDE3NTc3NzA3Mjl8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
        route: "/drinks",
        itemCount: 80,
        brands: 15
    },
    {
        id: 4,
        key: 'nuts',
        // name: "NUTS",
        // description: "Premium nuts and trail mixes packed with nutrition and flavor",
        image: "https://images.unsplash.com/photo-1671981200629-014c03829abb?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtaXhlZCUyMG51dHMlMjBzbmFja3MlMjBoZWFsdGh5fGVufDF8fHx8MTc1Nzc3MDczMnww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
        route: "/nuts",
        itemCount: 90,
        brands: 12
    },
    {
        id: 5,
        key: 'biscuits',
        // name: "BISCUITS",
        // description: "Delicious biscuits and cookies with traditional and modern flavors",
        image: "https://images.unsplash.com/photo-1657021717831-73211ff92daf?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiaXNjdWl0cyUyMGNvb2tpZXMlMjBzbmFja3N8ZW58MXx8fHwxNzU3NzcwNzM0fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
        route: "/biscuits",
        itemCount: 110,
        brands: 20
    },
    {
        id: 6,
        key: 'fruitsnacks',
        // name: "FRUIT SNACKS",
        // description: "Natural and artificial fruit snacks bursting with sweet flavors",
        image: "https://images.unsplash.com/photo-1599738675654-125cf46f3b69?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxmcnVpdCUyMHNuYWNrcyUyMGd1bW15JTIwY29sb3JmdWx8ZW58MXx8fHwxNzU3NzcwNzM3fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
        route: "/fruitsnacks",
        itemCount: 75,
        brands: 14
    },
    {
        id: 7,
        key: 'candy',
        // name: "CANDY",
        // description: "Sweet candies and confections from every corner of the globe",
        image: "https://images.unsplash.com/photo-1476401113995-b136bdfce591?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjb2xvcmZ1bCUyMGNhbmR5JTIwc3dlZXRzJTIwZ3VtbXl8ZW58MXx8fHwxNzU3NzcwNzM5fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
        route: "/candy",
        itemCount: 130,
        brands: 22
    },
    {
        id: 8,
        key: 'snackboxes',
        // name: "SNACK BOXES",
        // description: "Curated snack boxes featuring the best selections from multiple categories",
        image: "https://images.unsplash.com/photo-1736788268738-79afa3312430?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzbmFjayUyMGJveCUyMHN1YnNjcmlwdGlvbiUyMHZhcmlldHl8ZW58MXx8fHwxNzU3NzcwNzQzfDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
        route: "/snackboxes",
        itemCount: 45,
        brands: 8
    }
]);

// const handleCategoryClick = (category) => {
//     router.push(category.route);
// };
//
// const handleShopNowClick = (category) => {
//     router.push(category.route);
// };

const handleCategoryClick = (category) => {
    console.log('Category clicked:', category.name);
    // Navigate to category page
    window.location.href = category.route;
};


const handleShopNowClick = (category) => {
    console.log('Shop now clicked for:', category.name);
    // Navigate to category page
    window.location.href = category.route;
};

const handleMysteryBoxClick = () => {
    console.log('Mystery box clicked');
    // Scroll to mystery box section or navigate
    window.location.href = '/mystery-box';
};
</script>

<style scoped>
/* Categories Section Styles */
.categories-section {
    padding: 4rem 0;
    background-color: #f9fafb; /* gray-50 */
}

.categories-container {
    max-width: 80rem;
    margin: 0 auto;
    padding: 0 1rem;
}

.categories-header {
    text-align: center;
    margin-bottom: 3rem;
}

.categories-title {
    margin-bottom: 1rem;
    font-size: var(--text-xl);
    font-weight: var(--font-weight-medium);
    line-height: 1.5;
}

.categories-subtitle {
    color: #4b5563; /* gray-600 */
    max-width: 32rem;
    margin: 0 auto;
    font-size: var(--text-base);
    font-weight: var(--font-weight-normal);
    line-height: 1.5;
}

/* Categories Grid */
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
}

@media (max-width: 640px) {
    .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
}

/* Product Card Styles */
.product-card {
    background-color: white;
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    height: 320px;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.product-card:hover .hover-overlay {
    opacity: 1;
}

.product-card:hover .card-image {
    transform: scale(1.05);
}

/* Card Image Container */
.card-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
}

/* Card Content */
.card-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    text-align: center;
}

.category-name {
    font-size: 1.125rem;
    font-weight: var(--font-weight-medium);
    line-height: 1.5;
    color: #111827; /* gray-900 */
    margin-bottom: 1rem;
    letter-spacing: 0.05em;
}

.shop-button {
    background-color: #d87220;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    font-size: 0.875rem;
    font-weight: var(--font-weight-medium);
    letter-spacing: 0.05em;
    transition: all 0.15s ease-in-out;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-width: 120px;
    justify-content: center;
}

.shop-button:hover {
    background-color: #b45c1c;
    transform: translateY(-1px);
}

.button-icon {
    width: 1rem;
    height: 1rem;
}

/* Hover Overlay */
.hover-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(216, 114, 32, 0.95), rgba(180, 92, 28, 0.95));
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    padding: 1.5rem;
}

.hover-content {
    text-align: center;
    color: white;
}

.hover-title {
    font-size: 1.5rem;
    font-weight: var(--font-weight-medium);
    line-height: 1.5;
    margin-bottom: 1rem;
}

.hover-description {
    font-size: var(--text-base);
    font-weight: var(--font-weight-normal);
    line-height: 1.5;
    margin-bottom: 1.5rem;
    opacity: 0.9;
}

.hover-stats {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: var(--font-weight-medium);
}

.stat-item {
    opacity: 0.9;
}

.stat-divider {
    opacity: 0.6;
}

/* Featured Banner */
.featured-banner {
    background: linear-gradient(135deg, #d87220, #b45c1c);
    border-radius: 0.75rem;
    padding: 2rem;
    margin-top: 2rem;
}

.banner-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.banner-text {
    flex: 1;
    min-width: 250px;
}

.banner-title {
    color: white;
    font-size: var(--text-lg);
    font-weight: var(--font-weight-medium);
    line-height: 1.5;
    margin-bottom: 0.5rem;
}

.banner-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: var(--text-base);
    font-weight: var(--font-weight-normal);
    line-height: 1.5;
}

.banner-button {
    background-color: white;
    color: #d87220;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    font-size: var(--text-base);
    font-weight: var(--font-weight-medium);
    line-height: 1.5;
    transition: all 0.15s ease-in-out;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
}

.banner-button:hover {
    background-color: #f9fafb;
    transform: translateY(-1px);
}

.banner-icon {
    width: 1.25rem;
    height: 1.25rem;
}

/* Animation Effects */
.product-card {
    animation: fadeInUp 0.6s ease-out;
}

.card-1 { animation-delay: 0.1s; }
.card-2 { animation-delay: 0.2s; }
.card-3 { animation-delay: 0.3s; }
.card-4 { animation-delay: 0.4s; }
.card-5 { animation-delay: 0.5s; }
.card-6 { animation-delay: 0.6s; }
.card-7 { animation-delay: 0.7s; }
.card-8 { animation-delay: 0.8s; }

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

/* Responsive Design */
@media (max-width: 767px) {
    .categories-section {
        padding: 2rem 0;
    }

    .categories-container {
        padding: 0 0.5rem;
    }

    .categories-header {
        margin-bottom: 2rem;
    }

    .categories-grid {
        margin-bottom: 2rem;
    }

    .product-card {
        height: 280px;
    }

    .card-content {
        padding: 1rem;
    }

    .featured-banner {
        padding: 1.5rem;
    }

    .banner-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .banner-text {
        min-width: auto;
    }
}

@media (max-width: 480px) {
    .categories-grid {
        grid-template-columns: 1fr;
    }

    .hover-overlay {
        display: none; /* Hide hover effects on very small screens */
    }
}

/* Focus and Accessibility */
.product-card:focus {
    outline: 2px solid #d87220;
    outline-offset: 2px;
}

.shop-button:focus,
.banner-button:focus {
    outline: 2px solid #d87220;
    outline-offset: 2px;
}

/* Print Styles */
@media print {
    .categories-section {
        background-color: transparent !important;
    }

    .product-card {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
    }

    .featured-banner {
        background: transparent !important;
        border: 1px solid #ccc !important;
    }

    .banner-title,
    .banner-subtitle {
        color: black !important;
    }
}
</style>
