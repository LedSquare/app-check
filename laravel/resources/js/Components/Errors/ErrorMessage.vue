<script setup>
import {onUnmounted, watch} from 'vue'

const props = defineProps({
    message: String,
})

const emit = defineEmits(['clearMessage'])
let timerId = null

const onClear = () =>{
    emit('clearMessage')
}

const startTimer = () => {
    if(timerId) {
        clearTimeout(timerId)
    }
    timerId =  setTimeout(() => {
        onClear()
    }, 4000);
}

watch(() => props.message, (newMessage) =>{
    if(newMessage){
        startTimer()
    }
})

onUnmounted(() => {
    clearTimeout(timerId)
})

</script>

<template>
    <transition name="modal-animation">
        <div v-if="message" class="error">
        <p>{{ message }}</p>
        <button @click="onClear">Закрыть</button>
        </div>
    </transition>
</template>

<style lang="scss" scoped>

.modal-animation-enter-active,
.modal-animation-leave-active {
    transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-animation-enter-from,
.modal-animation-leave-to {
    opacity: 0;
}


.error {
    position: fixed;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #ff6b6b;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 1000;

    p{
        margin: 0;
    }
    button{
        background-color: transparent;
        border: none;
        color: white;
        cursor: pointer;
        margin-left: 10px;
    }
}

</style>

