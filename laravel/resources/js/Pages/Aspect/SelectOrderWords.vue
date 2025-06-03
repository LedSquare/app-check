<script setup>
import { Head } from "@inertiajs/vue3";
import NextStep from "@/Components/Aspect/Buttons/NextStep.vue";
import { ref } from "vue";
import _ from "lodash";

const props = defineProps({
    title: String,
    data: Array | Object,
    aspect_id: Number,
});

const clonedProps = _.cloneDeep(props);

const words = ref(clonedProps.data.words);

const onStart = (event, index) => {
    event.dataTransfer.dropEffect = "move";
    event.dataTransfer.effectAllowed = "move";
    event.dataTransfer.setData("index", index);
};
const onDrop = (event, replaceIndex) => {
    const temp = words.value[replaceIndex];
    const draggalbeIndex = Number(event.dataTransfer.getData("index"));
    const draggableWord = words.value[draggalbeIndex];
    words.value[replaceIndex] = draggableWord;
    words.value[draggalbeIndex] = temp;
};
</script>

<template>
    <div class="aspect-frame">
        <Head :title="title" />
        <h2>
            {{ title }}
        </h2>
        <div class="words">
            <div
                class="word"
                v-for="(word, index) in words"
                :key="word.id"
                draggable="true"
                @dragstart="onStart($event, index)"
                @drop="onDrop($event, index)"
                @dragenter.prevent
                @dragover.prevent
            >
                {{ word.name }}
            </div>
        </div>
        <NextStep :aspect_data="words" :aspect_id="clonedProps.aspect_id" />
    </div>
</template>


<style lang="scss" scoped>
.word {
    display: flex;
    flex-direction: column;
    margin: 0.5rem;
    padding: 0.2rem;
    border: 2px solid rgba($color: $blue-gray-hover, $alpha: 1);
    cursor: pointer;
}
</style>
