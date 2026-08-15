<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin.vue';
import { computed, watch } from 'vue';

const props = defineProps({
    types: { type: Array, required: true },
    record: { type: Object, default: null },
});

const isEditing = computed(() => !!props.record);

const form = useForm({
    record_type: props.record?.record_type || 'band_info',
    title: props.record?.title || '',
    media_url: props.record?.media_url || '',
    body: props.record?.body || '',
    slug: props.record?.slug || '',
    display_order: props.record?.display_order ?? 0,
    is_active: props.record?.is_active ?? true,
});

const typeLabels = {
    band_info: 'Band Info',
    discography: 'Discography',
    instrument: 'Instrument',
    course: 'Course',
};

// Auto-generate slug from title
watch(() => form.title, (newTitle) => {
    if (!isEditing.value && newTitle && !form.slug) {
        form.slug = newTitle.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-|-$/g, '');
    }
});

const submit = () => {
    if (isEditing.value) {
        form.put(route('admin.music-records.update', props.record.id));
    } else {
        form.post(route('admin.music-records.store'));
    }
};
</script>

<template>
    <Head :title="isEditing ? 'Edit Music Record' : 'Create Music Record'" />
    <AdminLayout>
        <div class="max-w-3xl mx-auto space-y-6">
            <!-- Header -->
            <div class="flex items-center gap-4">
                <Link :href="route('admin.music-records.index')"
                      class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </Link>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">{{ isEditing ? 'Edit Record' : 'Create Record' }}</h2>
                    <p class="text-slate-500 text-sm mt-0.5">{{ isEditing ? 'Update music record details.' : 'Add a new music record to your portfolio.' }}</p>
                </div>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="bg-white rounded-xl border border-slate-200 p-6 space-y-6">
                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Record Type <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <button v-for="t in types" :key="t" type="button"
                                @click="form.record_type = t"
                                :class="[
                                    'px-4 py-3 rounded-lg text-sm font-medium border-2 transition-all duration-200 text-center',
                                    form.record_type === t
                                        ? 'border-indigo-500 bg-indigo-50 text-indigo-700'
                                        : 'border-slate-200 text-slate-600 hover:border-slate-300'
                                ]">
                            {{ typeLabels[t] || t }}
                        </button>
                    </div>
                    <p v-if="form.errors.record_type" class="mt-1 text-xs text-red-500">{{ form.errors.record_type }}</p>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Title <span class="text-red-500">*</span></label>
                    <input v-model="form.title" type="text" placeholder="e.g., Echoes of the Void Album"
                           class="w-full px-4 py-2.5 rounded-lg border text-sm transition-all focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                           :class="form.errors.title ? 'border-red-300' : 'border-slate-200'"/>
                    <p v-if="form.errors.title" class="mt-1 text-xs text-red-500">{{ form.errors.title }}</p>
                </div>

                <!-- Media URL -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Media URL</label>
                    <input v-model="form.media_url" type="url" placeholder="https://... (image, audio, or video link)"
                           class="w-full px-4 py-2.5 rounded-lg border text-sm transition-all focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                           :class="form.errors.media_url ? 'border-red-300' : 'border-slate-200'"/>
                    <p class="mt-1 text-xs text-slate-400">Link to an image, audio file, or video. Images will be displayed as thumbnails.</p>
                    <p v-if="form.errors.media_url" class="mt-1 text-xs text-red-500">{{ form.errors.media_url }}</p>
                </div>

                <!-- Display Order -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Display Order</label>
                    <input v-model.number="form.display_order" type="number" min="0"
                           class="w-full px-4 py-2.5 rounded-lg border text-sm transition-all focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                           :class="form.errors.display_order ? 'border-red-300' : 'border-slate-200'"/>
                    <p v-if="form.errors.display_order" class="mt-1 text-xs text-red-500">{{ form.errors.display_order }}</p>
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Slug</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">/</span>
                        <input v-model="form.slug" type="text" placeholder="auto-generated-from-title"
                               class="w-full pl-7 pr-4 py-2.5 rounded-lg border text-sm transition-all focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 font-mono"
                               :class="form.errors.slug ? 'border-red-300' : 'border-slate-200'"
                               :disabled="isEditing"/>
                    </div>
                    <p class="mt-1 text-xs text-slate-400">URL-friendly identifier. Auto-generated from title.</p>
                    <p v-if="form.errors.slug" class="mt-1 text-xs text-red-500">{{ form.errors.slug }}</p>
                </div>

                <!-- Body -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Body / Description</label>
                    <textarea v-model="form.body" rows="5" placeholder="Enter a detailed description..."
                              class="w-full px-4 py-2.5 rounded-lg border border-slate-200 text-sm transition-all focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 resize-none"></textarea>
                    <p v-if="form.errors.body" class="mt-1 text-xs text-red-500">{{ form.errors.body }}</p>
                </div>

                <!-- Active Toggle -->
                <div class="flex items-center gap-3 p-4 rounded-lg bg-slate-50 border border-slate-100">
                    <input v-model="form.is_active" type="checkbox" id="is_active"
                           class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"/>
                    <label for="is_active" class="text-sm font-medium text-slate-700 cursor-pointer">
                        Active (visible on public site)
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <Link :href="route('admin.music-records.index')"
                          class="px-5 py-2.5 rounded-lg border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                        Cancel
                    </Link>
                    <button type="submit" :disabled="form.processing"
                            class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed shadow-md shadow-indigo-500/20">
                        <span v-if="form.processing" class="flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            Saving...
                        </span>
                        <span v-else>{{ isEditing ? 'Update Record' : 'Create Record' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
