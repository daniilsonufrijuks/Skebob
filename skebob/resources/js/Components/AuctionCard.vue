
<template>
    <section id="productdetails" v-if="item">
        <div class="single-pro-image">
            <img :src="item.img || ''" width="50%" id="MainImg" alt="">
        </div>
        <div class="single-pro-details">
            <h2>{{ item.name }}</h2>
            <h2>Place bid</h2>
            <input class="input1" type="number" v-model="quantity" value="1">
            <button class="normal" @click="placeBid(this.item.id)">Place Bid</button>
<!--            <button class="normal" @click="addToCart(this.item)">Add to Cart</button>-->
            <h3>Product Details</h3>
            <p><strong>Starting Bid: $</strong> {{ item.starting_bid }}</p>
            <p><strong>Start date: {{ item.start_time}}</strong></p>
            <p><strong>End date: {{ item.end_time}}</strong></p>
            <span class="gcardt">{{ item.description }}.</span>
        </div>
    </section>
    <p v-else>Loading product details...</p>
</template>


<script>
export default {
    // props: ['item'], // Make sure to pass `product` as a prop
    props: {
        item: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            bidAmount: 1, // Default bid amount
        };
    },
    methods: {
        async placeBid(itemId) {
            console.log("Full item object:", this.item); // Debugging
            console.log("Placing bid for item ID:", itemId);
            try {
                const response = await axios.post(`/place-bid/${itemId}`, {
                    bid_amount: this.bidAmount,
                    itemId: itemId,
                });
                // alert('Bid placed successfully');
                console.log('Bid Response:', response.data);
            } catch (error) {
                if (error.response && error.response.status === 401) {
                    alert('You must be logged in to place a bid');
                    console.log('You must be logged in to place a bid');
                } else {
                    console.log('Error placing bid');
                }
            }
        }
    }
};

</script>


<style scoped>

/* product */
#productdetails {
    display: flex;
    margin-top: 110px;
    margin-bottom: 110px;
    justify-content: center;
    align-items: center;
    width: 80%;
    max-width: 1200px;
    padding: 50px;
    box-sizing: border-box;
    /* left: 100px; */
    left: 15%;
    position: relative;
}

.single-pro-image {
    justify-content: center;
    align-items: center;
}

#productdetails .single-pro-image{
    width: 40%;
    margin-right: 50px;
}

.small-image-group {
    display: flex;
    justify-content: space-between;
}

.small-img-col {
    flex-basis: 24%;
    cursor: pointer;
}

#productdetails .single-pro-details {
    width: 50%;
    padding-top: 30px;
}

#productdetails .single-pro-details h4 {
    padding: 40px 0 20px 0;
    font-weight: 700;
}

#productdetails .single-pro-details h2 {
    font-size: 26px;
    font-weight: 700;
}

#productdetails .single-pro-details select {
    display: block;
    padding: 5px 10px;
    margin-bottom: 10px;
}

#productdetails .single-pro-details input {
    width: 50px;
    height: 47px;
    padding-left: 10px;
    font-size: 16px;
    margin-right: 10px;
}

#productdetails .single-pro-details button {
    background-color: #7a3a7b;
    color: #e8e8e8;
    border-radius: 5px;
    padding: 5px 15px;
}

#productdetails .single-pro-details input:focus {
    outline: none;
}

#productdetails .single-pro-details span {
    line-height: 25px;
}

.gcardt {
    animation: animt 5s ease-in-out infinite;
}

@keyframes animt {
    0% {
        color: #9a73a1;
    }

    50% {
        color: #8b2c84;
    }

    100% {
        color: #5c0a55;
    }
}

/* product */


/* product */
@media (max-width: 768px) {
    #productdetails {
        display: flex;
        flex-direction: column;
    }

    #productdetails .single-pro-image {
        width: 100%;
        margin-right: 0px;
    }

    #productdetails .single-pro-details {
        width: 100%;
    }
}
/* product */

</style>
