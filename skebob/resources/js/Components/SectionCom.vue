<template>
    <div id="app" class="container">
        <div class="comment-section">
            <h2>{{ $t('commentsTitle') }}</h2>
<!--            <h2>Comments</h2>-->

            <!-- Comment form -->
            <div v-if="user" class="comment-form">
                <textarea
                    v-model="newComment"
                    :placeholder="$t('commentsWritePlaceholder')"
                    :disabled="isSubmitting">
                </textarea>
<!--                <textarea -->
<!--                    v-model="newComment" -->
<!--                    placeholder="Write a comment..." -->
<!--                    :disabled="isSubmitting">-->
<!--                </textarea>-->

                <button
                    @click="submitComment"
                    class="btn"
                    :disabled="isSubmitting || !newComment.trim()"
                >
                    {{ isSubmitting ? $t('commentsSubmitting') : $t('commentsSubmit') }}
                </button>
<!--                <button -->
<!--                    @click="submitComment" -->
<!--                    class="btn" -->
<!--                    :disabled="isSubmitting || !newComment.trim()"-->
<!--                >-->
<!--                    {{ isSubmitting ? 'Submitting...' : 'Submit' }}-->
<!--                </button>-->

            </div>
            <div v-else class="auth-prompt">
                <p>{{ $t('loginPrompt') }}</p>
<!--                <p>Please log in to leave a comment.</p>-->
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
<!--                <div>-->
<!--                    <strong>Error:</strong> {{ error }}-->
<!--                    <button @click="fetchComments" class="btn retry-btn">Retry</button>-->
<!--                </div>-->
            </div>

            <!-- Comments list -->
            <div v-if="isLoading" class="loading">{{ $t('LoadingComments') }}</div>
<!--            <div v-if="isLoading" class="loading">Loading comments...</div>-->

            <div v-else>
                <div v-if="comments.length === 0" class="loading">
                    {{ $t('NoCommentsYet') }}
                </div>
<!--                <div v-if="comments.length === 0" class="loading">-->
<!--                    No comments yet. Be the first to comment!-->
<!--                </div>-->

                <div v-else>
                    <div v-for="comment in comments" :key="comment.id" class="comment">
                        <div class="comment-header">
<!--                            <div class="user-avatar">{{ comment.user.name.charAt(0) }}</div>-->
                            <div>
<!--                                <div class="user-name">{{ comment.user.name }}</div>-->
<!--                                <div class="timestamp">{{ formatDate(comment.created_at) }}</div>-->
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
                .then(res => this.comments = res.data)
                .catch(err => console.error("Fetch comments error:", err));

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
                })
                .catch(err => console.error("Submit comment error:", err));
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
.login-demo {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    gap: 10px;
}
.login-btn {
    flex: 1;
    text-align: center;
    padding: 10px;
    background: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
}
.login-btn:hover {
    background: #e9ecef;
}
.logged-in-as {
    background: #e8f5e9;
    padding: 10px 15px;
    border-radius: 6px;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.logout-btn {
    background: #e74c3c;
    padding: 5px 10px;
    font-size: 14px;
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
