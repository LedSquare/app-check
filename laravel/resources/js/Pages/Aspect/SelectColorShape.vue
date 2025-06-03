<script setup>
import { Head } from "@inertiajs/vue3";
import NextStep from "@/Components/Aspect/Buttons/NextStep.vue";
import ShapeModal from "../../Components/Aspect/Modals/ShapeColorModal.vue";
import { ref } from "vue";
import _ from "lodash";

const props = defineProps({
    title: String,
    data: Array | Object,
    aspect_id: Number,
});

const clonedProps = _.cloneDeep(props);
const modalSwitch = ref(false);
const selectedWord = ref(null);

const words = ref(clonedProps.data.words);
const colors = ref(clonedProps.data.colors);
const shapes = ref(clonedProps.data.shapes);

const findShape = (word) => {
    if (word === null) return null;

    return shapes.value.find((shape) => shape.id === word.shapeId);
};

const select = (word) => {
    if (word.shapeColorCode !== null) {
        return;
    }
    selectedWord.value = word;
    modalSwitch.value = !modalSwitch.value;
};

const offModal = () => {
    modalSwitch.value = !modalSwitch.value;
};

const setColor = (wordId, emitColor) => {
    const word = words.value.find((word) => word.id === wordId);
    word.shapeColorCode = emitColor.hex_code;

    colors.value = colors.value.filter((color) => color.id !== emitColor.id);
    offModal();
};

const dynamicStyles = (word) => {
    return {
        background: word.shapeColorCode ?? "",
        cursor: word.shapeColorCode ? "default" : "pointer",
    };
};

function validate(result) {
    if (result.some((item) => item.shapeColorCode === null)) {
        throw new Error("Один или несколько симоволов не окрашены");
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
        <ShapeModal
            :modalSwitch="modalSwitch"
            :colors="colors"
            :word="selectedWord"
            :shape="findShape(selectedWord)"
            @offModal="offModal"
            @selectColor="setColor"
        />
        <div class="shape-slots">
            <div class="shape-slot" v-for="word in words" :key="word.id">
                <img
                    v-if="findShape(word)"
                    @click="select(word)"
                    :style="dynamicStyles(word)"
                    class="shape"
                    alt=""
                    :src="'/' + findShape(word).filepath"
                />
                <div v-else>?</div>
            </div>
        </div>
        <NextStep
            :validate="validate"
            :aspect_data="words"
            :aspect_id="props.aspect_id"
        ></NextStep>
    </div>
</template>

<style lang="scss" scoped>
.shape {
    width: 90;
    height: 90;
    cursor: pointer;
}

.shape-slots {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 2rem;

    .shape-slot {
        background-color: $body-background;
        margin: 1rem 4px;
        border: 2px solid rgba($color: $blue-gray-hover, $alpha: 1);
    }
}
</style>
