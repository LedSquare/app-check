<script setup>
import _ from 'lodash'
import { nextTick, onMounted, ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import BrainIcon from '../../Components/svg/icons/BrainIcon.vue';

const props = defineProps({
    aspect_id: Number,
    data: {type: [Array, Object], required: true},
    title: String,
})

const cloned = _.cloneDeep(props)
const words = ref(cloned.data.words)



</script>

<template>
    <div class="report-frame">
        <Head :title="title"/>
        <div class="brain-icon">
            <BrainIcon />
        </div>
        <h1>
            Облик № {{ aspect_id }} закончен !
        </h1>
        <!-- <div class="steps">
            <div class="step" v-for="(step, stepIndex) in words" :key="stepIndex">
                <div class="words">
                    <div
                        class="word"
                        v-for="(word) in step"
                        :key="word.id"
                        :style="['color:' + word.colorCode]"
                        >
                        {{ word.name }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mood-levels">

        </div> -->
    </div>
</template>

<style lang="scss" scoped>
.report-frame{
    display: flex;
    flex-direction: column;
    width:100%;
    align-items: center;
}

.brain-icon{
    margin-bottom: 2rem;
}

.mood-levels{
    display: flex;
    widows: 100%;
    height: 50px;
    border-bottom: 2px solid black;
}

.steps{
    width: 100%;
    display: flex;
    border-bottom: 2px solid black;
    overflow-x: auto;

    .step{
        display: flex;
        flex-direction: row;
        margin: 10px;
    }
}

.word{
    font-size: 20px;
    font-weight: bold;
    color: $blue-gray;
    text-shadow: 1px 1px 1px $blue-gray;
}



.arrows{
    margin-left: 10px;
}

</style>
