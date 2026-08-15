<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin.vue';

const props = defineProps({
    academicRecords: { type: Array, default: () => [] },
    musicRecords: { type: Array, default: () => [] },
});

const restoreAcademic = (id) => {
    if (confirm('Restore this academic record?')) {
        router.post(route('admin.academic-records.restore', id));
    }
};

const forceDeleteAcademic = (id) => {
    if (confirm('Permanently delete this record? This cannot be undone.')) {
        router.delete(route('admin.academic-records.force-delete', id));
    }
};

const restoreMusic = (id) => {
    if (confirm('Restore this music record?')) {
        router.post(route('admin.music-records.restore', id));
    }
};

const forceDeleteMusic = (id) => {
    if (confirm('Permanently delete this record? This cannot be undone.')) {
        router.delete(route('admin.music-records.force-delete', id));
    }
};

const formatDate = (date) => new Date(date).toLocaleDateString('en-US', {
    year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit'
});
</script>

<template>
    <Head title="Trash Bin" />
    <AdminLayout>
        <div class="space-y-8">
            <!-- Header -->
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Trash Bin</h2>
                <p class="text-slate-500 text-sm mt-1">Restore or permanently delete trashed records.</p>
            </div>

            <!-- Academic Trash -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-800">Academic Records</h3>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                            {{ academicRecords.length }}
                        </span>
                    </div>
                </div>

                <div v-if="academicRecords.length" class="divide-y divide-slate-100">
                    <div v-for="record in academicRecords" :key="record.id"
                         class="px-6 py-4 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800">{{ record.title }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                <span class="uppercase tracking-wider">{{ record.record_type }}</span>
                                • Deleted {{ formatDate(record.deleted_at) }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <button @click="restoreAcademic(record.id)"
                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Restore
                            </button>
                            <button @click="forceDeleteAcademic(record.id)"
                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Forever
                            </button>
                        </div>
                    </div>
                </div>
                <div v-else class="px-6 py-12 text-center">
                    <p class="text-sm text-slate-400">No trashed academic records.</p>
                </div>
            </div>

            <!-- Music Trash -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-pink-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-800">Music Records</h3>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                            {{ musicRecords.length }}
                        </span>
                    </div>
                </div>

                <div v-if="musicRecords.length" class="divide-y divide-slate-100">
                    <div v-for="record in musicRecords" :key="record.id"
                         class="px-6 py-4 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800">{{ record.title }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                <span class="uppercase tracking-wider">{{ record.record_type }}</span>
                                • Deleted {{ formatDate(record.deleted_at) }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <button @click="restoreMusic(record.id)"
                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Restore
                            </button>
                            <button @click="forceDeleteMusic(record.id)"
                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Forever
                            </button>
                        </div>
                    </div>
                </div>
                <div v-else class="px-6 py-12 text-center">
                    <p class="text-sm text-slate-400">No trashed music records.</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
