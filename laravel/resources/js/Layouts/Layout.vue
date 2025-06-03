<script setup>
import Header from '../Includes/Header.vue'
import Footer from '../Includes/Footer.vue'
</script>

<template>
    <Header />
    <main>
        <section>
            <div class="wrapper">
                <slot />
            </div>
        </section>
    </main>
    <Footer />
</template>

<script>
export default {
    name: 'Layout',
    created() {

    },
    data() {
        return {
        }
    },
    props: {

    },
    methods: {

    },
}
</script>
<style lang="scss"></style>
