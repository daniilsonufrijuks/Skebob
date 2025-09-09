<template>
    <div class="container_search">
        <div class="row height d-flex justify-content-center align-items-center">
            <div class="col-md-8">
                <div class="search">
                    <i class="fa fa-search"></i>
                    <form @submit.prevent="handleSearch" id="searchForm" class="form-inline form">
                        <input type="text" id="searchInput" class="form-control" placeholder="Searching..." v-model="query" @input="fetchSuggestions">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                    <!-- Suggestions list -->
                    <ul v-if="filteredQueries.length > 0" id="suggestions" class="suggestions-list">
                        <li v-for="(suggestion, index) in filteredQueries" :key="index" @click="handleSuggestionClick(suggestion)">
                            {{ suggestion.name }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import { route } from "ziggy-js";

export default {
    data() {
        return {
            query: '',
            filteredQueries: [],
        };
    },
    methods: {
        // Fetch suggestions from the server based on the query
        async fetchSuggestions() {
            if (this.query.length > 2) {
                try {
                    const response = await axios.get('/search', {
                        params: {query: this.query},
                    });
                    this.filteredQueries = response.data;
                } catch (error) {
                    console.error('Error fetching search suggestions:', error);
                }
            } else {
                this.filteredQueries = [];
            }
        },

        // Handles search logic on form submission
        handleSearch() {
            const query = this.query.toLowerCase();

            // Predefined search redirects based on certain queries
            if (['about us', 'aboutus', 'about'].includes(query)) {
                window.location.href = "/about";
            } else if (query === 'home') {
                window.location.href = "/";
            } else if (['contacts', 'contact'].includes(query)) {
                window.location.href = "/contact";
            } else if (['market', 'markets', 'shop'].includes(query)) {
                window.location.href = "/market";
            } else if (['laptop', 'laptops', 'notebook'].includes(query)) {
                window.location.href = "/laptops";
            } else if (['pc', 'PC', 'pcs', 'computer'].includes(query)) {
                window.location.href = "/pcs";
            } else if (['components', 'videocards', 'cpu', 'ram', 'ssd', 'gpu', 'processor'].includes(query)) {
                window.location.href = "/components";
            }
            // } else {
            //     // If no predefined page matches, search the products
            //
            // }
        },

        // Handle click on suggestion to directly navigate
        handleSuggestionClick(suggestion) {
            this.query = suggestion.name;  // Update input with selected suggestion
            window.location.href = `/product?id=${suggestion.id}`
        },
    },
};
</script>

<style scoped>
.search {
    display: flex;
    position: relative;
    box-shadow: 0 0 40px rgba(51, 51, 51, .1);
    align-items: center;
    height: 40px;
}

.search i.fa {
    width: 60px;
    display: inline-block;
    text-align: center;
    padding-left: 10px;
}

.container_search {
    padding: 30px !important;
}

.search input {
    flex-grow: 1;
    height: 40px;
    text-indent: 25px;
    border: 2px solid #d6d4d4;
}

.search form {
    display: flex;
    width: 100%;
}

.search button {
    position: absolute;
    right: 1px;
    height: 40px;
    width: 110px;
    background: #d87220;
}

.search button:hover {
    background: #985016;
}

/* Suggestions list style */
.suggestions-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
    border: 1px solid #ddd;
    max-height: 200px;
    overflow-y: auto;
    position: absolute;
    z-index: 10000000;
    top: 100%; /* Positions the suggestions directly below the search bar */
    left: 0;
    background-color: white;
    width: 100%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.suggestions-list li {
    padding: 8px;
    cursor: pointer;
}

.suggestions-list li:hover {
    background-color: #f0f0f0;
}
</style>
