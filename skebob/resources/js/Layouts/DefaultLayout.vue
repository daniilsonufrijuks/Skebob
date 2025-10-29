<!-- resources/js/Layouts/DefaultLayout.vue -->
<template>
    <div>
        <!-- Main content slot -->
        <slot />

        <!-- Global Mystery Box modal -->
        <div v-if="showMysteryBoxModal" class="mystery-box-modal-overlay">
            <div class="mystery-box-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>🎉 {{ $t('Congratulations') }}! 🎉</h2>
                        <p class="modal-subtitle">{{ $t('ChooseYourFreeMysteryBox') }}!</p>
<!--                        <h2>🎉 Congratulations! 🎉</h2>-->
<!--                        <p class="modal-subtitle">Choose Your FREE Mystery Box!</p>-->
                    </div>

                    <div class="modal-body">
                        <p>{{ $t('YouveSuccessfullySubscribedToSNACKtastic') }}!</p>
                        <p class="highlight-text">
                            <strong>{{ $t('SelectDeluxeMysteryBoxes') }}:</strong>
                        </p>
<!--                        <p>You've successfully subscribed to SNACKtastic!</p>-->
<!--                        <p class="highlight-text">-->
<!--                            <strong>Select one of these exclusive Deluxe Mystery Boxes:</strong>-->
<!--                        </p>-->

                        <!-- Mystery Boxes selection -->
                        <div v-if="mysteryBoxes.length > 0" class="mystery-boxes-grid">
                            <div
                                v-for="(box, index) in mysteryBoxes"
                                :key="box.id"
                                :class="['mystery-box-card', { 'selected': selectedBoxIndex === index }]"
                                @click="selectBox(index)"
                            >
                                <div class="box-image">
                                    <img :src="'/' + box.product.image" :alt="box.product.name" />
                                    <div class="box-badge">DELUXE</div>
                                </div>
                                <div class="box-details">
                                    <h3 class="box-name">{{ box.product.name }}</h3>
                                    <p class="box-description">{{ box.description }}</p>
                                    <p class="box-value">{{ $t('SubscriptionValue') }}: ${{ box.product.price }}</p>
<!--                                    <p class="box-value">Value: ${{ box.product.price }}</p>-->
                                    <div class="selection-indicator">
                                        <div v-if="selectedBoxIndex === index" class="selected-check">✓ Selected</div>
                                        <div v-else class="select-prompt">{{ $t('ClickToSelectMysteryBox') }}</div>
<!--                                        <div v-else class="select-prompt">Click to select</div>-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Loading -->
                        <div v-else-if="loadingBoxes" class="loading-boxes">
                            <p>Loading your mystery boxes...</p>
                        </div>

                        <!-- Error -->
                        <div v-else class="error-boxes">
                            <p>Unable to load mystery boxes. Please try again.</p>
                        </div>

                        <!-- Shipping Information section -->
                        <div v-if="selectedBoxIndex !== null" class="shipping-section">
                            <h3 class="shipping-title">{{ $t('ShippingInformation') }}</h3>
                            <form class="shipping-form">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="email">{{ $t('EmailAddress') }} *</label>
                                        <input
                                            type="email"
                                            id="email"
                                            v-model="shippingAddress.email"
                                            required
                                            :placeholder="$t('EnterYourEmail')"
                                        >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">{{ $t('StreetAddress') }} *</label>
                                    <input
                                        type="text"
                                        id="address"
                                        v-model="shippingAddress.address"
                                        required
                                        :placeholder="$t('EnterYourStreetAddress')"
                                    >
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="city">{{ $t('City') }} *</label>
                                        <input
                                            type="text"
                                            id="city"
                                            v-model="shippingAddress.city"
                                            required
                                            :placeholder="$t('EnterYourCity')"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="zipCode">{{ $t('ZipCode') }} *</label>
                                        <input
                                            type="text"
                                            id="zipCode"
                                            v-model="shippingAddress.zipCode"
                                            required
                                            :placeholder="$t('EnterZipCode')"
                                        >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="country">{{ $t('Country') }} *</label>
                                    <input
                                        type="text"
                                        id="country"
                                        v-model="shippingAddress.country"
                                        required
                                        :placeholder="$t('EnterYourCountry')"
                                    >
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button
                            @click="claimMysteryBox"
                            class="modal-button primary"
                            :disabled="selectedBoxIndex === null || claiming || !isShippingFormValid"
                        >
                            <span v-if="claiming">{{ $t('Claiming') }}...</span>
                            <span v-else>{{ $t('ClaimMyMysteryBox') }}</span>
<!--                            <span v-if="claiming">Claiming...</span>-->
<!--                            <span v-else>Claim My Mystery Box</span>-->
                        </button>
                        <p v-if="selectedBoxIndex === null" class="selection-required">
                            {{ $t('PleaseSelectMysteryBox') }}
                        </p>
<!--                        <p v-if="selectedBoxIndex === null" class="selection-required">-->
<!--                            Please select a mystery box to continue-->
<!--                        </p>-->
                        <p v-else-if="!isShippingFormValid" class="selection-required">
                            {{ $t('PleaseFillInAllShippingInfo') }}
                        </p>
<!--                        <p v-else-if="!isShippingFormValid" class="selection-required">-->
<!--                            Please fill in all shipping information-->
<!--                        </p>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue'
import { useI18n } from 'vue-i18n'

export default {
    setup() {
        const { t } = useI18n({ useScope: 'global' });
        const showMysteryBoxModal = ref(false)
        const mysteryBoxes = ref([])
        const loadingBoxes = ref(false)
        const selectedBoxIndex = ref(null)
        const claiming = ref(false)
        const shippingAddress = ref({
            email: '',
            address: '',
            city: '',
            zipCode: '',
            country: '',
        })

        // computed property to check if shipping form is valid
        const isShippingFormValid = computed(() => {
            const address = shippingAddress.value
            return (
                address.email &&
                address.address &&
                address.city &&
                address.zipCode &&
                address.country
            )
        })

        // function to clean URL parameters
        const cleanUrlParameters = () => {
            const url = new URL(window.location)
            if (url.searchParams.has('just_subscribed')) {
                url.searchParams.delete('just_subscribed')
                window.history.replaceState({}, document.title, url.toString())
                console.log(t('URLparametersCleaned'))
                // console.log(t('URL parameters cleaned'))
            }
        }

        // fetch random mystery boxes
        const fetchMysteryBoxes = async () => {
            // Check if we already have mystery boxes stored
            const storedBoxes = localStorage.getItem('mystery_boxes')
            if (storedBoxes) {
                console.log(t('UsingStoredMysteryBoxes'))
                // console.log('Using stored mystery boxes')
                mysteryBoxes.value = JSON.parse(storedBoxes)
                return
            }
            loadingBoxes.value = true
            try {
                const response = await fetch('/products/subscription-mystery-boxes')
                if (!response.ok) {
                    throw new Error(t('FailedToFetchMysteryBoxes'))
                    // throw new Error('Failed to fetch mystery boxes')
                }
                const data = await response.json()
                mysteryBoxes.value = data
                // store the fetched boxes in localStorage
                localStorage.setItem('mystery_boxes', JSON.stringify(data))
                console.log('Fetched and stored mystery boxes:', data)
                // console.log('Fetched and stored mystery boxes:', data)
            } catch (error) {
                console.error('Error fetching mystery boxes:', error)
                mysteryBoxes.value = []
            } finally {
                loadingBoxes.value = false
            }
        }

        // clear stored mystery boxes
        const clearStoredMysteryBoxes = () => {
            localStorage.removeItem('mystery_boxes')
            console.log('Cleared stored mystery boxes')
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
                // fetch mystery boxes when modal opens
                fetchMysteryBoxes()
                console.log(t('ModalShownFromURLParameter'))
                // console.log('Modal shown from URL parameter')
            }
            // also check localStorage for persistence but only if no URL parameter
            else if (justSubscribedFromStorage === 'true' && !justSubscribedFromUrl) {
                showMysteryBoxModal.value = true
                document.body.style.overflow = 'hidden'
                // fetch mystery boxes when modal opens
                fetchMysteryBoxes()
                console.log('Modal shown from localStorage')
            } else {
                console.log('No subscription flag found')
            }
        }

        const selectBox = (index) => {
            selectedBoxIndex.value = index
            console.log('Selected box:', mysteryBoxes.value[index])
        }

        const claimMysteryBox = async () => {
            if (selectedBoxIndex.value === null || !isShippingFormValid.value) return
            claiming.value = true
            try {
                const selectedBox = mysteryBoxes.value[selectedBoxIndex.value]
                const shippingData = shippingAddress.value
                console.log('Claiming mystery box:', selectedBox)
                console.log('Shipping address:', shippingData)
                // make API call to create the order
                const response = await fetch('/order/mystery-box-claim', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        mystery_box_id: selectedBox.id,
                        product_id: selectedBox.product.id,
                        shipping_address: shippingData
                    })
                })
                const result = await response.json()
                if (!response.ok) {
                    throw new Error(result.error || 'Failed to claim mystery box')
                }
                // remove from all storage methods
                localStorage.removeItem('just_subscribed')
                clearStoredMysteryBoxes()
                cleanUrlParameters()
                showMysteryBoxModal.value = false
                document.body.style.overflow = 'auto'
                console.log('Mystery box claimed successfully:', result)
                // show success message with order details
                // alert(`🎉 Congratulations! You've claimed the "${selectedBox.product.name}" mystery box!\n\nYour order #${result.order_id} has been created and will be shipped to:\n${shippingData.address}, ${shippingData.city}, ${shippingData.zipCode}, ${shippingData.country}\n\nYou will receive a confirmation email at ${shippingData.email}`)
                alert(`🎉 ${t('Congratulations')}! ${t('YouveClaimedMysteryBox', { box: selectedBox.product.name })}
${t('OrderCreatedWithID', { id: result.order_id })}
${t('WillBeShippedTo')}:
${shippingData.address}, ${shippingData.city}, ${shippingData.zipCode}, ${shippingData.country}
${t('ConfirmationEmailSentTo', { email: shippingData.email })}`)

            } catch (error) {
                console.error('Error claiming mystery box:', error)
                alert(`${t('ErrorClaimingMysteryBox')}: ${error.message}`)
                // alert('There was an error claiming your mystery box: ' + error.message)
            } finally {
                claiming.value = false
            }
        }
        // also clear stored boxes if modal is closed without claiming
        const closeModalIfNeeded = () => {
            clearStoredMysteryBoxes()
            showMysteryBoxModal.value = false
            document.body.style.overflow = 'auto'
        }
        onMounted(() => {
            checkSubscription()
        })
        return {
            showMysteryBoxModal,
            mysteryBoxes,
            loadingBoxes,
            selectedBoxIndex,
            claiming,
            shippingAddress,
            isShippingFormValid,
            selectBox,
            claimMysteryBox,
            closeModalIfNeeded
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
    padding: 20px;
    box-sizing: border-box;
    overflow-y: auto;
}

.mystery-box-modal {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 4px;
    max-width: 900px;
    width: 95%;
    max-height: 90vh;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.4s ease;
    margin: auto;
}

.modal-content {
    background: white;
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    max-height: 100%;
    overflow-y: auto;
}

.modal-header h2 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 28px;
    font-weight: bold;
}

.modal-subtitle {
    margin: 0 0 20px 0;
    color: #666;
    font-size: 18px;
    font-weight: 500;
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

/* custom scrollbar for modal */
.modal-content::-webkit-scrollbar {
    width: 6px;
}

.modal-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.modal-content::-webkit-scrollbar-thumb {
    background: #d87220;
    border-radius: 3px;
}

.modal-content::-webkit-scrollbar-thumb:hover {
    background: #a5500d;
}

/* Mystery Boxes grid */
.mystery-boxes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 30px 0;
}

.mystery-box-card {
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    padding: 15px;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: left;
}

.mystery-box-card:hover {
    border-color: #d87220;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.mystery-box-card.selected {
    border-color: #d87220;
    background: #fff9f5;
    box-shadow: 0 4px 15px rgba(216, 114, 32, 0.2);
}

.box-image {
    width: 110px;
    height: 110px;
    position: relative;
    margin: 0 auto 15px auto;
    overflow: hidden;
}

.box-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
}

.box-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #d87220;
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
}

.box-details h3 {
    margin: 0 0 8px 0;
    color: #333;
    font-size: 16px;
    font-weight: bold;
}

.box-description {
    font-size: 11px;
    color: #666;
    margin-bottom: 8px;
    line-height: 1.4;
}

.box-value {
    font-size: 14px;
    color: #d87220;
    font-weight: bold;
    margin-bottom: 10px;
}

.selection-indicator {
    font-size: 12px;
    font-weight: bold;
}

.selected-check {
    color: #4CAF50;
}

.select-prompt {
    color: #999;
}

.shipping-section {
    background: #f9f9f9;
    padding: 25px;
    border-radius: 8px;
    margin: 25px 0;
    border: 1px solid #e0e0e0;
}

.shipping-title {
    color: #333;
    margin-bottom: 20px;
    border-bottom: 2px solid #d87220;
    padding-bottom: 10px;
    font-size: 18px;
    font-weight: 600;
}

.shipping-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
}

.form-group input {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-group input:focus {
    outline: none;
    border-color: #d87220;
    box-shadow: 0 0 0 2px rgba(216, 114, 32, 0.1);
}

/* Loading and error */
.loading-boxes, .error-boxes {
    padding: 40px;
    text-align: center;
    color: #666;
}

.error-boxes {
    color: #e74c3c;
}

.modal-footer {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    position: sticky;
    bottom: 0;
    background: white;
    padding-top: 10px;
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

.modal-button.primary:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
}

.modal-button.primary:disabled {
    background: #cccccc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.selection-required {
    color: #e74c3c;
    font-size: 14px;
    margin: 0;
    text-align: center;
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

@media (max-width: 768px) {
    .mystery-box-modal-overlay {
        padding: 10px;
        align-items: flex-start;
    }

    .mystery-box-modal {
        width: 100%;
        max-height: 95vh;
        margin: 0;
    }

    .modal-content {
        padding: 20px 15px;
        max-height: 95vh;
    }

    .mystery-boxes-grid {
        grid-template-columns: 1fr;
        gap: 15px;
        margin: 20px 0;
    }

    .modal-header h2 {
        font-size: 24px;
    }

    .modal-subtitle {
        font-size: 16px;
    }

    .modal-body p {
        font-size: 14px;
    }

    .highlight-text {
        font-size: 16px !important;
    }

    .modal-button {
        padding: 12px 30px;
        font-size: 16px;
        min-width: 180px;
    }

    .shipping-section {
        padding: 20px;
        margin: 20px 0;
    }

    .form-row {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .shipping-title {
        font-size: 16px;
    }
}

</style>
