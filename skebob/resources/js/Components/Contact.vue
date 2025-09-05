
<script setup>
import { ref } from 'vue';
import axios from 'axios';
import {route} from "ziggy-js";
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    //subject: '',
    body: '',
});

const submit = () => {
    form.post(route('contact'), {

    });
};
</script>


<template>

    <!-- contact section -->
    <section class="contact_section ">
        <div class="container container-bg">
            <div class="row">
                <div class="col-lg-7 col-md-6 px-0">
                    <div class="map_container">
                        <div class="map-responsive">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2175.752002814705!2d24.101903377117267!3d56.95305007355204!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46eecf7bac058ce9%3A0x96a8a0e931b27448!2z0KDQuNC20YHQutC40Lkg0LPQvtGB0YPQtNCw0YDRgdGC0LLQtdC90L3Ri9C5INGC0LXRhdC90LjQutGD0Lw!5e0!3m2!1sru!2slv!4v1725731560133!5m2!1sen!2slv"  width="600" height="300" frameborder="0" style="border:0; width: 100%; height:100%" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 px-0">
                    <form @submit.prevent="submit">
                        <div>
                            <input v-model="form.name" type="text" name="name" placeholder="Name" required />
                        </div>
                        <div>
                            <input v-model="form.email" type="email" name="email" placeholder="Email" required />
                        </div>
<!--                        <div>-->
<!--                            <input v-model="form.subject" type="text" name="subject" placeholder="Phone" required />-->
<!--                        </div>-->
                        <div>
                            <textarea v-model="form.body" name="message" class="message-box" placeholder="Message" required ></textarea>
                        </div>
                        <div class="d-flex">
                            <button type="submit">SEND</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.contact_section {
    position: relative;
    padding-top: 50px;
    padding-bottom: 290px;
}

.contact_section .container-bg {
    -webkit-box-shadow: 0 0 25px 0 rgba(0, 0, 0, 0.1);
    box-shadow: 0 0 25px 0 rgba(0, 0, 0, 0.1);
}

.contact_section .heading_container {
    margin-bottom: 30px;
}

.contact_section .row {
    -webkit-box-align: stretch;
    -ms-flex-align: stretch;
    align-items: stretch;
}

.contact_section form {
    padding-right: 35px;
    padding: 45px 20px;
}

.contact_section input {
    width: 100%;
    border: 1px solid #919191;
    height: 50px;
    margin-bottom: 25px;
    padding-left: 25px;
    background-color: transparent;
    outline: none;
    color: #101010;
}

.contact_section input::-webkit-input-placeholder {
    color: #131313;
}

.contact_section input:-ms-input-placeholder {
    color: #131313;
}

.contact_section input::-ms-input-placeholder {
    color: #131313;
}

.contact_section input::placeholder {
    color: #131313;
}

.contact_section input.message-box {
    height: 120px;
}

.contact_section button {
    display: inline-block;
    padding: 12px 45px;
    background-color: #420d65;
    color: #ffffff;
    border: 1px solid #420d65;
    border-radius: 0;
    -webkit-transition: all .3s;
    transition: all .3s;
    display: block;
    color: #fff;
    margin: 35px auto 0 auto;
}

.contact_section button:hover {
    background-color: transparent;
    color: #420d65;
}

.contact_section .map_container {
    height: 100%;
    min-height: 375px;
}

.contact_section .map_container .map-responsive {
    height: 100%;
}

</style>
