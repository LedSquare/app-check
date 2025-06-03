<script setup>
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    title: String,
    resource: {type: [Array, Object], required: true},
})

const aspectReport = (aspectId) => {

    router.visit('report/' + aspectId)
}
</script>

<template>
    <div class="aspect-list-contrainer">
        <Head :title="title"/>
        <div class="aspects" v-if="resource.data.length !== 0">
        <table class="">
            <thead>
                <tr>
                    <th>Номер</th>
                    <th>Дата прохождения</th>
                    <th>Закончен</th>
                </tr>
            </thead>
            <tbody>
                <tr class="tr-link" @click="aspectReport(aspect.id)" v-for="aspect in resource.data" :key="aspect.id">
                    <td>{{ aspect.id }}</td>
                    <td>{{ aspect.created_at }}</td>
                    <td>{{ aspect.isEnded }}</td>
                    </tr>
            </tbody>
        </table>
        </div>
        <div v-else class="empty">
            <h2>
                В данный момент у вас нет истории обликов
            </h2>
        </div>
    </div>
</template>


<style lang="scss" scoped>
.tr-link{
    cursor: pointer;
}

.empty{
    width: 100%;
    height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.aspects{
    display: flex;
    min-height: 50vh;
    width: 99%;
}

table{
    width: 100%;
    height: fit-content;
}
tr{
    height: 40px
};
td, th{
    border: 3px solid white;
    background: $body-background;
}
th{
    background: $blue;
}

</style>
