<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin.vue';
import Pagination from '@/Components/Pagination.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import { ref, watch } from 'vue';
import { debounce } from 'lodash';

const props = defineProps({
    records: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
    types: { type: Array, default: () => [] },
});

const search = ref(props.filters.search || '');
const typeFilter = ref(props.filters.type || '');
const statusFilter = ref(props.filters.status || '');

const typeLabels = {
    publication: 'Publication',
    course: 'Course',
    designation: 'Designation',
    achievement: 'Achievement',
};

const typeColors = {
    publication: 'bg-blue-50 text-blue-700 border-blue-100',
    course: 'bg-emerald-50 text-emerald-700 border-emerald-100',
    designation: 'bg-purple-50 text-purple-700 border-purple-100',
    achievement: 'bg-amber-50 text-amber-700 border-amber-100',
};

const applyFilters = debounce(() => {
    router.get(route('admin.academic-records.index'), {
        search: search.value,
        type: typeFilter.value,
        status: statusFilter.value,
    }, { preserveState: true, preserveScroll: true, replace: true });
}, 300);

watch([search, typeFilter, statusFilter], applyFilters);

const deleteRecord = (record) => {
    if (confirm(`Move "${record.title}" to trash?`)) {
        router.delete(route('admin.academic-records.destroy', record.id));
    }
};

const clearFilters = () => {
    search.value = '';
    typeFilter.value = '';
    statusFilter.value = '';
};
</script>

<template>
    <Head title="Academic Records" />
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Academic Records</h2>
                    <p class="text-slate-500 text-sm mt-1">Manage publications, courses, designations, and achievements.</p>
                </div>
                <Link :href="route('admin.academic-records.create')"
                      class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-md shadow-indigo-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Record
                </Link>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl border border-slate-200 p-4 space-y-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1 relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input v-model="search" type="text" placeholder="Search records..."
                               class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all"/>
                    </div>
                    <!-- Type Filter -->
                    <select v-model="typeFilter" class="px-4 py-2.5 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 bg-white min-w-[160px]">
                        <option value="">All Types</option>
                        <option v-for="t in types" :key="t" :value="t">{{ typeLabels[t] || t }}</option>
                    </select>
                    <!-- Status Filter -->
                    <select v-model="statusFilter" class="px-4 py-2.5 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 bg-white min-w-[140px]">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="trashed">Trashed</option>
                    </select>
                    <!-- Clear -->
                    <button v-if="search || typeFilter || statusFilter" @click="clearFilters"
                            class="px-4 py-2.5 rounded-lg border border-slate-200 text-sm text-slate-600 hover:bg-slate-50 transition-colors">
                        Clear
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Record</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="record in records.data" :key="record.id"
                                class="hover:bg-slate-50/50 transition-colors group"
                                :class="record.deleted_at ? 'opacity-60' : ''">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">{{ record.title }}</p>
                                        <p v-if="record.subtitle_or_institution" class="text-xs text-slate-500 mt-0.5">{{ record.subtitle_or_institution }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5 font-mono">/{{ record.slug }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span :class="['px-2.5 py-1 rounded-full text-xs font-medium border', typeColors[record.record_type] || 'bg-slate-50 text-slate-600 border-slate-100']">
                                        {{ typeLabels[record.record_type] || record.record_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-600 font-mono">{{ record.display_order }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <StatusBadge :status="record.deleted_at ? 'trashed' : 'active'" />
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs text-slate-500">{{ new Date(record.created_at).toLocaleDateString() }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <Link :href="route('admin.academic-records.edit', record.id)"
                                              class="p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors"
                                              title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.433-4.433l1.434-1.434a2 2 0 000-2.828l-1.434-1.434a2 2 0 00-2.828 0L12 6.172l-2.828-2.829a2 2 0 00-2.829 0L4.91 4.776a2 2 0 000 2.828l1.434 1.434"/>
                                            </svg>
                                        </Link>
                                        <button @click="deleteRecord(record)"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                                title="Move to Trash">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div v-if="!records.data || records.data.length === 0" class="text-center py-16">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-700 mb-1">No records found</h3>
                    <p class="text-sm text-slate-400 mb-4">Get started by creating your first academic record.</p>
                    <Link :href="route('admin.academic-records.create')"
                          class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Record
                    </Link>
                </div>

                <!-- Pagination -->
                <Pagination v-if="records.links" :links="records.links" />
            </div>
        </div>
    </AdminLayout>
</template>
