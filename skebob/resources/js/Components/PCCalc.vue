<template>
    <div class="pc-calculator">
        <h1 class="h1c">PC FPS Calculator</h1>

        <!-- CPU Selection -->
        <div class="component">
            <label for="cpu">CPU:</label>
            <select id="cpu" v-model="selectedComponents.cpu" @change="calculateFPS">
                <option v-for="cpu in components.cpus" :key="cpu.name" :value="cpu">
                    {{ cpu.name }}
                </option>
            </select>
        </div>

        <!-- GPU Selection -->
        <div class="component">
            <label for="gpu">GPU:</label>
            <select id="gpu" v-model="selectedComponents.gpu" @change="calculateFPS">
                <option v-for="gpu in components.gpus" :key="gpu.name" :value="gpu">
                    {{ gpu.name }}
                </option>
            </select>
        </div>

        <!-- RAM Selection -->
        <div class="component">
            <label for="ram">RAM:</label>
            <select id="ram" v-model="selectedComponents.ram" @change="calculateFPS">
                <option v-for="ram in components.rams" :key="ram.name" :value="ram">
                    {{ ram.name }}
                </option>
            </select>
        </div>

        <!-- Estimated FPS -->
        <div class="fps-result">
            <h2>Estimated FPS: {{ estimatedFPS }}</h2>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PCCalculator',
    data() {
        return {
            components: {
                cpus: [
                    { name: 'Intel i3-10400', score: 300 },
                    { name: 'Intel i5-12400', score: 700 },
                    { name: 'Intel i7-12400', score: 900 },
                    { name: 'Intel i9-12400', score: 1400 },
                    { name: 'AMD Ryzen 5 5600X', score: 600 },
                    { name: 'AMD Ryzen 7 6600X3D', score: 1000 },
                    { name: 'AMD Ryzen 9 7600X3D', score: 1600 },
                ],
                gpus: [
                    { name: 'NVIDIA GTX 1660', score: 300 },
                    { name: 'NVIDIA GTX 1080', score: 500 },
                    { name: 'NVIDIA RTX 2070', score: 600 },
                    { name: 'NVIDIA RTX 3060', score: 600 },
                    { name: 'NVIDIA RTX 3080', score: 800 },
                    { name: 'NVIDIA RTX 3080 TI', score: 1200 },
                    { name: 'NVIDIA RTX 3070', score: 650 },
                    { name: 'NVIDIA RTX 3090', score: 1400 },
                ],
                rams: [
                    { name: '8GB DDR4', score: 100 },
                    { name: '8GB DDR5', score: 300 },
                    { name: '16GB DDR4', score: 200 },
                    { name: '16GB DDR5', score: 400 },
                    { name: '32GB DDR4', score: 300 },
                    { name: '64GB DDR4', score: 400 },
                    { name: '32GB DDR5', score: 600 },
                ],
            },
            selectedComponents: {
                cpu: null,
                gpu: null,
                ram: null,
            },
            estimatedFPS: 0,
        };
    },
    methods: {
        calculateFPS() {
            if (this.selectedComponents.cpu && this.selectedComponents.gpu && this.selectedComponents.ram) {
                const cpuScore = this.selectedComponents.cpu.score;
                const gpuScore = this.selectedComponents.gpu.score;
                const ramScore = this.selectedComponents.ram.score;

                // Simple FPS calculation formula (can be more complex)
                this.estimatedFPS = Math.round((cpuScore + gpuScore + ramScore) / 10);
            } else {
                this.estimatedFPS = 0;
            }
        },
    },
};
</script>


<style scoped>
.h1c {
    align-self: center;
    justify-self: center;
    font-weight: bold;
    font-size: large;
    margin: 20px;
}

.pc-calculator {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
    border-style: solid;
    border-width: 2px;
    border-color: #6a0dad;
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

.fps-result {
    margin-top: 20px;
    font-size: 24px;
    font-weight: bold;
    color: #4CAF50;
    text-align: center;
}
</style>

