<script setup>
const props = defineProps({
    id: String,
    type: String,
    modelValue: String,
    error: String,
    maxlength: {type: Number, required: false},
    required: {type: Boolean, required: false},
    mask: {type: String, required: false},
})

const emit = defineEmits(['update:model-value'])

const onInput = (event) => {
    emit('update:model-value', event.target.value)
}


</script>
<template>
    <div class="input-group">
        <label :class="[required ? 'input-is-required' : '']" :for="id">
            <slot />
        </label>
        <input v-if="mask" :id="id" :value="modelValue" @input="onInput" :type="type" class="form-input" :maxlength="maxlength" v-mask="mask">
        <input v-else :id="id" :value="modelValue" @input="onInput" :type="type" class="form-input" :maxlength="maxlength">

        <div v-if="error" class="invalid-feedback">
            {{ error }}
        </div>
    </div>


</template>

<style lang="scss" scoped>
.input-group {
    position: relative;
    width: 280px;

    input {
        width: 100%;
        height: 30px;
        background: $blue-light;
        // border: none;
        // outline: none;
        border: 2px solid $blue-gray;
        border-radius: 10px;
        font-size: 1em;
        padding: 0 35px 0 5px;
        color: #0f0e0e;

        &:invalid {
            color: #af3333;
        }
        &:focus{
            transition: background 0.2s cubic-bezier(0.075, 0.82, 0.165, 1);
            background: white;
        }
    }

    label {
        transform: translateY(-50%);
        color: $blue-gray-hover;
        font-size: 1em;
        pointer-events: none;
    }

    ion-icon {
        position: absolute;
        right: 8px;
        color: #0e0d0d;
        font-size: 1.2em;
        top: 20px;
    }

    .invalid-feedback {
        color: #af3333;
    }

    .input-is-required::after {
        color: #af3333;
        content: " *";
    }
}
</style>
