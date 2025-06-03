<script setup>
import { Head } from '@inertiajs/vue3';
import NextStep from '../../Components/Aspect/Buttons/NextStep.vue';
import { ref } from 'vue';

const props = defineProps({
    title: String,
    data: Array | Object,
    aspect_id: Number,
});

const selectedWords = ref([])


function addWord(word) {
    const index = selectedWords.value.findIndex((item) => item === word);

    if (selectedWords.value.length > 7) {
        console.log('Перебор слов')
        selectedWords.value.splice(index, 1)
    } else if (index > -1) {
        selectedWords.value.splice(index, 1)
    } else {
        selectedWords.value.push(word);
    }
}

function validate(words) {
    if (words.length < 8) {
        throw new Error('Количество понятий должно ровняться 8')
    }
    return words
}
</script>

<template>

    <Head :title="title" />
    <div class="aspect-frame">
        <h2>
            {{ title }}
        </h2>
        <div class="word-box" v-if="data">
            <div class="left-box">
                <div class="word" @click="addWord(word)" v-for="word in data" :key="word.id">
                    {{ word.name }}
                </div>
            </div>
            <div class="right-box" id="selected-words-box">
                <div class="selected-words">
                    <div @click="addWord(word)" class="word" v-for="(word, index) in selectedWords" :key="index">
                        {{ word.name }}
                    </div>
                </div>
            </div>
        </div>

        <div v-else>
                    Понятий нет в базе данных, либо произошла другая ошибка
        </div>
        <NextStep :validate="validate" :aspect_data="selectedWords" :aspect_id="aspect_id"></NextStep>
    </div>


</template>


<style lang="scss" scoped>
.word-box {
    display: flex;
    flex-direction: row;
    justify-content: center;
    justify-content: space-evenly;
    width: 60%;
}

::-webkit-scrollbar {
    background: $body-background;
}

::-webkit-scrollbar-thumb {
    background: $blue;
    border-radius: 1em;
}

.left-box {
    min-width: 12em;
    max-height: 30em;
    overflow-y: scroll;
    border-radius: 15px;
    background-color: aliceblue;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.right-box {
    min-width: 12em;
    max-height: 30em;
    border-radius: 15px;
    background-color: aliceblue;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    position: sticky;
}

.word {
    cursor: pointer;
    font-size: 18px;
    margin: 0.2em;
    user-select: none;

    justify-content: center;
    display: flex;

    transition: 0.2s ease-in-out;

    &:hover {
        font-size: 22px;
        transition: 0.2s ease-in-out;
    }
}
</style>
