<template>
    <div class="pc-calculator">
        <h1 class="h1c">PC Price Calculator</h1>

        <!-- CPU Selection -->
        <div class="component">
            <label for="cpu">CPU:</label>
            <select id="cpu" v-model="selectedComponents.cpu" @change="calculatePrice">
                <option v-for="cpu in components.cpus" :key="cpu.name" :value="cpu">
                    {{ cpu.name }} - ${{ cpu.price }}
                </option>
            </select>
        </div>

        <!-- GPU Selection -->
        <div class="component">
            <label for="gpu">GPU:</label>
            <select id="gpu" v-model="selectedComponents.gpu" @change="calculatePrice">
                <option v-for="gpu in components.gpus" :key="gpu.name" :value="gpu">
                    {{ gpu.name }} - ${{ gpu.price }}
                </option>
            </select>
        </div>

        <!-- RAM Selection -->
        <div class="component">
            <label for="ram">RAM:</label>
            <select id="ram" v-model="selectedComponents.ram" @change="calculatePrice">
                <option v-for="ram in components.rams" :key="ram.name" :value="ram">
                    {{ ram.name }} - ${{ ram.price }}
                </option>
            </select>
        </div>

        <!-- Estimated Price -->
        <div class="price-result">
            <h2>Total Price: ${{ totalPrice }}</h2>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PCPriceCalculator',
    data() {
        return {
            components: {
                cpus: [
                    { name: 'Intel i3-10400', price: 120 },
                    { name: 'Intel i5-12400', price: 200 },
                    { name: 'Intel i7-12700', price: 350 },
                    { name: 'Intel i9-12900K', price: 600 },
                    { name: 'AMD Ryzen 5 5600X', price: 180 },
                    { name: 'AMD Ryzen 7 5800X', price: 300 },
                    { name: 'AMD Ryzen 9 5950X', price: 700 },
                ],
                gpus: [
                    { name: 'NVIDIA GTX 1660', price: 250 },
                    { name: 'NVIDIA RTX 2060', price: 350 },
                    { name: 'NVIDIA RTX 3060', price: 450 },
                    { name: 'NVIDIA RTX 3080', price: 800 },
                    { name: 'NVIDIA RTX 3090', price: 1500 },
                ],
                rams: [
                    { name: '8GB DDR4', price: 50 },
                    { name: '16GB DDR4', price: 90 },
                    { name: '32GB DDR4', price: 160 },
                    { name: '16GB DDR5', price: 120 },
                    { name: '32GB DDR5', price: 200 },
                ],
            },
            selectedComponents: {
                cpu: null,
                gpu: null,
                ram: null,
            },
            totalPrice: 0,
        };
    },
    methods: {
        calculatePrice() {
            const cpuPrice = this.selectedComponents.cpu ? this.selectedComponents.cpu.price : 0;
            const gpuPrice = this.selectedComponents.gpu ? this.selectedComponents.gpu.price : 0;
            const ramPrice = this.selectedComponents.ram ? this.selectedComponents.ram.price : 0;

            this.totalPrice = cpuPrice + gpuPrice + ramPrice;
        },
    },
};
</script>

<style scoped>
.h1c {
    text-align: center;
    font-weight: bold;
    font-size: large;
    margin: 20px;
}

.pc-calculator {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
    border: 2px solid #6a0dad;
    border-radius: 10px;
}

.component {
    margin-bottom: 15px;
}

label {
    margin-right: 10px;
    font-weight: bold;
}

select {
    padding: 5px;
    font-size: 16px;
    width: 200px;
}

.price-result {
    margin-top: 20px;
    font-size: 24px;
    font-weight: bold;
    color: #4CAF50;
    text-align: center;
}
</style>
