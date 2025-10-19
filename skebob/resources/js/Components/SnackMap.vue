<template>
    <div class="snack-map-container">
        <div class="container-wrapper">
            <!-- Header -->
            <div class="header-section">
                <div class="header-title">
                    <Globe class="globe-icon" />
                    <h2 class="main-title">{{ $t('snackMap') }}</h2>
<!--                    <h2 class="main-title">Interactive Snack Map</h2>-->
                </div>
                <p class="header-description">
                    {{ $t('mapDescription') }}
                </p>
<!--                <p class="header-description">-->
<!--                    Explore the world of international snacks! Click on any country to discover unique treats and flavors from around the globe.-->
<!--                </p>-->
            </div>

            <div class="main-grid">
                <!-- Interactive Map -->
                <div class="map-section">
                    <div class="map-container">
                        <!-- Decorative Elements -->
                        <div class="decorative-elements">
                            <div class="deco-1"></div>
                            <div class="deco-2"></div>
                            <div class="deco-3"></div>
                        </div>

                        <!-- Title -->
                        <div class="map-title">
                            <h3 class="map-heading">{{ $t('MapHeading') }}</h3>
                            <p class="map-subtitle">{{ $t('MapSubtitle') }}</p>
<!--                            <h3 class="map-heading">World Snack Origins</h3>-->
<!--                            <p class="map-subtitle">Click on any country marker to explore their signature snacks</p>-->
                        </div>

                        <!-- Country Markers -->
                        <div class="markers-container">
                            <div
                                v-for="country in countries"
                                :key="country.id"
                                class="country-marker"
                                :class="{
                  'selected': selectedCountry?.id === country.id,
                  'hovered': hoveredCountry === country.id
                }"
                                :style="{ left: `${country.position.x}%`, top: `${country.position.y}%` }"
                                @mouseenter="hoveredCountry = country.id"
                                @mouseleave="hoveredCountry = null"
                                @click="selectedCountry = country"
                            >
                                <!-- Country Marker -->
                                <div class="marker-circle">
                                    <span class="flag">{{ country.flag }}</span>
                                    <div class="pulse-animation"></div>
                                </div>

                                <!-- Country Name Tooltip -->
                                <div v-if="hoveredCountry === country.id" class="country-tooltip">
                                    {{ country.name }}
                                    <div class="tooltip-arrow"></div>
                                </div>

                                <!-- Snack Count Badge -->
                                <div class="snack-count-badge">
                                    {{ country.snacks.length }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Country Details Panel -->
                <div class="details-section">
                    <div class="details-panel">
                        <div v-if="selectedCountry" class="country-details" :class="getBgClass(selectedCountry.bgColor)">
                            <!-- Country Header -->
                            <div class="country-header">
                                <span class="country-flag">{{ selectedCountry.flag }}</span>
                                <div>
                                    <h3 class="country-name">{{ selectedCountry.name }}</h3>
                                    <p class="continent-name">{{ selectedCountry.continent }}</p>
                                </div>
                            </div>

                            <!-- Snacks List -->
                            <div class="snacks-section">
                                <h4 class="snacks-title">
                                    <MapPin class="map-pin-icon" />
                                    Signature Snacks
                                </h4>

                                <div
                                    v-for="(snack, index) in selectedCountry.snacks"
                                    :key="index"
                                    class="snack-card"
                                    :style="{ animationDelay: `${index * 0.1}s` }"
                                >
                                    <div class="snack-content">
                                        <img
                                            :src="snack.image"
                                            :alt="snack.name"
                                            class="snack-image"
                                        />
                                        <div class="snack-info">
                                            <h5 class="snack-name">{{ snack.name }}</h5>
                                            <p class="snack-description">{{ snack.description }}</p>

                                            <div class="snack-tags">
                                                <span class="flavor-tag">{{ snack.flavor }}</span>

                                                <div class="popularity-rating">
                                                    <Star class="star-icon" />
                                                    <span>{{ snack.popularity }}%</span>
                                                </div>

                                                <div v-if="snack.cookingTime" class="cooking-time">
                                                    <Clock class="clock-icon" />
                                                    <span>{{ snack.cookingTime }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

<!--                            &lt;!&ndash; Action Button &ndash;&gt;-->
<!--                            <button class="shop-button">-->
<!--                                Shop {{ selectedCountry.name }} Snacks-->
<!--                            </button>-->
                        </div>

                        <div v-else class="placeholder-content">
                            <Globe class="placeholder-icon" />
<!--                            <h3 class="placeholder-title">Explore The World!</h3>-->
                            <h3 class="placeholder-title">{{ $t('ExploreTheWorld') }}</h3>
                            <p class="placeholder-text">
                                {{ $t('ClickOnAnyCountryMarker') }}
                            </p>
<!--                            <p class="placeholder-text">-->
<!--                                Click on any country marker on the map to discover their unique snacks and treats!-->
<!--                            </p>-->

                            <div class="stats-grid">
                                <div class="stat-item">
                                    <div class="stat-number">{{ countries.length }}</div>
                                    <div class="stat-label">{{ $t('countries') }}</div>
<!--                                    <div class="stat-label">Countries</div>-->
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">{{ totalSnacks }}</div>
                                    <div class="stat-label">{{ $t('snacks') }}</div>
<!--                                    <div class="stat-label">Snacks</div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="statistics-section">
                <div class="stat-card">
                    <div class="stat-value">{{ countries.length }}</div>
                    <div class="stat-description">{{ $t('CountriesExplored') }}</div>
<!--                    <div class="stat-description">Countries Explored</div>-->
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ totalSnacks }}</div>
                    <div class="stat-description">{{ $t('UniqueSnacks') }}</div>
<!--                    <div class="stat-description">Unique Snacks</div>-->
                </div>
                <div class="stat-card">
                    <div class="stat-value">5</div>
                    <div class="stat-description">{{ $t('Continents') }}</div>
<!--                    <div class="stat-description">Continents</div>-->
                </div>
                <div class="stat-card">
                    <div class="stat-value">∞</div>
                    <div class="stat-description">{{ $t('FlavorAdventures') }}</div>
<!--                    <div class="stat-description">Flavor Adventures</div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Globe, MapPin, Star, Clock } from 'lucide-vue-next'

const selectedCountry = ref(null)
const hoveredCountry = ref(null)

const countries = ref([
    {
        id: 'japan',
        name: 'Japan',
        continent: 'Asia',
        position: { x: 85, y: 35 },
        flag: '🇯🇵',
        bgColor: 'red',
        snacks: [
            {
                name: 'Pocky Sticks',
                description: 'Crispy biscuit sticks covered in chocolate',
                flavor: 'Sweet & Crunchy',
                popularity: 95,
                image: 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=300&h=200&fit=crop'
            },
            {
                name: 'Wasabi Peas',
                description: 'Dried peas with a spicy wasabi coating',
                flavor: 'Spicy & Bold',
                popularity: 88,
                image: 'https://images.unsplash.com/photo-1585297090374-f5c5e1b29d3c?w=300&h=200&fit=crop'
            }
        ]
    },
    {
        id: 'mexico',
        name: 'Mexico',
        continent: 'North America',
        position: { x: 20, y: 45 },
        flag: '🇲🇽',
        bgColor: 'green',
        snacks: [
            {
                name: 'Takis',
                description: 'Rolled tortilla chips with chili and lime',
                flavor: 'Spicy & Tangy',
                popularity: 92,
                image: 'https://images.unsplash.com/photo-1621447504864-d8686e12698c?w=300&h=200&fit=crop'
            },
            {
                name: 'Churros',
                description: 'Fried dough pastry with cinnamon sugar',
                flavor: 'Sweet & Crispy',
                popularity: 96,
                cookingTime: '15 mins',
                image: 'https://images.unsplash.com/photo-1549007994-cb92caebd54b?w=300&h=200&fit=crop'
            }
        ]
    },
    {
        id: 'india',
        name: 'India',
        continent: 'Asia',
        position: { x: 72, y: 45 },
        flag: '🇮🇳',
        bgColor: 'orange',
        snacks: [
            {
                name: 'Samosas',
                description: 'Crispy pastries filled with spiced potatoes',
                flavor: 'Savory & Spiced',
                popularity: 94,
                cookingTime: '25 mins',
                image: 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=300&h=200&fit=crop'
            },
            {
                name: 'Masala Chips',
                description: 'Potato chips with traditional Indian spices',
                flavor: 'Spicy & Aromatic',
                popularity: 89,
                image: 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=300&h=200&fit=crop'
            }
        ]
    },
    {
        id: 'italy',
        name: 'Italy',
        continent: 'Europe',
        position: { x: 50, y: 32 },
        flag: '🇮🇹',
        bgColor: 'red',
        snacks: [
            {
                name: 'Taralli',
                description: 'Ring-shaped crackers with olive oil and herbs',
                flavor: 'Savory & Herbal',
                popularity: 87,
                image: 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=300&h=200&fit=crop'
            },
            {
                name: 'Biscotti',
                description: 'Twice-baked almond cookies',
                flavor: 'Sweet & Nutty',
                popularity: 91,
                cookingTime: '45 mins',
                image: 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=300&h=200&fit=crop'
            }
        ]
    },
    {
        id: 'brazil',
        name: 'Brazil',
        continent: 'South America',
        position: { x: 35, y: 70 },
        flag: '🇧🇷',
        bgColor: 'yellow',
        snacks: [
            {
                name: 'Pão de Açúcar',
                description: 'Sweet coconut cookies',
                flavor: 'Sweet & Tropical',
                popularity: 90,
                image: 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=300&h=200&fit=crop'
            },
            {
                name: 'Guaraná Candy',
                description: 'Energizing fruit-flavored sweets',
                flavor: 'Fruity & Energizing',
                popularity: 85,
                image: 'https://images.unsplash.com/photo-1582058091505-f87a2e55a40f?w=300&h=200&fit=crop'
            }
        ]
    },
    {
        id: 'france',
        name: 'France',
        continent: 'Europe',
        position: { x: 47, y: 28 },
        flag: '🇫🇷',
        bgColor: 'blue',
        snacks: [
            {
                name: 'Macarons',
                description: 'Delicate almond meringue sandwiches',
                flavor: 'Sweet & Elegant',
                popularity: 93,
                cookingTime: '30 mins',
                image: 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=300&h=200&fit=crop'
            },
            {
                name: 'Madeleines',
                description: 'Shell-shaped sponge cakes',
                flavor: 'Sweet & Buttery',
                popularity: 88,
                image: 'https://images.unsplash.com/photo-1571115764595-644a1f56a55c?w=300&h=200&fit=crop'
            }
        ]
    },
    {
        id: 'korea',
        name: 'South Korea',
        continent: 'Asia',
        position: { x: 82, y: 38 },
        flag: '🇰🇷',
        bgColor: 'red',
        snacks: [
            {
                name: 'Honey Butter Chips',
                description: 'Sweet and salty potato chips',
                flavor: 'Sweet & Salty',
                popularity: 89,
                image: 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=300&h=200&fit=crop'
            },
            {
                name: 'Hotteok',
                description: 'Sweet pancakes filled with brown sugar',
                flavor: 'Sweet & Warm',
                popularity: 92,
                cookingTime: '20 mins',
                image: 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=300&h=200&fit=crop'
            }
        ]
    },
    {
        id: 'morocco',
        name: 'Morocco',
        continent: 'Africa',
        position: { x: 45, y: 40 },
        flag: '🇲🇦',
        bgColor: 'red',
        snacks: [
            {
                name: 'Chebakia',
                description: 'Flower-shaped sesame cookies in honey',
                flavor: 'Sweet & Floral',
                popularity: 86,
                cookingTime: '40 mins',
                image: 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=300&h=200&fit=crop'
            },
            {
                name: 'Makroudh',
                description: 'Semolina pastries filled with dates',
                flavor: 'Sweet & Rich',
                popularity: 84,
                image: 'https://images.unsplash.com/photo-1571115764595-644a1f56a55c?w=300&h=200&fit=crop'
            }
        ]
    }
])

const totalSnacks = computed(() => {
    return countries.value.reduce((total, country) => total + country.snacks.length, 0)
})

const getBgClass = (bgColor) => {
    switch (bgColor) {
        case 'red': return 'bg-red'
        case 'green': return 'bg-green'
        case 'orange': return 'bg-orange'
        case 'yellow': return 'bg-yellow'
        case 'blue': return 'bg-blue'
        default: return 'bg-gray'
    }
}
</script>

<style scoped>
/* Container Styles */
.snack-map-container {
    padding: 4rem 0;
    background: linear-gradient(to bottom, #fed7aa, #ffffff);
}

.container-wrapper {
    max-width: 80rem;
    margin: 0 auto;
    padding: 0 1rem;
}

@media (min-width: 640px) {
    .container-wrapper {
        padding: 0 1.5rem;
    }
}

@media (min-width: 1024px) {
    .container-wrapper {
        padding: 0 2rem;
    }
}

/* Header Styles */
.header-section {
    text-align: center;
    margin-bottom: 3rem;
}

.header-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    animation: fadeInUp 0.6s ease-out;
}

.globe-icon {
    height: 2rem;
    width: 2rem;
    color: #d87220;
}

.main-title {
    font-size: 2.25rem;
    font-weight: bold;
    color: #111827;
}

.header-description {
    font-size: 1.25rem;
    color: #4b5563;
    max-width: 48rem;
    margin: 0 auto;
    animation: fadeInUp 0.6s ease-out 0.1s both;
}

/* Grid Layout */
.main-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

@media (min-width: 1024px) {
    .main-grid {
        grid-template-columns: 2fr 1fr;
    }
}

.map-section {
    grid-column: span 1;
}

@media (min-width: 1024px) {
    .map-section {
        grid-column: span 1;
    }
}

/* Map Container */
.map-container {
    position: relative;
    background: linear-gradient(to bottom right, #dbeafe, #dcfce7);
    border-radius: 1rem;
    padding: 2rem;
    height: 37.5rem;
    overflow: hidden;
    border: 2px solid #e5e7eb;
    animation: scaleIn 0.8s ease-out;
}

.decorative-elements {
    position: absolute;
    inset: 0;
    opacity: 0.1;
}

.deco-1 {
    position: absolute;
    top: 2.5rem;
    left: 2.5rem;
    width: 8rem;
    height: 8rem;
    background-color: #d87220;
    border-radius: 50%;
    filter: blur(3rem);
}

.deco-2 {
    position: absolute;
    bottom: 2.5rem;
    right: 2.5rem;
    width: 10rem;
    height: 10rem;
    background-color: #60a5fa;
    border-radius: 50%;
    filter: blur(3rem);
}

.deco-3 {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 6rem;
    height: 6rem;
    background-color: #4ade80;
    border-radius: 50%;
    filter: blur(2rem);
}

.map-title {
    position: relative;
    z-index: 10;
    text-align: center;
    margin-bottom: 2rem;
}

.map-heading {
    font-size: 1.5rem;
    font-weight: bold;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.map-subtitle {
    color: #4b5563;
}

/* Country Markers */
.markers-container {
    position: relative;
    height: 100%;
}

.country-marker {
    position: absolute;
    cursor: pointer;
    transform: translate(-50%, -50%);
    transition: transform 0.2s ease;
}

.country-marker:hover {
    transform: translate(-50%, -50%) scale(1.2);
}

.country-marker:active {
    transform: translate(-50%, -50%) scale(0.95);
}

.marker-circle {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 4rem;
    height: 4rem;
    border-radius: 50%;
    background-color: white;
    border: 4px solid #d87220;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
}

.country-marker.selected .marker-circle {
    background-color: #d87220;
}

.country-marker.hovered .marker-circle {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.flag {
    font-size: 1.5rem;
    position: relative;
    z-index: 10;
}

.pulse-animation {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background-color: #d87220;
    opacity: 0.25;
    animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
}

.country-tooltip {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    margin-top: 0.5rem;
    padding: 0.25rem 0.75rem;
    background-color: #111827;
    color: white;
    font-size: 0.875rem;
    border-radius: 0.5rem;
    white-space: nowrap;
    z-index: 20;
    animation: tooltipFadeIn 0.2s ease-out;
}

.tooltip-arrow {
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-bottom: 4px solid #111827;
}

.snack-count-badge {
    position: absolute;
    top: -0.5rem;
    right: -0.5rem;
    background-color: #d87220;
    color: white;
    font-size: 0.75rem;
    border-radius: 50%;
    width: 1.5rem;
    height: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

/* Details Panel */
.details-section {
    grid-column: span 1;
}

.details-panel {
    position: sticky;
    top: 2rem;
    animation: slideInRight 0.6s ease-out;
}

.country-details {
    border-radius: 1rem;
    padding: 1.5rem;
    border: 2px solid #e5e7eb;
}

.bg-red {
    background-color: #fef2f2;
}

.bg-green {
    background-color: #f0fdf4;
}

.bg-orange {
    background-color: #fff7ed;
}

.bg-yellow {
    background-color: #fefce8;
}

.bg-blue {
    background-color: #eff6ff;
}

.bg-gray {
    background-color: #f9fafb;
}

.country-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.country-flag {
    font-size: 2.25rem;
}

.country-name {
    font-size: 1.5rem;
    font-weight: bold;
    color: #111827;
}

.continent-name {
    color: #4b5563;
}

.snacks-section {
    margin-bottom: 1.5rem;
}

.snacks-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.map-pin-icon {
    height: 1.25rem;
    width: 1.25rem;
    color: #d87220;
}

.snack-card {
    background-color: white;
    border-radius: 0.75rem;
    padding: 1rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    margin-bottom: 1rem;
    animation: slideInUp 0.4s ease-out both;
}

.snack-content {
    display: flex;
    gap: 1rem;
}

.snack-image {
    width: 4rem;
    height: 4rem;
    border-radius: 0.5rem;
    object-fit: cover;
}

.snack-info {
    flex: 1;
}

.snack-name {
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.25rem;
}

.snack-description {
    font-size: 0.875rem;
    color: #4b5563;
    margin-bottom: 0.5rem;
}

.snack-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    font-size: 0.75rem;
}

.flavor-tag {
    padding: 0.125rem 0.5rem;
    background-color: rgba(216, 114, 32, 0.1);
    color: #d87220;
    border-radius: 9999px;
}

.popularity-rating {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: #d97706;
}

.star-icon {
    height: 0.75rem;
    width: 0.75rem;
    fill: currentColor;
}

.cooking-time {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: #6b7280;
}

.clock-icon {
    height: 0.75rem;
    width: 0.75rem;
}

.shop-button {
    width: 100%;
    margin-top: 1.5rem;
    background-color: #d87220;
    color: white;
    padding: 0.75rem;
    border-radius: 0.75rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s;
}

.shop-button:hover {
    background-color: #c66a1c;
}

/* Placeholder Content */
.placeholder-content {
    background-color: #f9fafb;
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    border: 2px solid #e5e7eb;
}

.placeholder-icon {
    height: 4rem;
    width: 4rem;
    color: #9ca3af;
    margin: 0 auto 1rem;
}

.placeholder-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.placeholder-text {
    color: #6b7280;
}

.stats-grid {
    margin-top: 1.5rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #4b5563;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-weight: 600;
    color: #d87220;
    font-size: 1.25rem;
}

.stat-label {
    color: #4b5563;
}

/* Statistics Section */
.statistics-section {
    margin-top: 4rem;
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    text-align: center;
    animation: fadeInUp 0.8s ease-out;
}

@media (min-width: 768px) {
    .statistics-section {
        grid-template-columns: repeat(4, 1fr);
    }
}

.stat-card {
    background-color: white;
    border-radius: 0.75rem;
    padding: 1.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
}

.stat-value {
    font-size: 1.875rem;
    font-weight: bold;
    color: #d87220;
    margin-bottom: 0.5rem;
}

.stat-description {
    color: #4b5563;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes tooltipFadeIn {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}

@keyframes ping {
    75%, 100% {
        transform: scale(2);
        opacity: 0;
    }
}
</style>
