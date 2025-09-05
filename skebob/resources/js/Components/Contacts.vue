<template>
    <section class="contact-section">
        <h1 class="aboutus">Contacts</h1>
        <div class="contact-container">
            <div class="contact-box">
                <img src="/images/front/online_store_icon.png" alt="Online Store Icon">
                <h3>Online Store</h3>
                <p><a href="">www.comtem.com</a></p>
                <p>Phone: <a href="tel:+37166778899">+371 66778899</a></p>
                <p>Email: <a href="mailto:info@comtem.com">info@comtem.com</a></p>
                <p>Working Days: 09:00 – 18:00</p>
                <p>Saturday: 09:00 – 16:00</p>
                <p>Sunday: 09:00 – 16:00</p>
            </div>
            <div class="contact-box">
                <img src="/images/front/customer_service_icon.png" alt="Customer Service Icon">
                <h3>Customer Service</h3>
                <p>Support and Warranty Cases</p>
                <p>Phone: <a href="tel:+37166165555">+371 66165555</a></p>
                <p>Email: <a href="mailto:clientservis@comtem.com">clientservis@comtem.com</a></p>
                <p>Working Days: 10:00 – 17:00</p>
                <p>Saturday: Closed</p>
                <p>Sunday: Closed</p>
            </div>
            <div class="contact-box">
                <img src="/images/front/company_icon.png" alt="Company Icon">
                <h3>SIA "MK Trade"</h3>
                <p>Registration Info</p>
                <p>Office Address: RVT, Riga</p>
                <p>Registration No.: 40100099980</p>
                <p>VAT: LV40103299000</p>
            </div>
            <div class="contact-box">
                <img src="/images/front/procurement_icon.png" alt="Procurement Icon">
                <h3>Procurement</h3>
                <p>For purchases, tenders, price inquiries</p>
                <p>Email: <a href="mailto:comtem@gmail.com">comtem@gmail.com</a></p>
            </div>
        </div>
    </section>
</template>




<style scoped>
.contact-section {
    max-width: 1200px;
    margin: 0 auto;
    text-align: center;
}

.contact-section h1 {
    font-size: 36px;
    margin-bottom: 20px;
}

.contact-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Two columns for the table-like layout */
    gap: 20px;
    margin-top: 20px;
}

.contact-box {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: left;
}

.contact-box img {
    display: block;
    margin: 0 auto 10px auto;
    width: 50px;
}

.contact-box h3 {
    font-size: 24px;
    margin-bottom: 10px;
}

.contact-box p {
    margin-bottom: 8px;
    font-size: 14px;
    color: #555;
}

.contact-box a {
    color: #007bff;
    text-decoration: none;
}

.contact-box a:hover {
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
    .contact-container {
        grid-template-columns: 1fr; /* Single column layout for smaller screens */
    }
}
</style>
