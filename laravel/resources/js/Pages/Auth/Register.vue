<script setup>
import InputGroup from "../../Components/Forms/InputGroup.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
    title: String,
});

const form = useForm({
    username: null,
    email: null,
    phone: null,
    password: null,
    password_confirmation: null,
    gender: "муж",
});

function register() {
    form.post(route("register"));
}
</script>
<template>
    <!-- TODO: Решить вопрос с маской -->

    <div class="form-box">
        <Head :title="title" />
        <div class="form-value">
            <form @click.prevent="register" method="POST">
                <h2>Регистрация</h2>
                <input-group
                    :error="form.errors.username"
                    v-model="form.username"
                    id="username"
                    type="text"
                    :required="true"
                >
                    Логин
                </input-group>
                <input-group
                    :error="form.errors.email"
                    v-model="form.email"
                    id="email"
                    type="email"
                    :required="true"
                >
                    Почта
                </input-group>
                <input-group
                    :error="form.errors.phone"
                    v-model="form.phone"
                    id="phone"
                    type="text"
                    :required="false"
                >
                    Телефон
                </input-group>
                <input-group
                    :error="form.errors.password"
                    v-model="form.password"
                    id="password"
                    type="password"
                    :required="true"
                >
                    Пароль
                </input-group>
                <input-group
                    :error="form.errors.password_confirmation"
                    v-model="form.password_confirmation"
                    id="password_confirmation"
                    type="password_confirmation"
                    :required="true"
                >
                    Подтверждение пароля
                </input-group>

                <select v-model="form.gender" id="gender">
                    <option value="муж">муж</option>
                    <option value="жен">жен</option>
                </select>
                <div v-if="form.errors.gender" class="invalid-feedback">
                    {{ form.errors.gender }}
                </div>

                <button type="submit">Зарегистрироваться</button>
            </form>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.form-box {
    min-height: 450px;
    background: transparent;
    display: flex;
    justify-content: center;
    align-items: center;

    h2 {
        font-size: 2em;
        color: #0a0a0a;
        text-align: center;
    }

    select {
        margin: 30px 10px;
        font-size: 1em;
        border-radius: 15px;
        cursor: pointer;
    }

    * button {
        width: 100%;
        height: 40px;
        border-radius: 15px;
        background: $blue;
        border: none;
        outline: none;
        cursor: pointer;
        font-size: 1em;
        font-weight: 600;
    }
}

.forget {
    margin: -15px 0 15px;
    font-size: 0.9em;
    color: #0e0d0d;
    display: flex;
    justify-content: center;
}

.forget label input {
    margin-right: 3px;
}

.forget label a {
    color: #141313;
    text-decoration: none;
}

.forget label a:hover {
    text-decoration: underline;
}

.register-box {
    font-size: 0.9em;
    color: #f0e5e5;
    text-align: center;
    margin: 25px 0 10px;

    a {
        text-decoration: none;
        color: #050505;
        font-weight: 600;

        &:hover {
            text-decoration: underline;
        }
    }
}
</style>
