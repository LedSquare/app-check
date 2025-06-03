<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import ErrorMessage from '@/Components/Errors/ErrorMessage.vue';

const props = defineProps({
    aspect_id: Number,
    aspect_data: { type: Array, required: true },
    validate: { type: Function, required: false }
});

const errorMessage = ref(null)
const buttonIsDisabled =  ref(false)

const clearMessage = () => {
    errorMessage.value = null
}

const storeAspect = () => {
    if(!buttonIsDisabled.value){
        if (props.validate) {
            try {
                props.validate(props.aspect_data)
            } catch (error) {
                errorMessage.value = error.message
                return
            }
        }

        const form = useForm({
            aspect_id: props.aspect_id,
            aspect_data: props.aspect_data,
        });
        form.post(route('aspect.store', props.aspect_id))
        buttonIsDisabled.value = true;

        setTimeout(() => {
            buttonIsDisabled.value = false;
        }, 1000)
    }
}


</script>
<template>
    <div class="button-box">
        <ErrorMessage :message="errorMessage" :disabled="buttonIsDisabled" @clearMessage="clearMessage" />

        <button @click="storeAspect" class="step-button">
            Следующий шаг
        </button>
    </div>
</template>

<style lang="scss" scoped>
.button-box {
    margin-top: 3rem;
    margin-bottom: 0.1em;
}

.step-button {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    text-align: center;
    text-decoration: none;
    font-weight: 700;
    cursor: pointer;
    border: 2px solid $blue;
    color: $blue-gray;
    border-radius: 10px;
    transition:
        background-color 0.3s,
        color 0.3s,
        border 0.3s;

    &:hover {
        background-color: $blue;
        border: 2px solid whitesmoke;
        color: #fff;
    }
}
</style>
