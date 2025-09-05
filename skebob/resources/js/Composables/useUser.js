import { ref, onMounted } from 'vue';
import axios from 'axios';
import * as response from "autoprefixer";

export function useUser() {
    const isLoggedIn = ref(false);
    //const user = ref(null);
    const user = ref(null);
    user.value = response.data.user || null;

    // Fetch login status from the backend
    const checkLoginStatus = async () => {
        try {
            const response = await axios.get('/api/is-logged-in'); // Ensure your backend returns this status
            console.log('API Response:', response.data);
            // console.log("User data", user.value);
            isLoggedIn.value = response.data.isLoggedIn;
            user.value = response.data.user; // Assign user data if available
            //user.value = response.data.user; // Assign user data if logged in
        } catch (error) {
            console.error('Error checking login status:', error);
            isLoggedIn.value = false;
            user.value = null;
        }
    };

    onMounted(() => {
        checkLoginStatus();
    });

    return {
        isLoggedIn,
        user,
    };
}
