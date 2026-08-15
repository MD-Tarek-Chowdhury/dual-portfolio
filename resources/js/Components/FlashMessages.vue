<script setup>
import { computed, ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const messages = ref([]);

const flash = computed(() => page.props.flash || {});

watch(flash, (newFlash) => {
    if (newFlash.success) {
        addMessage('success', newFlash.success);
    }
    if (newFlash.error) {
        addMessage('error', newFlash.error);
    }
    if (newFlash.warning) {
        addMessage('warning', newFlash.warning);
    }
}, { immediate: true, deep: true });

function addMessage(type, text) {
    const id = Date.now() + Math.random();
    messages.value.push({ id, type, text });
    setTimeout(() => removeMessage(id), 5000);
}

function removeMessage(id) {
    messages.value = messages.value.filter(m => m.id !== id);
}

const icons = {
    success: 'M5 13l4 4L19 7',
    error: 'M6 18L18 6M6 6l12 12',
    warning: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
};

const colors = {
    success: 'bg-emerald-50 border-emerald-200 text-emerald-800',
    error: 'bg-red-50 border-red-200 text-red-800',
    warning: 'bg-amber-50 border-amber-200 text-amber-800',
};
</script>

<template>
    <div class="fixed top-20 right-4 z-50 space-y-3 w-80">
        <TransitionGroup name="flash">
            <div v-for="msg in messages" :key="msg.id"
                 :class="['px-4 py-3 rounded-lg border shadow-lg flex items-start gap-3', colors[msg.type]]">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="icons[msg.type]"/>
                </svg>
                <p class="text-sm flex-1">{{ msg.text }}</p>
                <button @click="removeMessage(msg.id)" class="shrink-0 opacity-60 hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </TransitionGroup>
    </div>
</template>

<style scoped>
.flash-enter-active,
.flash-leave-active {
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.flash-enter-from {
    opacity: 0;
    transform: translateX(100%) scale(0.9);
}
.flash-leave-to {
    opacity: 0;
    transform: translateX(100%);
}
</style>
