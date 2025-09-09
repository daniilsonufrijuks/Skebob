<template>
    <section class="testimonial-section">
        <div class="parent-container">
            <blockquote class="responsive-quote">
                <p>Dear valued customer,<br>
                    We are thrilled to welcome you to Skebob – your ultimate destination for unique and flavorful snacks!
                    Whether you’re craving something sweet, savory, or adventurous, our carefully curated collection is designed to satisfy every taste bud.
                    From rare international treats to exclusive Skibob specialties, we make snacking an experience you’ll love.</p> <cite>Skibob Snack Group</cite>
            </blockquote>
        </div>
    </section>
</template>


<style scoped>

.testimonial-section {
    background-color: #420d65;
    margin-top: 100px;
}

.responsive-quote {
    position: relative;
    margin: 130px 0;
    padding: 40px;
    background-color: #c785d0;
    border-radius: 16px;
}

.responsive-quote::before {
    content: url("data:image/svg+xml,%3Csvg class='quote-svg' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Cpath d='M7.56863 4H4.43137C2.56863 4 1 5.6 1 7.5V10.8C1 12.7 2.56863 14.3 4.43137 14.3H6.78431C7.56863 14.3 8.35294 14 9.03922 13.6V15.7C9.03922 17 8.05882 18 6.78431 18H5.21569C4.62745 18 4.23529 18.4 4.23529 19C4.23529 19.6 4.62745 20 5.21569 20H6.78431C9.13725 20 11 18.1 11 15.7V10V7.5C11 5.6 9.43137 4 7.56863 4Z'%3E%3C/path%3E%3Cpath d='M19.6638 4H16.4299C14.5679 4 13 5.6 13 7.5V10.8C13 12.7 14.5679 14.3 16.4299 14.3H18.7818C19.5658 14.3 20.3497 14 21.0357 13.6V15.7C21.0357 17 20.0557 18 18.7818 18H17.2138C16.6259 18 16.2339 18.4 16.2339 19C16.2339 19.6 16.6259 20 17.2138 20H18.7818C21.1337 20 22.9956 18.1 22.9956 15.7V10V7.5C23.0936 5.6 21.5257 4 19.6638 4Z'%3E%3C/path%3E%3C/svg%3E");
    position: absolute;
    top: -10px;
    left: -10px;
    transform: scale(2);
    opacity: 0.1;
}

.responsive-quote::after {
    content: url("data:image/svg+xml,%3Csvg class='quote-svg' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Cpath d='M7.56863 4H4.43137C2.56863 4 1 5.6 1 7.5V10.8C1 12.7 2.56863 14.3 4.43137 14.3H6.78431C7.56863 14.3 8.35294 14 9.03922 13.6V15.7C9.03922 17 8.05882 18 6.78431 18H5.21569C4.62745 18 4.23529 18.4 4.23529 19C4.23529 19.6 4.62745 20 5.21569 20H6.78431C9.13725 20 11 18.1 11 15.7V10V7.5C11 5.6 9.43137 4 7.56863 4Z'%3E%3C/path%3E%3Cpath d='M19.6638 4H16.4299C14.5679 4 13 5.6 13 7.5V10.8C13 12.7 14.5679 14.3 16.4299 14.3H18.7818C19.5658 14.3 20.3497 14 21.0357 13.6V15.7C21.0357 17 20.0557 18 18.7818 18H17.2138C16.6259 18 16.2339 18.4 16.2339 19C16.2339 19.6 16.6259 20 17.2138 20H18.7818C21.1337 20 22.9956 18.1 22.9956 15.7V10V7.5C23.0936 5.6 21.5257 4 19.6638 4Z'%3E%3C/path%3E%3C/svg%3E");
    position: absolute;
    bottom: -10px;
    right: -10px;
    transform: scale(2) rotate(180deg);
    opacity: 0.1;
}
.responsive-quote p {
    font-size: calc(16px + 0.25vw);
}

.responsive-quote cite {
    font-size: calc(14px + 0.25vw);
}

.parent-container {
    width: 90%;
    max-width: 800px;
    margin: 0 auto;
}

@media (max-width: 500px) {
    .responsive-quote {
        font-size: 1.2em; /* Уменьшаем размер текста на маленьких экранах */
        padding: 15px; /* Уменьшаем отступы */
        margin: 10px;  /* Уменьшаем внешние отступы */
        line-height: 1.4; /* Немного уменьшаем межстрочный интервал */
    }
}
</style>
