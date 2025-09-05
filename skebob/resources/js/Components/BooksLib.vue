<template>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4 text-center">📘 Computer Documentation</h2>
        <div class="book grid grid-cols-1 md:grid-cols-3 gap-6">
            <div v-for="book in books" :key="book.id" class="border rounded shadow p-4">
                <img :src="book.img" alt="Book cover" class="w-full h-48 object-cover mb-2 rounded" />
                <h3 class="text-lg font-semibold">{{ book.name }}</h3>
                <p class="text-sm text-gray-600 mb-2">{{ book.description }}</p>
                <a :href="book.file_path" target="_blank" class="text-blue-600 hover:underline">📄 Read PDF</a>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'BooksLibrary',
    data() {
        return {
            books: []
        };
    },
    mounted() {
        this.fetchBooks();
    },
    methods: {
        fetchBooks() {
            fetch('/books')
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log("Fetched products:", data);
                    this.books = data;
                })
                .catch((error) => {
                    console.error("Error fetching products:", error);
                });
        },
    },
};
</script>

<style scoped>
/* Optional custom styling */
.book {
    margin-left: 30px;
}
</style>
