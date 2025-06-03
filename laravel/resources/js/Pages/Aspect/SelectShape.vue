<script setup>
import { Head } from "@inertiajs/vue3";
import NextStep from "@/Components/Aspect/Buttons/NextStep.vue";
import { ref, onMounted, computed } from "vue";
import _ from "lodash";

const props = defineProps({
    title: String,
    data: Array | Object,
    aspect_id: Number,
});

const clonedProps = _.cloneDeep(props);

const shape_categories = ref(clonedProps.data.shape_categories);
const words = ref(clonedProps.data.words);

const activeCategory = ref(1);
const setActiveCategory = (categoryId) => {
    activeCategory.value = categoryId;
};

// color code is $blue
let activeCategoryStyle = "border-bottom: solid 4px rgba(193, 218, 253, 1)";
const shapeImgElement = ref();
const shapeSlotElement = ref();
onMounted(() => {
    /**
     * get proportions from source shape element for slot
     */
    const { width, height } = shapeImgElement.value[0].getBoundingClientRect();
    shapeSlotElement.value.forEach((element) => {
        element.style.width = `${width + 4}px`;
        element.style.height = `${height + 4}px`;
    });
});

const getActiveCategoryIndex = computed(() => {
    return shape_categories.value.findIndex(
        (category) => category.id === activeCategory.value
    );
});

const getActiveShapes = computed(() => {
    return shape_categories.value.find(
        (category) => category.id === activeCategory.value
    ).shapes;
});

/**
 * Draggable-------------
 */

const slots = ref(Array(8).fill(null));

const onStartShapes = (event, shape) => {
    event.dataTransfer.dropEffect = "move";
    event.dataTransfer.effectAllowed = "move";
    event.dataTransfer.setData("itemId", shape.id);
};

function swapSlots(dragged, repleceable) {
    const temp = slots.value[repleceable];
    words.value[repleceable].shapeId = slots.value[dragged].id;
    words.value[dragged].shapeId = temp.id;
    slots.value[repleceable] = slots.value[dragged];
    slots.value[dragged] = temp;
}

function returnShape(slotIndex) {
    const slot = slots.value[slotIndex];
    if (slot !== null) {
        shape_categories.value
            .find((category) => category.id === slot.a_shape_category_id)
            .shapes.push(slot);
    }
    return;
}
const onStartSlots = (event, dragIndex) => {
    event.dataTransfer.dropEffect = "move";
    event.dataTransfer.effectAllowed = "move";
    event.dataTransfer.setData("dragIndex", dragIndex);
};

const onDrop = (event, slotIndex) => {
    const itemId = Number(event.dataTransfer.getData("itemId"));
    if (itemId) {
        returnShape(slotIndex);
        const item = getActiveShapes.value.find((shape) => shape.id === itemId);
        slots.value[slotIndex] = item;
        words.value[slotIndex].shapeId = item.id;
        shape_categories.value[getActiveCategoryIndex.value].shapes =
            shape_categories.value[getActiveCategoryIndex.value].shapes.filter(
                (shape) => shape.id !== itemId
            );
        return;
    } else {
        const dragIndex = Number(event.dataTransfer.getData("dragIndex"));
        if (dragIndex === null) {
            throw new Error("Идентификатор перемещаемого слота пустой");
        }
        swapSlots(dragIndex, slotIndex);
    }
};

function validate(result) {
    if (result.some((item) => item.shapeId === null)) {
        throw new Error("Результат имеет пустую ячейку");
    }
    return result;
}
</script>

<template>
    <div class="aspect-frame">

        <Head :title="title"></Head>

        <h2>
            {{ title }}
        </h2>
        <div class="shape-slots">
            <div class="shape-container" v-for="(slot, index) in slots" :key="slot?.id">
                <div class="shape-slot" ref="shapeSlotElement" @drop="onDrop($event, index)"
                    @dragstart="onStartSlots($event, index)" @dragenter.prevent @dragover.prevent>
                    <div v-if="slot === null"></div>
                    <img v-if="slot && slot.filepath" class="shape" ref="shapeImgElement" alt=""
                        :src="'/' + slot.filepath" />
                </div>
                <div class="word">
                    {{ words[index].name }}
                </div>
            </div>
        </div>
        <div class="tabs-rows">
            <div class="category-tab" @click="setActiveCategory(shape_category.id)"
                v-for="shape_category in shape_categories" :key="shape_category.id">
                <h3 id="get-style" :style="[
                    activeCategory === shape_category.id
                        ? activeCategoryStyle
                        : '',
                ]">
                    {{ shape_category.name }}
                </h3>
            </div>
        </div>
        <div class="grid-shapes">
            <div class="shape" v-for="shape in getActiveShapes" draggable="true"
                @dragstart="onStartShapes($event, shape)" :key="shape.id">
                <img class="shape" ref="shapeImgElement" alt="some image" :src="'/' + shape.filepath" />
            </div>
        </div>

        <NextStep :validate="validate" :aspect_data="words" :aspect_id="props.aspect_id" />
    </div>
</template>

<style lang="scss" scoped>
.tabs-rows {
    display: flex;
    flex-direction: row;
}

.category-tab {
    display: flex;
    flex-direction: column;
    padding: 0.5rem;
    margin: 0px 2px;
    cursor: pointer;
}

.shape {
    width: 90;
    height: 90;
    cursor: pointer;
}

.grid-shapes {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.shape-slots {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 2rem;
    width: 98%;
    justify-content: center;

    .shape-container {
        margin: 1rem 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: $blue-light;
    }

    .shape-slot {
        background-color: $body-background;
        margin: 1rem 4px;
        border: 2px solid rgba($color: $blue-gray-hover, $alpha: 1);
    }
}
</style>
