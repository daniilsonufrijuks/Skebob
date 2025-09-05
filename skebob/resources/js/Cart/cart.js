
import { createStore } from 'vuex';

const store = createStore({
    state: {
        cart: JSON.parse(localStorage.getItem('cart')) || [], // Array to store cart items
    },
    // state: {
    //     cart: [
    //         {
    //             id: 1,
    //             name: 'Sample Product',
    //             description: 'This is a test product.',
    //             price: 100,
    //             quantity: 2,
    //             image: '/path/to/image.jpg',
    //         },
    //     ],
    //},
    mutations: {
        ADD_TO_CART(state, product) {
            // Check if the product already exists in the cart
            // const existingProduct = state.cart.find((item) => item.id === product.id);
            //
            // if (existingProduct) {
            //     // If product exists, just update the quantity
            //     existingProduct.quantity += product.quantity;
            // } else {
            //     // If the product doesn't exist, add a new item to the cart
            //     state.cart.push({ ...product, quantity: product.quantity || 1 });
            // }
            state.cart.push({ ...product, quantity: product.quantity || 1 });


            // Save updated cart to localStorage
            localStorage.setItem('cart', JSON.stringify(state.cart));
        },

        // REMOVE_FROM_CART(state, productId) {
        //     state.cart = state.cart.filter((item) => item.id !== productId);
        //     localStorage.setItem('cart', JSON.stringify(state.cart));
        // },

        CLEAR_CART(state) {
            state.cart = [];
            localStorage.setItem('cart', JSON.stringify(state.cart));
        },
    },
    getters: {
        cartItems: (state) => state.cart,
        cartTotal: (state) =>
            state.cart.reduce((total, item) => total + item.price * item.quantity, 0),
    },
});

export default store;
