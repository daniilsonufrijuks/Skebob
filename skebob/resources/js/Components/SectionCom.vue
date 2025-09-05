<template>
    <div class="w-full max-w-5xl mx-auto p-4 border border-blue-400 bg-gray-50">
        <h2 class="text-2xl font-bold mb-4">Comments</h2>

        <div v-if="user">
      <textarea
          v-model="newComment"
          placeholder="Write a comment..."
          class="w-full p-3 border rounded mb-2"
      />
            <button
                @click="submitComment"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded"
            >
                Submit
            </button>
        </div>
        <div v-else>
            <p class="text-gray-600">Please log in to comment.</p>
        </div>

        <div
            v-for="comment in comments"
            :key="comment.id"
            class="border-t pt-4 mt-4"
        >
            <strong>{{ comment.user?.name || 'Guest' }}</strong>:
            <p class="mt-1">{{ comment.body }}</p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            comments: [],
            newComment: '',
            user: null // you can get this from props or global store
        };
    },
    mounted() {
        this.fetchComments();
        this.fetchUser();
    },
    methods: {
        fetchComments() {
            axios.get('/comments')
                .then(res => this.comments = res.data);
        },
        fetchUser() {
            axios.get('/user') // requires Sanctum login session
                .then(res => this.user = res.data)
                .catch(() => this.user = null);
        },
        submitComment() {
            if (!this.newComment) return;

            axios.post('/comments', { body: this.newComment })
                .then(res => {
                    this.comments.unshift(res.data);
                    this.newComment = '';
                });
        }
    }
};
</script>
