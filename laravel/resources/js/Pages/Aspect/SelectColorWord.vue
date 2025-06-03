<script setup>
import { Head } from "@inertiajs/vue3";
import NextStep from "@/Components/Aspect/Buttons/NextStep.vue";
import WordModal from "@/Components/Aspect/Modals/WordColorModal.vue";
import { ref } from "vue";
import _ from "lodash";

const props = defineProps({
    title: String,
    data: Array | Object,
    aspect_id: Number,
});

const clonedProps = _.cloneDeep(props);

const deletedColors = ref([]);
const modalSwitch = ref(false);
const clickedWord = ref(null);

const emit = defineEmits(["rollIndexInModal"]);

const clickWord = (word) => {
    if (word.colorCode !== null) {
        return;
    }

    modalSwitch.value = !modalSwitch.value;
    clickedWord.value = word;
};

const offModal = () => {
    modalSwitch.value = false;
};

const setColorOfWord = (emitWord, emitColor) => {
    modalSwitch.value = false;

    const word = props.data.words.find((word) => word.id === emitWord.id);
    word.colorCode = emitColor.hex_code;

    const findedColor = props.data.colors.find(
        (color) => color.id === emitColor.id
    );
    deletedColors.value.push(findedColor);
    props.data.colors = props.data.colors.filter(
        (color) => color.id !== findedColor.id
    );
};

function validate(result) {
    if (result.some((item) => item.colorCode === null)) {
        throw new Error("Одно или несколько понятий не окрашены");
    }
    return;
}
</script>
<template>
    <div class="aspect-frame">
        <Head :title="title" />
        <h2>
            {{ title }}
        </h2>
        <WordModal
            :modalSwitch="modalSwitch"
            :colors="props.data.colors"
            :word="clickedWord"
            @offModal="offModal"
            @selectColor="setColorOfWord"
        />
        <div class="word-color-box">
            <div
                @click="clickWord(word)"
                class="word"
                v-for="word in data.words"
                :key="word.id"
            >
                <div
                    :style="[
                        'color: ' +
                            (word.colorCode
                                ? word.colorCode + '; cursor: default'
                                : 'white'),
                    ]"
                >
                    {{ word.name }}
                </div>
            </div>
        </div>
        <NextStep
            :validate="validate"
            :aspect_data="props.data.words"
            :aspect_id="props.aspect_id"
        ></NextStep>
    </div>
</template>

<style lang="scss" scoped>
.word-color-box {
    min-width: 12em;
    max-height: 30em;
    border-radius: 15px;
    background-color: aliceblue;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    margin: 2em;
}

.word {
    color: white;
    font-size: 25px;
    font-weight: bold;
    margin: 0.2em;
    user-select: none;
    text-shadow: 0 0 2px black;

    justify-content: center;
    display: flex;

    border-bottom: solid 4px aliceblue;

    transition: 0.2s ease-in-out;

    &:hover {
        border-bottom: solid 4px white;
        transition: 0.2s ease-in-out;
    }

    > div {
        cursor: pointer;
    }
}
</style>
