<template>
    <div class="chat-container">
        <h2>Chat with SKEBOB AI</h2>
        <div class="chat-box" ref="chatBox">
            <div v-for="(message, index) in chatMessages" :key="index" :class="['chat-message', message.sender]">
                <p>{{ message.text }}</p>
            </div>
            <p v-if="isLoading" class="loading-message">AI is typing...</p>
        </div>
        <form @submit.prevent="sendMessage" class="chat-input">
            <input
                type="text"
                v-model="userInput"
                placeholder="Ask about yum yums or stuff..."
                required
                aria-label="Chat input"
            />
            <button type="submit" :disabled="isLoading" aria-label="Send message">Send</button>
        </form>
    </div>
</template>

<script>
export default {
    name: "ChatWithAI",
    data() {
        return {
            userInput: "",
            chatMessages: [
                { sender: "ai", text: "Hello! Ask me anything about snacks. That's all I can do :D" },
            ],
            isLoading: false,
        };
    },
    methods: {
        async sendMessage() {
            if (!this.userInput.trim()) {
                alert("Please enter a message.");
                return;
            }

            if (this.userInput.length > 500) {
                alert("Message is too long. Please limit your input to 500 characters.");
                return;
            }

            // Add user message to chat
            this.chatMessages.push({ sender: "user", text: this.userInput });

            const input = this.userInput;
            this.userInput = ""; // Clear input field
            this.scrollToBottom();
            this.isLoading = true;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            try {
                const response = await fetch("/chatai", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                        "Accept": "application/json",
                    },
                    body: JSON.stringify({ message: input }),
                });

                let data;
                const contentType = response.headers.get('content-type');

                if (contentType && contentType.includes('application/json')) {
                    data = await response.json();
                } else {
                    // If not JSON, read as text for debugging
                    const text = await response.text();
                    console.error('Non-JSON response:', text);
                    throw new Error('Server returned invalid format. Please try again.');
                }

                if (!response.ok) {
                    throw new Error(data.reply || data.message || `Server error: ${response.status}`);
                }

                this.chatMessages.push({
                    sender: "ai",
                    text: data.reply || "I couldn't process your request. Try again.",
                });
            } catch (error) {
                console.error("Error fetching AI response:", error);
                this.chatMessages.push({
                    sender: "ai",
                    text: error.message || "Sorry, I'm having trouble connecting to the server. Please try again later.",
                });
            } finally {
                this.isLoading = false;
                this.scrollToBottom();
            }
        },
        scrollToBottom() {
            this.$nextTick(() => {
                const chatBox = this.$refs.chatBox;
                if (chatBox) {
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            });
        },
    },
};
</script>
<style scoped>
.chat-container {
    width: 1000px;
    min-width: 200px;
    margin: 0 auto;
    padding: 1rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
}

.chat-box {
    max-height: 300px;
    overflow-y: auto;
    margin-bottom: 1rem;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fff;
}

.chat-message {
    margin-bottom: 0.5rem;
    padding: 0.5rem;
    border-radius: 5px;
}

.chat-message.user {
    background: #d1e7ff;
    text-align: right;
}

.chat-message.ai {
    background: #e9ecef;
    text-align: left;
}

.chat-input {
    display: flex;
    gap: 0.5rem;
}

.chat-input input {
    flex-grow: 1;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.chat-input button {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 5px;
    background: #007bff;
    color: white;
    cursor: pointer;
    transition: background 0.3s ease;
}

.chat-input button:hover {
    background: #0056b3;
}

/* Media query for screens 500px or less */
@media (max-width: 1100px) {
    .chat-container {
        width: 500px;
        min-width: 150px;
        margin: 0 auto;
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
}

@media (max-width: 520px) {
    .chat-container {
        width: 300px;
        margin: 0 auto;
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
}
</style>
