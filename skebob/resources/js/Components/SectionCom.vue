<template>
    <div id="app" class="container">
        <div class="comment-section">
            <h2>{{ $t('commentsTitle') }}</h2>

            <!-- Comment form -->
            <div v-if="user" class="comment-form">
                <textarea
                    v-model="newComment"
                    :placeholder="$t('commentsWritePlaceholder')"
                    :disabled="isSubmitting">
                </textarea>

                <button
                    @click="submitComment"
                    class="btn"
                    :disabled="isSubmitting || !newComment.trim()"
                >
                    {{ isSubmitting ? $t('commentsSubmitting') : $t('commentsSubmit') }}
                </button>
            </div>

            <div v-else class="auth-prompt">
                <p>{{ $t('loginPrompt') }}</p>
            </div>

            <!-- Error message -->
            <div v-if="error" class="error-message">
                <span class="error-icon">⚠️</span>
                <div>
                    <strong>{{ $t('CommentsError') }}</strong> {{ error }}
                    <button @click="fetchComments" class="btn retry-btn">
                        {{ $t('CommentsRetry') }}
                    </button>
                </div>
            </div>

            <!-- Comments list -->
            <div v-if="isLoading" class="loading">{{ $t('LoadingComments') }}</div>

            <div v-else>
                <div v-if="comments.length === 0" class="loading">
                    {{ $t('NoCommentsYet') }}
                </div>

                <div v-else class="comments-list">
                    <div v-for="comment in comments" :key="comment.id" class="comment">
                        <div class="comment-header">
                            <div>
                                <!-- <div class="user-name">{{ comment.user.name }}</div> -->
                                <!-- <div class="timestamp">{{ formatDate(comment.created_at) }}</div> -->
                            </div>
                        </div>
                        <p class="comment-body">{{ comment.body }}</p>
                    </div>
                </div>
            </div>
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
            user: null,
            error: null,
            isLoading: false,
            isSubmitting: false
        };
    },
    mounted() {
        this.fetchComments();
        this.fetchUser();
    },
    methods: {
        fetchComments() {
            this.isLoading = true;
            this.error = null;
            axios.get('/comments')
                .then(res => {
                    this.comments = res.data;
                })
                .catch(err => {
                    console.error("Fetch comments error:", err);
                    this.error = err.message || 'Failed to load comments.';
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        fetchUser() {
            axios.get('/user')
                .then(res => this.user = res.data)
                .catch(() => this.user = null);
        },
        submitComment() {
            if (!this.newComment.trim()) return;
            this.isSubmitting = true;

            axios.post('/comments', { body: this.newComment })
                .then(res => {
                    this.comments.unshift(res.data);
                    this.newComment = '';

                    // Optional: auto-scroll to top after adding comment
                    this.$nextTick(() => {
                        const list = this.$el.querySelector('.comments-list');
                        if (list) list.scrollTop = 0;
                    });
                })
                .catch(err => {
                    console.error("Submit comment error:", err);
                    this.error = err.message || 'Failed to submit comment.';
                })
                .finally(() => {
                    this.isSubmitting = false;
                });
        },
        formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleString();
        }
    }
};
</script>

<style scoped>
.container {
    max-width: 1230px;
    margin: 0 auto;
    padding: 20px;
}

.comment-section {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    padding: 25px;
}

h2 {
    color: #2c3e50;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #eaeaea;
}

.comment-form {
    margin-bottom: 30px;
}

textarea {
    width: 100%;
    min-height: 100px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 16px;
    margin-bottom: 10px;
    resize: vertical;
    transition: border-color 0.3s;
}

textarea:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
}

.auth-prompt {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    text-align: center;
    color: #6c757d;
}

.btn {
    background: #3498db;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s;
}

.btn:hover {
    background: #2980b9;
}

.btn:disabled {
    background: #bdc3c7;
    cursor: not-allowed;
}

/* SCROLLABLE COMMENTS LIST */
.comments-list {
    max-height: 400px; /* Adjust this value to your layout */
    overflow-y: auto;
    padding-right: 10px;
    margin-top: 10px;
    border-top: 1px solid #eaeaea;
}

.comments-list::-webkit-scrollbar {
    width: 8px;
}

.comments-list::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 4px;
}

.comments-list::-webkit-scrollbar-thumb:hover {
    background-color: #999;
}

.comment {
    padding: 20px 0;
    border-bottom: 1px solid #eaeaea;
}

.comment:last-child {
    border-bottom: none;
}

.comment-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #3498db;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-right: 10px;
}

.user-name {
    font-weight: bold;
    color: #2c3e50;
}

.comment-body {
    color: #34495e;
    line-height: 1.5;
}

.error-message {
    background: #ffecec;
    color: #e74c3c;
    padding: 12px;
    border-radius: 6px;
    margin: 15px 0;
    display: flex;
    align-items: center;
}

.error-icon {
    margin-right: 10px;
    font-size: 20px;
}

.retry-btn {
    background: #e74c3c;
    margin-left: 15px;
}

.retry-btn:hover {
    background: #c0392b;
}

.loading {
    text-align: center;
    padding: 20px;
    color: #7f8c8d;
}

.timestamp {
    font-size: 12px;
    color: #95a5a6;
    margin-top: 5px;
}
</style>
