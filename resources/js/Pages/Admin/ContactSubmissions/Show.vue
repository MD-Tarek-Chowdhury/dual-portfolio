<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin.vue';

const props = defineProps({
    submission: { type: Object, required: true },
});

const deleteSubmission = () => {
    if (confirm('Delete this submission permanently?')) {
        router.delete(route('admin.contact-submissions.destroy', props.submission.id));
    }
};

const formatDate = (date) => new Date(date).toLocaleDateString('en-US', {
    year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
});
</script>

<template>
    <Head title="View Submission" />
    <AdminLayout>
        <div class="max-w-3xl mx-auto space-y-6">
            <!-- Header -->
            <div class="flex items-center gap-4">
                <Link :href="route('admin.contact-submissions.index')"
                      class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </Link>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Contact Submission</h2>
                    <p class="text-slate-500 text-sm mt-0.5">Received {{ formatDate(submission.created_at) }}</p>
                </div>
            </div>

            <!-- Submission Card -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <!-- Sender Info -->
                <div class="px-6 py-5 border-b border-slate-100">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold text-white shrink-0"
                             :class="submission.contact_type === 'academic' ? 'bg-blue-500' : 'bg-pink-500'">
                            {{ submission.name.charAt(0).toUpperCase() }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-lg font-semibold text-slate-800">{{ submission.name }}</h3>
                                <span :class="[
                                    'px-2.5 py-0.5 rounded-full text-xs font-medium',
                                    submission.contact_type === 'academic' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700'
                                ]">
                                    {{ submission.contact_type === 'academic' ? 'Academic' : 'Music' }}
                                </span>
                                <span v-if="!submission.read_at" class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    New
                                </span>
                            </div>
                            <a :href="`mailto:${submission.email}`" class="text-sm text-indigo-600 hover:underline">
                                {{ submission.email }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Message -->
                <div class="px-6 py-5 space-y-6">
                    <div>
                        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Subject</label>
                        <p class="text-base font-medium text-slate-800 mt-1">{{ submission.subject }}</p>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Message</label>
                        <div class="mt-2 p-4 rounded-lg bg-slate-50 border border-slate-100">
                            <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap">{{ submission.message }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                        <div>
                            <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">IP Address</label>
                            <p class="text-sm text-slate-600 mt-1 font-mono">{{ submission.ip_address || 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Read At</label>
                            <p class="text-sm text-slate-600 mt-1">{{ submission.read_at ? formatDate(submission.read_at) : 'Not yet read' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                    <Link :href="route('admin.contact-submissions.index')"
                          class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                        ← Back to submissions
                    </Link>
                    <button @click="deleteSubmission"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
