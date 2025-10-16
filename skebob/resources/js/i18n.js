import { createI18n } from 'vue-i18n';

const messages = {
    en: {
        home: 'Home',
        market: 'Market',
        gifts: 'Gifts',
        about: 'About',
        contacts: 'Contacts',
        blog: 'Blog',
        login: 'Login',
        signup: 'Sign up',
        // ...add more keys
    },
    lv: {
        home: 'Sākums',
        market: 'Tirgus',
        gifts: 'Dāvanas',
        about: 'Par mums',
        contacts: 'Kontakti',
        blog: 'Blogs',
        login: 'Pieslēgties',
        signup: 'Reģistrēties',
        // ...add more keys
    }
};

export default createI18n({
    locale: localStorage.getItem('lang') || 'en',
    fallbackLocale: 'en',
    messages,
});
