<script setup>
import { Head } from '@inertiajs/vue3';
import NextStep from '../../Components/Aspect/Buttons/NextStep.vue';
import { ref } from 'vue';

const props = defineProps({
    title: String,
    data: Array | Object,
    aspect_id: Number,
});

const moodProcent = ref(0)


</script>
<template>

    <Head :title="title" />
    <div class="aspect-frame">
        <h2>
            {{ title }}
        </h2>
        <div class="mood-level-box">
            <input class="input-range" type="range" v-model="moodProcent" min="0" max="100" @input="updatePercent">
            <div class="procent">
                {{ moodProcent }} %
            </div>
        </div>
        <NextStep :aspect_data="[moodProcent]" :aspect_id="aspect_id"></NextStep>
    </div>

</template>

<style lang="scss" scoped>
h3 {
    color: $blue-gray;
}

.mood-level-box {
    width: 400px;
    height: 500px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column-reverse;
}

.procent {
    color: $blue-gray;
    font-size: 50px;
    margin: 5rem 0rem;
    cursor: default;
    user-select: none;
}

.input-range {
    --webkit-appearance: none;
    width: 90%;
    background-color: $blue;
    border-radius: 1rem;
}
</style>
