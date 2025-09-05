<template>
    <div class="quiz-container">
        <h2>PC Components Quiz</h2>
        <div>
<!--            v-if="!quizCompleted"-->
            <div v-for="(question, index) in questions" :key="index" class="question">
                <p>{{ index + 1 }}. {{ question.text }}</p>
                <div class="options">
                    <button
                        v-for="(option, optionIndex) in question.options"
                        :key="optionIndex"
                        @click="selectAnswer(index, optionIndex)"
                        :class="{ selected: userAnswers[index] === optionIndex }"
                    >
                        {{ option }}
                    </button>
                </div>
            </div>
            <button @click="submitQuiz" class="submit-btn">Submit Quiz</button>
        </div>
<!--        <div v-else>-->
        <h3>Your Score: {{ score }} / {{ questions.length }}</h3>
        <button @click="restartQuiz" class="restart-btn">Try Again</button>
<!--        </div>-->
    </div>
</template>

<script>
export default {
    data() {
        return {
            questions: [
                { text: "Which component is considered the 'brain' of a computer?", options: ["RAM", "GPU", "CPU", "SSD"], answer: 2 },
                { text: "Which of the following stores the operating system and files permanently?", options: ["RAM", "HDD/SSD", "PSU", "CPU"], answer: 1 },
                { text: "What does GPU stand for?", options: ["General Processing Unit", "Graphics Processing Unit", "Gaming Power Unit", "Gigabyte Processing Utility"], answer: 1 },
                { text: "Which component supplies power to all other parts of the PC?", options: ["Motherboard", "CPU", "PSU", "RAM"], answer: 2 },
                { text: "Which type of storage is faster?", options: ["HDD", "SSD", "DVD", "USB Flash Drive"], answer: 1 },
                { text: "What is the main function of the motherboard?", options: ["To power the system", "To store data", "To connect components", "To cool the system"], answer: 2 },
                { text: "Which component affects gaming performance the most?", options: ["CPU", "GPU", "RAM", "PSU"], answer: 1 },
                { text: "Which of these is a common cooling method for PCs?", options: ["Liquid Cooling", "Air Cooling", "Both A and B", "None of the above"], answer: 2 }
            ],
            userAnswers: Array(8).fill(null),
            quizCompleted: false,
            score: 0,
        };
    },
    methods: {
        selectAnswer(questionIndex, optionIndex) {
            this.userAnswers[questionIndex] = optionIndex;
        },
        submitQuiz() {
            this.score = this.userAnswers.reduce((acc, answer, index) => {
                return answer === this.questions[index].answer ? acc + 1 : acc;
            }, 0);
            this.quizCompleted = true;
        },
        restartQuiz() {
            this.userAnswers = Array(this.questions.length).fill(null);
            this.quizCompleted = false;
            this.score = 0;
        }
    }
};
</script>

<style scoped>
.quiz-container {
    max-width: 600px;
    justify-self: center;
    align-self: center;
    padding: 20px;
    background: #f4f4f4;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 200px;
}
.question {
    margin-bottom: 15px;
}
.options button {
    display: block;
    width: 100%;
    margin: 5px 0;
    padding: 10px;
    background: #fff;
    border: 1px solid #ccc;
    cursor: pointer;
}
.options button.selected {
    background: #007bff;
    color: white;
}
.submit-btn, .restart-btn {
    margin-top: 20px;
    padding: 10px 20px;
    background: #28a745;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}
.submit-btn:hover, .restart-btn:hover {
    background: #218838;
}
</style>
