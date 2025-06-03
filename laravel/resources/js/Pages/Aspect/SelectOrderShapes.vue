<script setup>
import { Head } from '@inertiajs/vue3'
import NextStep from '@/Components/Aspect/Buttons/NextStep.vue'
import { ref } from 'vue'
import _ from 'lodash'


const props = defineProps({
    title: String,
    data: Array | Object,
    aspect_id: Number,
});

const clonedProps = _.cloneDeep(props)

const words = ref(clonedProps.data.words)
const shapes = ref(clonedProps.data.shapes)

const onStart = (event, index) => {
    event.dataTransfer.dropEffect = 'move'
    event.dataTransfer.effectAllowed = 'move'
    event.dataTransfer.setData('index', index)
}

const onDrop = (event, replaceIndex) => {
    const temp = words.value[replaceIndex]
    const draggalbeIndex = Number(event.dataTransfer.getData('index'))
    const draggableWord = words.value[draggalbeIndex]
    words.value[replaceIndex] = draggableWord
    words.value[draggalbeIndex] = temp
}


const findShape = (word) => {
    return shapes.value.find(shape => shape.id === word.shapeId)
}

</script>

<template>

    <Head :title="title"></Head>

    <div class="aspect-frame">
        <h2>
            {{ title }}
        </h2>
        <div class="shape-slots">
            <div class="shape-container" v-for="(word, index) in words" :key="word.id">
                <div class="shape-slot" ref="shapeSlotElement" @dragstart="onStart($event, index)"
                    @drop="onDrop($event, index)" @dragenter.prevent @dragover.prevent>
                    <img v-if="findShape(word)" class="shape" ref="shapeImgElement" alt=""
                        :src="'/' + findShape(word).filepath">
                    <div v-else> ? </div>
                </div>
            </div>
        </div>

        <NextStep :aspect_data="words" :aspect_id="props.aspect_id" />

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

    .shape-container {
        margin: 1rem 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: $blue-light;
    }

    .shape-slot {
        background-color: $body-background;
        margin: 1rem 4px;
        border: 2px solid rgba($color: $blue-gray-hover, $alpha: 1.0)
    }
}
</style>
