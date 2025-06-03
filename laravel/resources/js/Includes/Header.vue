<script setup>
import { Link } from "@inertiajs/vue3";
import ProfileIcon from '../Components/svg/icons/ProfileIcon.vue';

</script>
<template>
    <header class="flex-c">
        <div class="user-select-none">
            <nav>
                <ul>
                    <img class="logo-mini" src="../../../public/images/asp-small-logo.png" alt="Нет картинки">
                    <div class="name">
                        <p>ОБЛИК</p>
                    </div>
                </ul>
                <ul>
                    <li>
                        <Link :href="route('home')">
                            Главная
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('aspect.list')">
                            История
                        </Link>
                    </li>
                    <li>
                        <a>Контакты</a>
                    </li>
                </ul>

                <ul class="auth-ul">

                    <li>
                        <Link :href="route('login')">
                        <profile-icon />
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</template>


<style lang="scss" scoped>

.user-select-none{
    user-select: none;
}

header {
    padding-top: 28px;
    display: flex;
    background-color: $body-background;
    flex-shrink: 0;

    >div {
        display: flex;
        width: 1180;
        height: 72px;
        padding: 0px 10px;
        border-radius: 24px;
        background-color: $blocks-background;
    }

    nav {
        justify-content: space-between;
    }


    .auth-ul>li {
        margin-right: 10px !important;
    }

    ul {
        display: flex;
        justify-content: space-evenly;
        align-items: center;

        >li {
            margin: 20px;
        }
    }
}

.name {
    display: flex;
    flex-direction: column-reverse;
    height: 80%;
    justify-content: center;

    >p {
        color: $blue;
        font-weight: bolder;
    }
}

.logo-mini {
    width: 85px;
    height: 55px;
}
</style>
