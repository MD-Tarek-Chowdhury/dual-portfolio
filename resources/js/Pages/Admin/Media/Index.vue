<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin.vue';
import { ref } from 'vue';

const props = defineProps({
    heroImages: { type: Object, default: () => ({}) },
});

const imageKeys = [
    { key: 'hero_parent_image', label: 'Parent Landing Hero', description: 'Displayed on the main landing page' },
    { key: 'hero_academic_image', label: 'Academic Hero', description: 'Displayed on the academic portfolio pages' },
    { key: 'hero_music_image', label: 'Music Hero', description: 'Displayed on the music portfolio pages' },
];

const selectedKey = ref('hero_parent_image');
const previewUrl = ref(null);

const form = useForm({
    image: null,
    setting_key: selectedKey.value,
});

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        form.setting_key = selectedKey.value;
        previewUrl.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    form.post(route('admin.media.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            previewUrl.value = null;
        },
    });
};

const selectKey = (key) => {
    selectedKey.value = key;
    form.setting_key = key;
    previewUrl.value = null;
    form.image = null;
};
</script>

<template>
    <Head title="Media Upload" />
    <AdminLayout>
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Header -->
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Media Upload</h2>
                <p class="text-slate-500 text-sm mt-1">Manage hero images for your portfolio pages.</p>
            </div>

            <!-- Image Cards -->
            <div class="grid md:grid-cols-3 gap-4">
                <div v-for="img in imageKeys" :key="img.key"
                     @click="selectKey(img.key)"
                     :class="[
                         'rounded-xl border-2 p-4 cursor-pointer transition-all duration-200',
                         selectedKey === img.key
                             ? 'border-indigo-500 bg-indigo-50 shadow-md shadow-indigo-500/10'
                             : 'border-slate-200 bg-white hover:border-slate-300'
                     ]">
                    <div class="aspect-video rounded-lg overflow-hidden mb-3 bg-slate-100">
                        <img v-if="props.heroImages[img.key.split('_')[1]]"
                             :src="props.heroImages[img.key.split('_')[1]]"
                             :alt="img.label"
                             class="w-full h-full object-cover"/>
                        <div v-else class="w-full h-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-semibold text-slate-700">{{ img.label }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ img.description }}</p>
                    <p v-if="props.heroImages[img.key.split('_')[1]]" class="text-xs text-emerald-600 mt-1.5 font-medium flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Uploaded
                    </p>
                </div>
            </div>

            <!-- Upload Section -->
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-1">Upload New Image</h3>
                <p class="text-sm text-slate-500 mb-6">Uploading to: <span class="font-medium text-indigo-600">{{ imageKeys.find(i => i.key === selectedKey)?.label }}</span></p>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Drop Zone -->
                    <div class="relative">
                        <input type="file" accept="image/jpeg,image/png" @change="handleFileChange"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"/>
                        <div :class="[
                            'border-2 border-dashed rounded-xl p-8 text-center transition-all duration-200',
                            previewUrl ? 'border-indigo-300 bg-indigo-50' : 'border-slate-300 hover:border-indigo-300 hover:bg-slate-50'
                        ]">
                            <div v-if="previewUrl" class="space-y-4">
                                <img :src="previewUrl" alt="Preview" class="max-h-48 mx-auto rounded-lg shadow-md"/>
                                <p class="text-sm text-slate-600">{{ form.image?.name }}</p>
                                <p class="text-xs text-slate-400">{{ (form.image?.size / 1024 / 1024).toFixed(2) }} MB</p>
                            </div>
                            <div v-else class="space-y-3">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-slate-600">Click or drag image here</p>
                                <p class="text-xs text-slate-400">JPG or PNG, max 2MB</p>
                            </div>
                        </div>
                    </div>

                    <p v-if="form.errors.image" class="text-xs text-red-500">{{ form.errors.image }}</p>
                    <p v-if="form.errors.setting_key" class="text-xs text-red-500">{{ form.errors.setting_key }}</p>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3">
                        <button type="button" @click="previewUrl = null; form.image = null"
                                v-if="previewUrl"
                                class="px-5 py-2.5 rounded-lg border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                            Clear
                        </button>
                        <button type="submit" :disabled="!form.image || form.processing"
                                class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed shadow-md shadow-indigo-500/20">
                            <span v-if="form.processing" class="flex items-center gap-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                </svg>
                                Uploading...
                            </span>
                            <span v-else>Upload Image</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
