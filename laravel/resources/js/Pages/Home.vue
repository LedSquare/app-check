<script setup>
import { Head, Link, router } from '@inertiajs/vue3'

const props = defineProps({
    title: String,
    isActive: Boolean
})

</script>
<template>

    <Head :title="title" />

    <div class="start-page flex-c">
        <h1>Облик</h1>
        <Link :href="route('aspect.start')" as="button" class="start-button">
            Начать
        </Link>
    </div>
</template>

<style lang="scss" scoped></style>
