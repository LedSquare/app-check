<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import _ from "lodash";
import InputGroup from "@/Components/Forms/Profile/ProfileInputGroup.vue"

const props = defineProps({
    data: Array | Object,
    title: String,
});

const form = useForm({
    username : props.data.username,
    email: props.data.email,
    firstname: props.data.firstname,
    lastname: props.data.lastname,
    fathername: props.data.fathername,
    gender: props.data.gender,
    phone: props.data.phone,
})

const update = () => {
    form.post(route('profile.update'))
}


</script>

<template>
    <div class="profile-container">
        <Head :title="title"></Head>
        <div class="personal-info">
            <form @submit.prevent="update" method="POST">
            <header>
                <p>
                    Персональные данные
                </p>
            </header>
            <div class="info-container">
                <div>
                    <input-group
                        :error="form.errors.firstname"
                        v-model="form.firstname"
                        id="firstname"
                        type="text"
                        :maxlength="40"
                    >
                        Имя
                    </input-group>
                    <input-group
                        :error="form.errors.lastname"
                        v-model="form.lastname"
                        id="lastname"
                        type="text"
                        :maxlength="40"
                    >
                        Фамилия
                    </input-group>
                    <input-group
                        :error="form.errors.fathername"
                        :maxlength="40"
                        v-model="form.fathername"
                        id="fathername"
                        type="text"
                    >
                        Отчество
                    </input-group>
                    <div class="select-group">
                        <label for="gender">Пол</label>
                        <select id="gender" v-model="form.gender">
                            <option :value="form.gender" selected disabled hidden>{{form.gender}}</option>
                            <option value="муж">муж</option>
                            <option value="жен">жен</option>
                        </select>
                    </div>
                </div>
                <div>
                    <input-group
                    :error="form.errors.username"
                    v-model="form.username"
                    id="username"
                    type="text"
                    :maxlength="40"
                    >
                        Никнейм
                    </input-group>
                    <input-group
                        :error="form.errors.email"
                        v-model="form.email"
                        id="email"
                        type="email"
                        :maxlength="25"
                    >
                        Почта
                    </input-group>
                    <input-group
                        :error="form.errors.phone"
                        v-model="form.phone"
                        id="phone"
                        type="text"
                        :maxlength="20"
                        :mask="'+7 (###) ###-##-##'"
                    >
                        Телефон
                    </input-group>
                </div>
            </div>

            <button type="submit" class="update-button">
                Сохранить
            </button>
        </form>
        </div>
    </div>
</template>

<style lang="scss" scoped>

.profile-container{
    width: 100%;
    min-height: 900px;
    box-sizing: border-box;

    .update-button{
        margin-top: 2rem;
        width: 20%;
        height: 40px;
        border-radius: 15px;
        background: $blue;
        border: none;
        outline: none;
        cursor: pointer;
        font-size: 1em;
        font-weight: 600;
        transition: color 0.2s ease-in-out;

        &:hover{
            transition: color 0.2s;
            color: white;
        }
    }
}

.personal-info{
    width: 100%;
    display: flex;
    flex-direction: column;
}

.info-container{
    display: flex;
    flex-direction: row;
    gap: 2rem;
    flex-wrap: wrap;
    box-sizing: border-box;

    > div{
        box-sizing: border-box;
        margin-bottom: 1rem;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        width: 100%;
        gap: 2rem;
        border-bottom: 4px solid rgba($color: $blue-gray, $alpha: 0.1);
        padding-bottom: 1rem;
    }
}


header{
    width: 100%;
    border-bottom: 2px solid $blue-gray;
    margin-bottom: 10px;
    p{
        margin: 1rem;
    }
}

.select-group{
    display: flex;
    flex-direction: column;

    label{
        color: $blue-gray-hover;
        font-size: 1em;
        pointer-events: none;
    }

    select{
        background: $blue-light;
        border: 2px solid $blue-gray;
        border-radius: 10px;
        height: 30px;
        width: 70px;

        option{
            background-color: $blue-light;
            border: 2px solid $blue-gray;
            border-radius: 10px;
        }
    }
}
</style>
