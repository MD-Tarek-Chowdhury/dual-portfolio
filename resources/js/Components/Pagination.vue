<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: { type: Array, required: true },
});
</script>

<template>
    <div v-if="links.length > 3" class="flex items-center justify-between mt-6">
        <div class="flex items-center gap-1 flex-wrap">
            <template v-for="(link, index) in links" :key="index">
                <div v-if="link.url === null"
                     class="px-3 py-1.5 rounded-md text-sm text-slate-400 bg-slate-100 cursor-not-allowed"
                     v-html="link.label"/>
                <Link v-else
                      :href="link.url"
                      :class="[
                          'px-3 py-1.5 rounded-md text-sm font-medium transition-all duration-200',
                          link.active
                              ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/25'
                              : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'
                      ]"
                      v-html="link.label"/>
            </template>
        </div>
    </div>
</template>
