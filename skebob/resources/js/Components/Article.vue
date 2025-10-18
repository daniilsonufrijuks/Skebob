<template>
    <section class="blog-section">
        <div class="blog-container">
            <!-- Header -->
            <div class="blog-header">
                <h2 class="blog-title">
                    {{ $t('BlogTitle') }}
                </h2>
                <p class="blog-description">
                    {{ $t('BlogDescription') }}
                </p>
<!--                <h2 class="blog-title">-->
<!--                    Snack Stories & Video Reviews-->
<!--                </h2>-->
<!--                <p class="blog-description">-->
<!--                    Dive into the fascinating world of snacks with our expert insights, taste tests,-->
<!--                    and behind-the-scenes stories from the Skebob team.-->
<!--                </p>-->
            </div>

            <!-- Content Type Tabs -->
            <div class="tabs-container">
                <div class="tabs-wrapper">
                    <button
                        @click="activeTab = 'all'"
                        :class="['tab-button', { 'tab-active': activeTab === 'all' }]"
                    >
                        {{ $t('BlogAllContent') }}
                    </button>
                    <button
                        @click="activeTab = 'articles'"
                        :class="['tab-button', { 'tab-active': activeTab === 'articles' }]"
                    >
                        {{ $t('BlogArticles') }}
                    </button>
                    <button
                        @click="activeTab = 'videos'"
                        :class="['tab-button', { 'tab-active': activeTab === 'videos' }]"
                    >
                        {{ $t('BlogVideos') }}
                    </button>
                </div>
            </div>

            <!-- Featured Video (when videos tab is active) -->
            <div v-if="activeTab === 'videos' || activeTab === 'all'" class="featured-video">
                <div class="featured-video-card">
                    <div class="video-container">
                        <iframe
                            :src="`https://www.youtube.com/embed/${videos[0].id}`"
                            :title="videos[0].title"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            class="video-iframe"
                        ></iframe>
                    </div>
                    <div class="featured-content">
                        <div class="featured-meta">
              <span class="featured-badge">
                {{ $t('FeaturedVideo') }}
              </span>
                            <span class="duration">{{ videos[0].duration }}</span>
                        </div>
                        <h3 class="featured-title">{{ videos[0].title }}</h3>
                        <p class="featured-description">{{ videos[0].description }}</p>
                        <div class="featured-stats">
                            <span>{{ videos[0].views }} views</span>
                            <span>{{ formatDate(videos[0].publishedAt) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Articles -->
                <template v-if="activeTab === 'articles' || activeTab === 'all'">
                    <div
                        v-for="post in (activeTab === 'all' ? blogPosts.slice(0, 3) : blogPosts)"
                        :key="'article-' + post.id"
                        class="content-card article-card"
                    >
                        <div class="card-image-container">
                            <img
                                :src="post.imageUrl"
                                :alt="post.title"
                                class="card-image"
                            />
                            <div class="image-badge">
                <span :class="getCategoryClass(post.category)" class="category-badge">
                  {{ post.category }}
                </span>
                            </div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">
                                {{ post.title }}
                            </h3>
                            <p class="card-description">
                                {{ post.excerpt }}
                            </p>
                            <div class="card-meta">
                                <div class="meta-item">
                                    <svg class="meta-icon" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ post.author }}
                                </div>
                                <div class="meta-item">
                                    <svg class="meta-icon" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ post.readTime }}
                                </div>
                            </div>
                            <div class="card-footer">
                <span class="post-date">
                  {{ formatDate(post.date) }}
                </span>
                                <button class="read-more-btn">
                                    {{ $t('ReadMore') }}
                                    <svg class="arrow-icon" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Videos -->
                <template v-if="activeTab === 'videos' || activeTab === 'all'">
                    <div
                        v-for="video in (activeTab === 'all' ? videos.slice(1, 4) : videos.slice(1))"
                        :key="'video-' + video.id"
                        class="content-card video-card"
                    >
                        <div class="video-embed-container">
                            <iframe
                                :src="`https://www.youtube.com/embed/${video.id}`"
                                :title="video.title"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                class="video-embed"
                            ></iframe>
                        </div>
                        <div class="card-content">
                            <div class="video-meta">
                <span class="video-badge">
                  Video
                </span>
                                <span class="video-duration">{{ video.duration }}</span>
                            </div>
                            <h3 class="video-title">
                                {{ video.title }}
                            </h3>
                            <p class="video-description">{{ video.description }}</p>
                            <div class="video-stats">
                                <span>{{ video.views }} views</span>
                                <span>{{ formatDate(video.publishedAt) }}</span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Load More Button -->
            <div class="load-more-container">
                <button class="load-more-btn">
                    {{ $t('LoadMoreContent') }}
                </button>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue'

const activeTab = ref('all')

const blogPosts = ref([
    {
        id: 1,
        title: "The Ultimate Guide to International Snacking: A Journey Around the World",
        excerpt: "Discover unique flavors from Japan's wasabi Kit-Kats to Mexico's chili-lime treats. Explore how different cultures have perfected the art of snacking.",
        author: "Sarah Chen",
        date: "2024-01-15",
        readTime: "5 min read",
        category: "Culture",
        imageUrl: "https://images.unsplash.com/photo-1606890737304-57a1ca8a5b62?w=800&h=600&fit=crop",
        slug: "ultimate-guide-international-snacking"
    },
    {
        id: 2,
        title: "Mystery Box Unboxing: What Makes Our Curated Selection Special",
        excerpt: "Go behind the scenes of our mystery box curation process. Learn how we source rare treats and create the perfect surprise for snack enthusiasts.",
        author: "Mike Rodriguez",
        date: "2024-01-12",
        readTime: "3 min read",
        category: "Product",
        imageUrl: "https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=600&fit=crop",
        slug: "mystery-box-curation-process"
    },
    {
        id: 3,
        title: "5 Innovative Snack Trends That Are Taking Over 2024",
        excerpt: "From plant-based protein chips to fermented fruit snacks, discover the exciting trends shaping the future of snacking.",
        author: "Emma Thompson",
        date: "2024-01-10",
        readTime: "4 min read",
        category: "Trends",
        imageUrl: "https://images.unsplash.com/photo-1567306226416-28f0efdc88ce?w=800&h=600&fit=crop",
        slug: "snack-trends-2024"
    },
    {
        id: 4,
        title: "The Science Behind Flavor Pairing: Creating Perfect Snack Combinations",
        excerpt: "Understanding the chemistry of taste can elevate your snacking experience. Learn which flavors complement each other and why.",
        author: "Dr. James Park",
        date: "2024-01-08",
        readTime: "6 min read",
        category: "Science",
        imageUrl: "https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=800&h=600&fit=crop",
        slug: "science-flavor-pairing"
    },
    {
        id: 5,
        title: "Sustainable Snacking: How We're Reducing Our Environmental Impact",
        excerpt: "Discover our commitment to eco-friendly packaging and sustainable sourcing practices that help protect the planet while delivering delicious treats.",
        author: "Lisa Green",
        date: "2024-01-05",
        readTime: "4 min read",
        category: "Sustainability",
        imageUrl: "https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&h=600&fit=crop",
        slug: "sustainable-snacking-practices"
    },
    {
        id: 6,
        title: "From Local Markets to Your Door: Our Global Sourcing Journey",
        excerpt: "Follow our team as we travel to local markets across continents, discovering authentic flavors and supporting small producers worldwide.",
        author: "Carlos Martinez",
        date: "2024-01-03",
        readTime: "7 min read",
        category: "Sourcing",
        imageUrl: "https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800&h=600&fit=crop",
        slug: "global-sourcing-journey"
    }
])

const videos = ref([
    {
        id: "jaRfBM7ESfc?si=Bu8mZgEkmIJC5Wp8",
        title: "Trying 50 International Snacks in 10 Minutes - Epic Taste Test Challenge!",
        description: "Join our team as we embark on the ultimate international snack adventure! From spicy Korean chips to sweet Japanese Kit-Kats, we're tasting it all.",
        duration: "12:34",
        views: "2.5M",
        publishedAt: "2024-01-20"
    },
    {
        id: "qBu08O4QEP8?si=-4qsrVaKVz2u-qCj",
        title: "Mystery Box Unboxing #47: Rare Snacks from Thailand",
        description: "Opening our latest mystery box featuring exclusive treats from Thailand that you can't find anywhere else! Some surprising flavors await...",
        duration: "8:45",
        views: "890K",
        publishedAt: "2024-01-18"
    },
    {
        id: "Hwybp38GnZw?si=6P4eK_ji3cDsDoGJ",
        title: "The Most Expensive Snacks in the World - Are They Worth It?",
        description: "We're testing luxury snacks that cost over $100 each! From gold-covered chocolates to rare truffle chips, let's see if price equals taste.",
        duration: "15:22",
        views: "1.8M",
        publishedAt: "2024-01-15"
    },
    {
        id: "fRIXxo5wpbg?si=NL3Hu3l-BObggdyD",
        title: "Making Homemade Versions of Popular Snacks - Recipe Challenge",
        description: "Can we recreate famous snack brands at home? We're attempting to make our own versions of popular treats with surprising results!",
        duration: "18:56",
        views: "3.2M",
        publishedAt: "2024-01-12"
    },
    {
        id: "fC7oUOUEEi4",
        title: "Snack Tier List: Ranking 100 Popular Treats",
        description: "The ultimate snack ranking! We're placing 100 popular snacks into tiers from S-tier (amazing) to F-tier (terrible). Do you agree with our choices?",
        duration: "25:18",
        views: "4.1M",
        publishedAt: "2024-01-08"
    }
])

const categoryColors = {
    Culture: "category-culture",
    Product: "category-product",
    Trends: "category-trends",
    Science: "category-science",
    Sustainability: "category-sustainability",
    Sourcing: "category-sourcing"
}

const getCategoryClass = (category) => {
    return categoryColors[category] || "category-default"
}

const formatDate = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    })
}
</script>

<style scoped>
.blog-section {
    padding: 4rem 0;
    background-color: #f9fafb;
}

.blog-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1rem;
}

@media (min-width: 640px) {
    .blog-container {
        padding: 0 1.5rem;
    }
}

@media (min-width: 1024px) {
    .blog-container {
        padding: 0 2rem;
    }
}

/* Header Styles */
.blog-header {
    text-align: center;
    margin-bottom: 3rem;
}

.blog-title {
    font-size: 2.25rem;
    font-weight: bold;
    margin-bottom: 1rem;
    color: #d87220;
}

.blog-description {
    font-size: 1.125rem;
    color: #4b5563;
    max-width: 48rem;
    margin: 0 auto;
}

/* Tabs Styles */
.tabs-container {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
}

.tabs-wrapper {
    background-color: white;
    border-radius: 0.5rem;
    padding: 0.25rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
}

.tab-button {
    padding: 0.5rem 1.5rem;
    border-radius: 0.375rem;
    transition: all 0.2s;
    color: #4b5563;
    border: none;
    background: none;
    cursor: pointer;
}

.tab-button:hover {
    color: #d87220;
}

.tab-active {
    background-color: #d87220 !important;
    color: white !important;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

/* Featured Video Styles */
.featured-video {
    margin-bottom: 3rem;
}

.featured-video-card {
    background-color: white;
    border-radius: 0.75rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.video-container {
    aspect-ratio: 16 / 9;
}

.video-iframe {
    width: 100%;
    height: 100%;
}

.featured-content {
    padding: 1.5rem;
}

.featured-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.featured-badge {
    background-color: #fef2f2;
    color: #b91c1c;
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
}

.duration {
    font-size: 0.875rem;
    color: #6b7280;
}

.featured-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0.75rem;
    color: #111827;
}

.featured-description {
    color: #4b5563;
    margin-bottom: 1rem;
}

.featured-stats {
    display: flex;
    align-items: center;
    font-size: 0.875rem;
    color: #6b7280;
    gap: 1rem;
}

/* Content Grid Styles */
.content-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

@media (min-width: 768px) {
    .content-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .content-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.content-card {
    background-color: white;
    border-radius: 0.75rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: box-shadow 0.3s;
}

.content-card:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

/* Article Card Styles */
.card-image-container {
    position: relative;
    overflow: hidden;
}

.card-image {
    width: 100%;
    height: 12rem;
    object-fit: cover;
    transition: transform 0.3s;
}

.content-card:hover .card-image {
    transform: scale(1.05);
}

.image-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
}

.category-badge {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
}

.category-culture {
    background-color: #dbeafe;
    color: #1e40af;
}

.category-product {
    background-color: #dcfce7;
    color: #166534;
}

.category-trends {
    background-color: #f3e8ff;
    color: #7c2d12;
}

.category-science {
    background-color: #fee2e2;
    color: #b91c1c;
}

.category-sustainability {
    background-color: #d1fae5;
    color: #065f46;
}

.category-sourcing {
    background-color: #fef3c7;
    color: #92400e;
}

.category-default {
    background-color: #f3f4f6;
    color: #374151;
}

.card-content {
    padding: 1.5rem;
}

.card-title {
    font-weight: bold;
    margin-bottom: 0.75rem;
    line-height: 1.25;
    transition: color 0.3s;
    cursor: pointer;
}

.content-card:hover .card-title {
    color: #d87220;
}

.card-description {
    color: #4b5563;
    font-size: 0.875rem;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.card-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.75rem;
    color: #6b7280;
    margin-bottom: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.meta-icon {
    width: 0.75rem;
    height: 0.75rem;
}

.card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.post-date {
    font-size: 0.75rem;
    color: #9ca3af;
}

.read-more-btn {
    color: #d87220;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    border: none;
    background: none;
    cursor: pointer;
    transition: color 0.3s;
}

.read-more-btn:hover {
    color: #ea580c;
}

.arrow-icon {
    width: 0.75rem;
    height: 0.75rem;
}

/* Video Card Styles */
.video-embed-container {
    aspect-ratio: 16 / 9;
    overflow: hidden;
}

.video-embed {
    width: 100%;
    height: 100%;
}

.video-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.75rem;
}

.video-badge {
    background-color: #fef2f2;
    color: #b91c1c;
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
}

.video-duration {
    font-size: 0.75rem;
    color: #6b7280;
}

.video-title {
    font-weight: bold;
    margin-bottom: 0.5rem;
    line-height: 1.25;
    transition: color 0.3s;
    cursor: pointer;
}

.content-card:hover .video-title {
    color: #d87220;
}

.video-description {
    color: #4b5563;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.video-stats {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.75rem;
    color: #6b7280;
}

/* Load More Button */
.load-more-container {
    text-align: center;
    margin-top: 3rem;
}

.load-more-btn {
    background-color: white;
    border: 2px solid #d87220;
    color: #d87220;
    padding: 0.75rem 2rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.2s;
    cursor: pointer;
}

.load-more-btn:hover {
    background-color: #d87220;
    color: white;
}
</style>
