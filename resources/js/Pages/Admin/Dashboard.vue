<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin.vue';
import { computed } from 'vue';

const props = defineProps({
    stats: { type: Object, required: true },
});

const statCards = computed(() => [
    {
        title: 'Academic Records',
        total: props.stats.academic_records?.total || 0,
        active: props.stats.academic_records?.active || 0,
        trashed: props.stats.academic_records?.trashed || 0,
        icon: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        color: 'blue',
        route: 'admin.academic-records.index',
    },
    {
        title: 'Music Records',
        total: props.stats.music_records?.total || 0,
        active: props.stats.music_records?.active || 0,
        trashed: props.stats.music_records?.trashed || 0,
        icon: 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3',
        color: 'pink',
        route: 'admin.music-records.index',
    },
    {
        title: 'Contact Submissions',
        total: props.stats.contact_submissions?.total || 0,
        unread: props.stats.contact_submissions?.unread || 0,
        icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        color: 'amber',
        route: 'admin.contact-submissions.index',
    },
]);

const colorClasses = {
    blue: { bg: 'bg-blue-50', text: 'text-blue-700', icon: 'text-blue-500', border: 'border-blue-100' },
    pink: { bg: 'bg-pink-50', text: 'text-pink-700', icon: 'text-pink-500', border: 'border-pink-100' },
    amber: { bg: 'bg-amber-50', text: 'text-amber-700', icon: 'text-amber-500', border: 'border-amber-100' },
};

const academicTypes = computed(() => props.stats.academic_records?.by_type || {});
const musicTypes = computed(() => props.stats.music_records?.by_type || {});
</script>

<template>
    <Head title="Dashboard" />
    <AdminLayout>
        <div class="space-y-8">
            <!-- Header -->
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Dashboard</h2>
                <p class="text-slate-500 text-sm mt-1">Overview of your portfolio content and activity.</p>
            </div>

            <!-- Stat Cards -->
            <div class="grid md:grid-cols-3 gap-6">
                <div v-for="card in statCards" :key="card.title"
                     class="rounded-xl p-6 border transition-all duration-300 hover:shadow-lg"
                     :class="[colorClasses[card.color].bg, colorClasses[card.color].border]">
                    <div class="flex items-start justify-between mb-4">
                        <div :class="['w-12 h-12 rounded-xl flex items-center justify-center', colorClasses[card.color].bg]">
                            <svg class="w-6 h-6" :class="colorClasses[card.color].icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" :d="card.icon"/>
                            </svg>
                        </div>
                        <span v-if="card.unread !== undefined && card.unread > 0"
                              class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-500 text-white">
                            {{ card.unread }} new
                        </span>
                    </div>
                    <h3 class="text-3xl font-bold" :class="colorClasses[card.color].text">{{ card.total }}</h3>
                    <p class="text-sm font-medium mt-1" :class="colorClasses[card.color].text">{{ card.title }}</p>
                    <div class="flex items-center gap-4 mt-4 text-xs">
                        <span class="flex items-center gap-1" :class="colorClasses[card.color].text">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            {{ card.active !== undefined ? card.active : card.total - (card.unread || 0) }} active
                        </span>
                        <span v-if="card.trashed !== undefined && card.trashed > 0" class="flex items-center gap-1 text-red-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                            {{ card.trashed }} in trash
                        </span>
                        <span v-if="card.unread !== undefined && card.unread > 0" class="flex items-center gap-1 text-amber-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            {{ card.unread }} unread
                        </span>
                    </div>
                </div>
            </div>

            <!-- Breakdown Charts -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Academic Breakdown -->
                <div class="rounded-xl border border-slate-200 bg-white p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Academic Records by Type</h3>
                    <div v-if="Object.keys(academicTypes).length" class="space-y-3">
                        <div v-for="(count, type) in academicTypes" :key="type" class="flex items-center gap-3">
                            <span class="text-sm font-medium text-slate-600 w-28 capitalize">{{ type }}</span>
                            <div class="flex-1 h-8 bg-slate-100 rounded-lg overflow-hidden">
                                <div class="h-full bg-blue-500 rounded-lg transition-all duration-700 flex items-center justify-end px-2"
                                     :style="{ width: Math.max((count / (statCards[0].total || 1)) * 100, 5) + '%' }">
                                    <span class="text-xs font-bold text-white">{{ count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center py-8 text-slate-400 text-sm">
                        No academic records yet.
                    </div>
                </div>

                <!-- Music Breakdown -->
                <div class="rounded-xl border border-slate-200 bg-white p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Music Records by Type</h3>
                    <div v-if="Object.keys(musicTypes).length" class="space-y-3">
                        <div v-for="(count, type) in musicTypes" :key="type" class="flex items-center gap-3">
                            <span class="text-sm font-medium text-slate-600 w-28 capitalize">{{ type.replace('_', ' ') }}</span>
                            <div class="flex-1 h-8 bg-slate-100 rounded-lg overflow-hidden">
                                <div class="h-full bg-pink-500 rounded-lg transition-all duration-700 flex items-center justify-end px-2"
                                     :style="{ width: Math.max((count / (statCards[1].total || 1)) * 100, 5) + '%' }">
                                    <span class="text-xs font-bold text-white">{{ count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center py-8 text-slate-400 text-sm">
                        No music records yet.
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="rounded-xl border border-slate-200 bg-white p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <Link v-for="action in [
                        { label: 'Add Academic', route: 'admin.academic-records.create', icon: 'M12 4v16m8-8H4', color: 'blue' },
                        { label: 'Add Music', route: 'admin.music-records.create', icon: 'M12 4v16m8-8H4', color: 'pink' },
                        { label: 'View Settings', route: 'admin.settings.index', icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z', color: 'slate' },
                        { label: 'Upload Media', route: 'admin.media.index', icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', color: 'emerald' },
                    ]" :key="action.route" :href="route(action.route)"
                          class="flex flex-col items-center gap-3 p-5 rounded-xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all duration-200 group">
                        <div :class="['w-10 h-10 rounded-lg flex items-center justify-center transition-colors',
                            action.color === 'blue' ? 'bg-blue-50 group-hover:bg-blue-100' :
                            action.color === 'pink' ? 'bg-pink-50 group-hover:bg-pink-100' :
                            action.color === 'emerald' ? 'bg-emerald-50 group-hover:bg-emerald-100' :
                            'bg-slate-50 group-hover:bg-slate-100']">
                            <svg class="w-5 h-5" :class="[
                                action.color === 'blue' ? 'text-blue-500' :
                                action.color === 'pink' ? 'text-pink-500' :
                                action.color === 'emerald' ? 'text-emerald-500' :
                                'text-slate-500'
                            ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="action.icon"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700">{{ action.label }}</span>
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
