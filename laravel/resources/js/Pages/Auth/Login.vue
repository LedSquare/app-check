<script setup>
import InputGroup from "../../Components/Forms/InputGroup.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";



const props = defineProps({
    title: String,
});

const form = useForm({
    email: null,
    password: null,
});

function login() {
    form.post(route("login"));
}
</script>

<template>
    <div class="form-box">
        <Head :title="title" />
        <div class="form-value">
            <form @submit.prevent="login" method="POST">
                <h2>Авторизация</h2>
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
                    :error="form.errors.password"
                    v-model="form.password"
                    id="password"
                    type="password"
                    :required="true"
                >
                    Пароль</input-group
                >
                <div class="forget">
                    <label for="forget"
                        ><input id="forget" type="checkbox" />Запомнить<a
                            href="#"
                            >, забыли пароль?</a
                        >
                    </label>
                </div>
                <button type="submit">Войти</button>
                <div class="register-box">
                    <p>
                        <Link :href="route('register')">Зарегистрироваться</Link>
                    </p>
                </div>
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
