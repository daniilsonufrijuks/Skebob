<!-- resources/js/Layouts/DefaultLayout.vue -->
<template>
    <div>
        <!--        <Navbar :routes="routes"/>-->
        <!-- Main content slot -->
        <slot />

        <!-- Global Mystery Box modal -->
        <div v-if="showMysteryBoxModal" class="mystery-box-modal-overlay">
            <div class="mystery-box-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>🎉 Congratulations! 🎉</h2>
                    </div>
                    <div class="modal-body">
                        <p>You've successfully subscribed to SNACKtastic!</p>
                        <p class="highlight-text">
                            <strong>You can now claim your FREE Mystery Box!</strong>
                        </p>
                        <p>Discover surprise snacks and products worth up to $50 delivered to your door every 2 months.</p>
                    </div>
                    <div class="modal-footer">
                        <button @click="claimMysteryBox" class="modal-button primary">
                            Get My Mystery Box
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue'

export default {
    setup() {
        const showMysteryBoxModal = ref(false)
        // function to clean URL parameters, otherwise modal won't disappear
        const cleanUrlParameters = () => {
            const url = new URL(window.location)
            if (url.searchParams.has('just_subscribed')) {
                url.searchParams.delete('just_subscribed')
                window.history.replaceState({}, document.title, url.toString())
                console.log('URL parameters cleaned')
            }
        }

        const checkSubscription = () => {
            // check URL parameters first
            const urlParams = new URLSearchParams(window.location.search)
            const justSubscribedFromUrl = urlParams.get('just_subscribed')
            // check localStorage for persistence
            const justSubscribedFromStorage = localStorage.getItem('just_subscribed')
            console.log('URL parameter:', justSubscribedFromUrl)
            console.log('localStorage:', justSubscribedFromStorage)

            if (justSubscribedFromUrl === 'true') {
                showMysteryBoxModal.value = true
                document.body.style.overflow = 'hidden'
                // set localStorage so it persists after navigation
                localStorage.setItem('just_subscribed', 'true')
                console.log('Modal shown from URL parameter')
            }
            // also check localStorage for persistence but only if no URL parameter
            else if (justSubscribedFromStorage === 'true' && !justSubscribedFromUrl) {
                showMysteryBoxModal.value = true
                document.body.style.overflow = 'hidden'
                console.log('Modal shown from localStorage')
            } else {
                console.log('No subscription flag found')
            }
        }

        const claimMysteryBox = () => {
            // remove from all storage methods
            localStorage.removeItem('just_subscribed')
            cleanUrlParameters()
            // close modal
            showMysteryBoxModal.value = false
            document.body.style.overflow = 'auto'
            console.log('Mystery box claimed! All storage cleaned.')
        }
        onMounted(() => {
            checkSubscription()
        })
        return {
            showMysteryBoxModal,
            claimMysteryBox
        }
    }
}
</script>

<style scoped>
.mystery-box-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(5px);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    animation: fadeIn 0.3s ease;
}

.mystery-box-modal {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 4px;
    max-width: 500px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.4s ease;
}

.modal-content {
    background: white;
    border-radius: 16px;
    padding: 40px 30px;
    text-align: center;
}

.modal-header h2 {
    margin: 0 0 20px 0;
    color: #333;
    font-size: 28px;
    font-weight: bold;
}

.modal-body {
    margin-bottom: 30px;
}

.modal-body p {
    margin: 10px 0;
    font-size: 16px;
    line-height: 1.5;
    color: #555;
}

.highlight-text {
    font-size: 18px !important;
    color: #d87220 !important;
    font-weight: bold;
    margin: 20px 0 !important;
}

.modal-footer {
    display: flex;
    justify-content: center;
}

.modal-button {
    padding: 15px 40px;
    border: none;
    border-radius: 50px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 200px;
}

.modal-button.primary {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
}

.modal-button.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        transform: translateY(30px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>
