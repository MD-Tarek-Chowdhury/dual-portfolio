<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin.vue';
import Pagination from '@/Components/Pagination.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import { ref, watch } from 'vue';
import { debounce } from 'lodash';

const props = defineProps({
    submissions: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
});

const search = ref(props.filters.search || '');
const typeFilter = ref(props.filters.type || '');

const applyFilters = debounce(() => {
    router.get(route('admin.contact-submissions.index'), {
        search: search.value,
        type: typeFilter.value,
    }, { preserveState: true, preserveScroll: true, replace: true });
}, 300);

watch([search, typeFilter], applyFilters);

const deleteSubmission = (submission) => {
    if (confirm('Delete this submission permanently?')) {
        router.delete(route('admin.contact-submissions.destroy', submission.id));
    }
};

const formatDate = (date) => new Date(date).toLocaleDateString('en-US', {
    year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit'
});
</script>

<template>
    <Head title="Contact Submissions" />
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Contact Submissions</h2>
                    <p class="text-slate-500 text-sm mt-1">Messages received through the contact form.</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl border border-slate-200 p-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input v-model="search" type="text" placeholder="Search by name, email, or subject..."
                               class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all"/>
                    </div>
                    <select v-model="typeFilter" class="px-4 py-2.5 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 bg-white min-w-[160px]">
                        <option value="">All Types</option>
                        <option value="academic">Academic</option>
                        <option value="music">Music</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">From</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="submission in submissions.data" :key="submission.id"
                                class="hover:bg-slate-50/50 transition-colors group cursor-pointer"
                                @click="router.visit(route('admin.contact-submissions.show', submission.id))">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0"
                                             :class="submission.contact_type === 'academic' ? 'bg-blue-500' : 'bg-pink-500'">
                                            {{ submission.name.charAt(0).toUpperCase() }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-800">{{ submission.name }}</p>
                                            <p class="text-xs text-slate-400">{{ submission.email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-700 truncate max-w-[200px]">{{ submission.subject }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <StatusBadge :status="submission.contact_type" />
                                </td>
                                <td class="px-6 py-4">
                                    <StatusBadge :status="submission.read_at ? 'read' : 'unread'" />
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs text-slate-500">{{ formatDate(submission.created_at) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <Link :href="route('admin.contact-submissions.show', submission.id)"
                                              class="p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors"
                                              @click.stop>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </Link>
                                        <button @click.stop="deleteSubmission(submission)"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
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

                <div v-if="!submissions.data || submissions.data.length === 0" class="text-center py-16">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-700 mb-1">No submissions yet</h3>
                    <p class="text-sm text-slate-400">Contact form submissions will appear here.</p>
                </div>

                <Pagination v-if="submissions.links" :links="submissions.links" />
            </div>
        </div>
    </AdminLayout>
</template>
