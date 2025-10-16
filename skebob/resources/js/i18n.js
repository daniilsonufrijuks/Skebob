import { createI18n } from 'vue-i18n';

const messages = {
    en: {
        home: 'Home',
        market: 'Market',
        gifts: 'Gifts',
        about: 'About',
        contacts: 'Contacts',
        contact: 'Contact',
        blog: 'Blog',
        sources: 'Sources',
        team: 'Team',
        login: 'Login',
        signup: 'Sign up',
        popularBrands: 'Popular Brands',
        visitFeastables: 'Best feasting chocolate!',
        visitOishi: 'Vietnamese snack special!\n' +
            'Available on website now!',
        visitDoritos: 'Limited Edition Doritos,\n' +
            'don\'t miss \'em!',
        visitSkittles: 'Special discount for a limited period.',
        search: 'Search',
        searching: 'Searching...',
        MysteryBox: '🎁 Mystery Box',
        MysteryBoxText: 'Get exclusive Snacks & Drinks inside every box!',
        visitFeastablesButton: 'Visit feastables.com',
        visitOishiButton: 'Visit oishi.com.vn',
        visitDoritosButton: 'Visit doritos.com',
        visitSkittlesButton: 'Visit skittles.com',
        MysteryBoxShopNow: 'Shop Now',
        TestimonialsTitle: 'What Our Customers Say',
        TestimonialsSubtitle: 'Join thousands of satisfied snack lovers who have discovered ' +
            'their new favorites with Skebob.',
        DearCustomer: 'Dear valued customer,',
        WelcomeText: 'We are thrilled to welcome you to Skebob ' +
            '– your ultimate destination for unique and flavorful snacks! ' +
            'Whether you\'re craving something sweet, savory, or adventurous, ' +
            'our carefully curated collection is designed to satisfy every taste bud. ' +
            'From rare international treats to exclusive Skebob specialties, ' +
            'we make snacking an experience you\'ll love.',
        SkebobSnackGroup: 'Skebob Snack Group',
        OfficialWelcomeMessage: 'Official Welcome Message',
        snackMap: 'Interactive Snack Map',
        mapDescription: 'Explore the world of international snacks! ' +
            'Click on any country to discover unique treats and flavors from around the globe.',
        MapHeading: 'World Snack Origins',
        MapSubtitle: 'Click on any country marker to explore their signature snacks',
        CountriesExplored: 'Countries Explored',
        UniqueSnacks: 'Unique Snacks',
        Continents: 'Continents',
        FlavorAdventures: 'Flavor Adventures',
        commentsTitle: 'Comments',
        commentsWritePlaceholder: 'Write a comment...',
        commentsSubmitting: 'Submitting...',
        commentsSubmit: 'Submit',
        loginPrompt: 'Please log in to leave a comment.',
        CommentsError: 'Error:',
        CommentsRetry: 'Retry',
        LoadingComments: 'Loading Comments...',
        NoCommentsYet: 'No comments yet. Be the first to comment!',

        // ...add more keys
    },
    lv: {
        home: 'Sākums',
        market: 'Tirgus',
        gifts: 'Dāvanas',
        about: 'Par mums',
        contacts: 'Kontakti',
        contact: 'Kontaktēt',
        blog: 'Blogs',
        sources: 'Avoti',
        team: 'Komanda',
        login: 'Pieslēgties',
        signup: 'Reģistrēties',
        popularBrands: 'Populārās Firmas',
        visitFeastables: 'Vislabākā mielasta šokolāde!',
        visitOishi: 'Vjetnamiešu uzkodas īpašais!\n' +
            'Pieejams mājaslapā jau tagad!',
        visitDoritos: 'Ierobežota izdevuma Doritos,\n' +
            'Nepalaidiet tos garām!',
        visitSkittles: 'Īpaša atlaide ierobežotu laiku.',
        search: 'Meklēt',
        searching: 'Meklē...',
        MysteryBox: '🎁 Noslēpumu kaste',
        MysteryBoxText: 'Katrā kastītē saņemiet ekskluzīvas uzkodas un dzērienus!',
        visitFeastablesButton: 'Apmkelējiet feastables.com',
        visitOishiButton: 'Apmkelējiet oishi.com.vn',
        visitDoritosButton: 'Apmkelējiet doritos.com',
        visitSkittlesButton: 'Apmkelējiet skittles.com',
        MysteryBoxShopNow: 'Iepirkties tagad',
        TestimonialsTitle: 'Ko mūsu klienti saka',
        TestimonialsSubtitle: 'Pievienojies tūkstošiem apmierinātu uzkodu cienītāju, ' +
            'kuri ir atklājuši savus jaunos favorītus kopā ar Skebob.',
        DearCustomer: 'Cienījamais klient,',
        WelcomeText: 'Ar prieku sveicam jūs Skebob vietnē – ' +
            'Jūsu galvenajā unikālu un aromātisku uzkodu galamērķī! ' +
            'Neatkarīgi no tā, vai kārojat ko saldu, sāļu vai piedzīvojumiem bagātu, ' +
            'mūsu rūpīgi atlasītā kolekcija ir radīta, lai apmierinātu ikvienas garšas kārpiņas. ' +
            'Sākot ar retiem starptautiskiem gardumiem un beidzot ar ekskluzīviem ' +
            'Skebob ēdieniem, mēs padarām uzkodas par pieredzi, kas jums patiks.',
        SkebobSnackGroup: '"Skebob" uzkodu grupa',
        OfficialWelcomeMessage: 'Oficiālais sveiciena ziņojums',
        snackMap: 'Interaktīvā našķu karte',
        mapDescription: 'Iepazīsties ar starptautisko uzkodu pasauli! Noklikšķiniet uz ' +
            'jebkuras valsts, lai atklātu unikālus gardumus un garšas no visas pasaules.',
        MapHeading: 'Pasaules uzkodu izcelsmes',
        MapSubtitle: 'Noklikšķiniet uz jebkuras valsts marķiera, lai izpētītu viņu raksturīgās uzkodas.',
        CountriesExplored: 'Apmeklētas valstis',
        UniqueSnacks: 'Unikālie našķi',
        Continents: 'Kontinenti',
        FlavorAdventures: 'Garšu piedzīvojumi',
        commentsTitle: 'Komentāri',
        commentsWritePlaceholder: 'Uzraksti komentāru...',
        commentsSubmitting: 'Iesniedz...',
        commentsSubmit: 'Iesniegt',
        loginPrompt: 'Lūdzu piesakieties, lai atstātu komentāru.',
        CommentsError: 'Kļūda:',
        CommentsRetry: 'Mēģināt vēlreiz',
        LoadingComments: 'Lādē komentārus...',
        NoCommentsYet: 'Nav pagaidām komentāru. Esi pirmais, lai komentētu!',
        // ...add more keys
    }
};

export default createI18n({
    locale: localStorage.getItem('lang') || 'en',
    fallbackLocale: 'en',
    messages,
});
