<script setup>
const props = defineProps({
    status: { type: String, required: true },
});

const classes = {
    active: 'bg-emerald-100 text-emerald-700 border-emerald-200',
    trashed: 'bg-red-100 text-red-700 border-red-200',
    unread: 'bg-amber-100 text-amber-700 border-amber-200',
    read: 'bg-slate-100 text-slate-600 border-slate-200',
    academic: 'bg-blue-100 text-blue-700 border-blue-200',
    music: 'bg-pink-100 text-pink-700 border-pink-200',
};
</script>

<template>
    <span :class="['px-2.5 py-0.5 rounded-full text-xs font-medium border', classes[status] || classes.active]">
        {{ status.charAt(0).toUpperCase() + status.slice(1) }}
    </span>
</template>
