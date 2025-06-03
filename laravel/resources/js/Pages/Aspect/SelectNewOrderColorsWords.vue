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

const leftWords = ref(clonedProps.data.words);
const rigthWords = ref(_.cloneDeep(leftWords));

const onStart = (event, index) => {
    event.dataTransfer.dropEffect = "move";
    event.dataTransfer.effectAllowed = "move";
    event.dataTransfer.setData("index", index);
};
const onDrop = (event, replaceIndex) => {
    const temp = leftWords.value[replaceIndex];
    const draggalbeIndex = Number(event.dataTransfer.getData("index"));
    const draggableWord = leftWords.value[draggalbeIndex];
    leftWords.value[replaceIndex] = draggableWord;
    leftWords.value[draggalbeIndex] = temp;
};
</script>

<template>
    <div class="aspect-frame">

        <Head :title="title" />
        <h2>
            {{ title }}
        </h2>
        <div style="display: flex; flex-direction: row; gap: 1rem">
            <div id="left" class="word-colors-box">
                <div :style="['background-color: ' + word.colorCode]"
                    class="color-box"
                    v-for="(word, index) in leftWords" :key="word.id"
                    draggable="true"
                    @dragstart="onStart($event, index)"
                    @drop="onDrop($event, index)"
                    @dragenter.prevent
                    @dragover.prevent>
                </div>
            </div>
            <div id="right" class="shape-colors-box">
                <div class="color-box"
                    :style="['background-color: ' + word.shapeColorCode]"
                    v-for="word in rigthWords" :key="word.id">
                </div>
            </div>
        </div>
        <NextStep :aspect_data="leftWords" :aspect_id="clonedProps.aspect_id" />
    </div>
</template>


<style lang="scss" scoped>
.word-colors-box {
    >div {
        cursor: pointer;
    }
}

.color-box {
    width: 30px;
    height: 40px;
    border: 1px solid gray;
    margin-bottom: 5px;
}
</style>
