<template>
    <div id="app">
        <div class="faq-container">
            <div class="faq-header">
                <h1>Frequently Asked Questions</h1>
                <p>Find answers to common questions about our product and services</p>
            </div>

            <div class="faq-controls">
                <div class="search-box">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
                    <input
                        type="text"
                        v-model="searchQuery"
                        placeholder="Search questions..."
                        @input="filterFaqs"
                    >
                </div>

                <select class="category-filter" v-model="selectedCategory" @change="filterFaqs">
                    <option value="">All Categories</option>
                    <option v-for="category in categories" :key="category" :value="category">
                        {{ category }}
                    </option>
                </select>
            </div>

            <div class="faq-list">
                <div
                    v-for="faq in filteredFaqs"
                    :key="faq.id"
                    class="faq-item"
                    :class="{ active: activeFaq === faq.id }"
                >
                    <div class="faq-question" @click="toggleFaq(faq.id)">
                        <div>
                            <h3>{{ faq.question }}</h3>
                            <span class="category-tag">{{ faq.category }}</span>
                        </div>
                        <span class="arrow"><i class="fas fa-chevron-down"></i></span>
                    </div>

                    <div class="faq-answer">
                        <div class="faq-answer-content" v-html="faq.answer"></div>
                    </div>
                </div>

                <div v-if="filteredFaqs.length === 0" class="empty-state">
                    <i class="fas fa-search"></i>
                    <h3>No questions found</h3>
                    <p>Try adjusting your search or filter</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'FaqComponent',
    data() {
        return {
            faqs: [
                {
                    id: 1,
                    question: "How do I create an account?",
                    answer: "To create an account, click on the 'Sign Up' button at the top right corner of the page. Fill in your details including your name, email address, and a secure password. Once submitted, you'll receive a confirmation email to verify your account.",
                    category: "Account"
                },
                {
                    id: 2,
                    question: "What payment methods do you accept?",
                    answer: "We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers. All payments are processed securely through our encrypted payment system.",
                    category: "Billing"
                },
                {
                    id: 3,
                    question: "How can I reset my password?",
                    answer: "If you've forgotten your password, click on the 'Forgot Password' link on the login page. Enter your email address and we'll send you a link to reset your password. The link will expire in 24 hours for security reasons.",
                    category: "Account"
                },
                {
                    id: 4,
                    question: "What is your refund policy?",
                    answer: "We offer a 30-day money-back guarantee on all our plans. If you're not satisfied with our service, you can request a full refund within 30 days of your initial purchase. To request a refund, contact our support team with your account details.",
                    category: "Billing"
                },
                {
                    id: 5,
                    question: "How do I cancel my subscription?",
                    answer: "You can cancel your subscription at any time from your account settings. Go to the 'Billing' section and click on 'Cancel Subscription'. Your subscription will remain active until the end of your current billing period.",
                    category: "Billing"
                },
                {
                    id: 6,
                    question: "Do you offer customer support?",
                    answer: "Yes, we offer 24/7 customer support via live chat and email. Our support team is available to help you with any questions or issues you may have. You can also check our knowledge base for answers to common questions.",
                    category: "Support"
                },
                {
                    id: 7,
                    question: "Can I upgrade or downgrade my plan?",
                    answer: "Yes, you can change your plan at any time from your account settings. When upgrading, you'll immediately get access to the new features. When downgrading, the changes will take effect at the start of your next billing cycle.",
                    category: "Billing"
                },
                {
                    id: 8,
                    question: "Is my data secure?",
                    answer: "We take data security very seriously. All data is encrypted in transit and at rest. We use industry-standard security practices and regularly undergo security audits to ensure your information is protected.",
                    category: "Security"
                }
            ],
            filteredFaqs: [],
            activeFaq: null,
            searchQuery: '',
            selectedCategory: ''
        };
    },
    computed: {
        categories() {
            return [...new Set(this.faqs.map(faq => faq.category))];
        }
    },
    mounted() {
        this.filteredFaqs = this.faqs;
        // Open the first FAQ by default
        if (this.faqs.length > 0) {
            this.activeFaq = this.faqs[0].id;
        }
    },
    methods: {
        toggleFaq(id) {
            this.activeFaq = this.activeFaq === id ? null : id;
        },
        filterFaqs() {
            this.filteredFaqs = this.faqs.filter(faq => {
                const matchesSearch = faq.question.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    faq.answer.toLowerCase().includes(this.searchQuery.toLowerCase());
                const matchesCategory = !this.selectedCategory || faq.category === this.selectedCategory;
                return matchesSearch && matchesCategory;
            });

            // If no FAQ is active after filtering, activate the first one if available
            if (this.filteredFaqs.length > 0 && !this.filteredFaqs.some(faq => faq.id === this.activeFaq)) {
                this.activeFaq = this.filteredFaqs[0].id;
            } else if (this.filteredFaqs.length === 0) {
                this.activeFaq = null;
            }
        }
    }
};
</script>


<style>

.faq-container {
    max-width: 900px;
    width: 100%;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    justify-content: center;
    justify-self: center;
}

.faq-header {
    background: #4a6fc7;
    color: white;
    padding: 25px 30px;
    text-align: center;
}

.faq-header h1 {
    font-size: 28px;
    margin-bottom: 10px;
}

.faq-header p {
    opacity: 0.9;
}

.faq-controls {
    padding: 20px;
    background: #f8f9fa;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    border-bottom: 1px solid #eaeaea;
}

.search-box {
    flex: 1;
    min-width: 250px;
    position: relative;
}

.search-box input {
    width: 100%;
    padding: 12px 15px 12px 40px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 16px;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #777;
}

.category-filter {
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background: white;
    font-size: 16px;
    min-width: 180px;
}

.faq-list {
    padding: 10px;
    max-height: 500px;
    overflow-y: auto;
}

.faq-item {
    margin: 10px;
    border: 1px solid #eaeaea;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-item:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.faq-question {
    padding: 18px 20px;
    background: #f9f9f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    transition: background 0.3s;
}

.faq-question:hover {
    background: #f1f5fe;
}

.faq-question h3 {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
}

.faq-answer {
    padding: 0;
    max-height: 0;
    overflow: hidden;
    transition: all 0.4s ease;
    background: white;
    line-height: 1.6;
}

.faq-answer-content {
    padding: 20px;
}

.faq-item.active .faq-answer {
    max-height: 500px;
}

.faq-item.active .faq-question {
    background: #e8f0fe;
    border-bottom: 1px solid #eaeaea;
}

.arrow {
    font-size: 18px;
    transition: transform 0.3s ease;
}

.faq-item.active .arrow {
    transform: rotate(180deg);
    color: #4a6fc7;
}

.category-tag {
    display: inline-block;
    background: #e8f0fe;
    color: #4a6fc7;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    margin-top: 8px;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #777;
}

.empty-state i {
    font-size: 50px;
    margin-bottom: 15px;
    color: #ccc;
}

@media (max-width: 600px) {
    .faq-controls {
        flex-direction: column;
    }

    .search-box {
        min-width: 100%;
    }

    .faq-question h3 {
        font-size: 16px;
        padding-right: 15px;
    }
}
</style>
