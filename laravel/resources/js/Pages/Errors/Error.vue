<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    errors: Array,
    code: Number,
})

</script>
<template>
    <div class="error-code">
        <h1>{{ code }}</h1>
    </div>
    <div style="display: flex; flex-direction: column; justify-content: center; " v-for="(error, key) in errors" :key="error">
        <h3>Объект ошибки: {{ key }}</h3>
        <p style="margin: 0.5em;">
            {{ error }}
        </p>
    </div>
</template>

<style lang="scss" scoped>
.error-code {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 1em 1em;
}

h1 {
    user-select: none;
    text-shadow: #6f8ab3 1px 0 10px;
    font-size: 5em;
    color: #1d2737;
}
</style>
