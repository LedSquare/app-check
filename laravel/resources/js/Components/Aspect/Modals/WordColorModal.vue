<template>
    <transition name="modal-animation">
        <div v-show="modalSwitch" class="word-modal" @click.self="onOffModal">
            <div class="inner-modal">
                <div class="question">
                    <QuestionIcon/>
                </div>
                <div class="colors">
                    <div class="color" v-for="(color, id) in props.colors"
                        :style="[rollIndex === id ? 'border: solid 2px black;' : '']" :key="color.id">
                        <div :style="['background-color: ' + color.hex_code]" class="color-div">
                        </div>
                    </div>
                </div>
                <div class="word">
                    <div class="word-with-arrows">
                        <div @click="leftRollColor" class="arrow">
                            &#8249
                        </div>
                        <div :key="rollIndex" :style="['color: ' + colors[rollIndex]?.hex_code]" @wheel="onWheel">
                            {{ word?.name }}
                        </div>
                        <div class="arrow" @click="rightRollColor">
                            &#8250
                        </div>
                    </div>
                </div>
                <div class="button-box">
                    <button class="color-button" @click="onSelectColor(word, colors[rollIndex])">
                        Выбрать цвет
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>
<script setup>

import { ref, onMounted, onUnmounted} from 'vue';
import QuestionIcon from '@/Components/svg/icons/QuestionIcon.vue'

const props = defineProps({
    modalSwitch: Boolean,
    colors: Array,
    word: { type: Object || null, required: false },
})

const emit = defineEmits(['offModal', 'selectColor'])
const rollIndex = ref(null)

const onOffModal = () => {
    emit('offModal')
    rollIndex.value = null
}

const handleKeyEscape = (event) => {
    if (event.key === 'Escape')
        onOffModal()
}

onMounted(() => {
    window.addEventListener('keydown', handleKeyEscape)
})

onUnmounted(() => {
    window.addEventListener('keydown', handleKeyEscape)
})


const onSelectColor = (word, color) => {
    rollIndex.value = null
    emit('selectColor', word, color)
}



const rightRollColor = () => {
    if (rollIndex.value === null) {
        rollIndex.value = 0
        return
    }
    if (rollIndex.value > (props.colors.length - 2)) {
        rollIndex.value = 0
        return
    }

    rollIndex.value++
}

const leftRollColor = () => {
    if (rollIndex.value === null) {
        rollIndex.value = props.colors.length - 1
        return
    }
    if (rollIndex.value < 1) {
        rollIndex.value = props.colors.length - 1
        return
    }
    rollIndex.value--
}

const onWheel = (e) => {
    if (e.deltaY < -1)
        leftRollColor()

    if (e.deltaY > 1)
        rightRollColor()
}


</script>


<style lang="scss" scoped>
.modal-animation-enter-active,
.modal-animation-leave-active {
    transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-animation-enter-from,
.modal-animation-leave-to {
    opacity: 0;
}

.question{
    position: relative;
    display: flex;
    width: 100%;
    padding-left: 30px;

    &:hover::after{
        opacity: 1;
    }
}

.word {
    color: white;
    font-size: 40px;
    font-weight: bold;
    margin: 0.2em;
    user-select: none;
    text-shadow: 0 0 2px black;

    justify-content: center;
    align-items: center;
    display: flex;


    >div {
        cursor: pointer;
    }

    .word-with-arrows {
        cursor: pointer;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transition: 0.2s ease-in-out;

        >* {
            display: flex;
            align-items: center;
        }

        >.arrow {
            justify-content: center;
            font-size: 60px;
            height: 1em;
            width: 1em;
            border: solid 3px rgba($color: $blue, $alpha: 0);
            border-radius: 10px;
            box-shadow: -4px 4px 9px 0px rgba($color: $blue-gray, $alpha: 0.3);
            margin: 0px 0.4em;
            transition: border 0.2s cubic-bezier(0.19, 1, 0.22, 1);

            &:active {
                box-shadow: -4px 4px 3px 0px rgba($color: $blue-gray, $alpha: 0.3);
            }
        }
    }
}

.word-modal {
    flex-direction: column;
    display: flex;
    position: fixed;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    justify-content: center;
    align-items: center;

    background-color: rgba($color: $blue-gray, $alpha: 0.5);
}

.inner-modal {
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: space-evenly;
    width: 30%;
    height: 50%;
    min-width: 500px;
    background-color: aliceblue;
    opacity: 1 !important;
    border-radius: 0.8rem;
}

.colors {
    display: flex;
    flex-direction: row;
    margin-bottom: 1em;
}

.color {
    border: solid 2px rgba($color: $blue-gray, $alpha: 0);
    border-radius: 10px;
}

.color-div {
    width: 40px;
    height: 15px;
    border: 2px solid black;
    border-radius: 0.8em;
    margin: 3px;
}

.button-box {
    margin-top: 1em;
    margin-bottom: 0.1em;
}

.button-box {
    margin-top: 1em;
    margin-bottom: 0.1em;

    .color-button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        font-weight: 700;
        cursor: pointer;
        border: 2px solid $blue;
        color: black;
        border-radius: 10px;
        transition:
            background-color 0.3s,
            color 0.3s,
            border 0.3s;

        &:hover {
            background-color: $blue;
            border: 2px solid whitesmoke;
            color: #fff;
        }
    }
}
</style>
