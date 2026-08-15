<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin.vue';
import { computed } from 'vue';

const props = defineProps({
    settings: { type: Array, required: true },
});

// Group settings by category
const groupedSettings = computed(() => {
    const groups = {
        'Hero Images': [],
        'Site Identity': [],
        'Contact Info': [],
        'Theme': [],
        'Other': [],
    };

    const groupMap = {
        'hero_': 'Hero Images',
        'site_title_': 'Site Identity',
        'footer_': 'Site Identity',
        'contact_email_': 'Contact Info',
        'academic_': 'Contact Info',
        'music_': 'Contact Info',
        '_mood_': 'Theme',
        '_mood_default': 'Theme',
    };

    props.settings.forEach(setting => {
        let group = 'Other';
        for (const [prefix, g] of Object.entries(groupMap)) {
            if (setting.key.includes(prefix)) {
                group = g;
                break;
            }
        }
        groups[group].push(setting);
    });

    return Object.fromEntries(Object.entries(groups).filter(([, v]) => v.length > 0));
});

const form = useForm({
    settings: props.settings.map(s => ({
        key: s.key,
        value: s.value,
        type: s.type,
    })),
});

const getSettingByKey = (key) => {
    return form.settings.find(s => s.key === key);
};

const isImagePath = (type) => type === 'image_path';
const isBoolean = (type) => type === 'boolean';

const submit = () => {
    form.put(route('admin.settings.update'));
};

const getSettingIcon = (key) => {
    if (key.includes('hero')) return 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z';
    if (key.includes('email')) return 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z';
    if (key.includes('title')) return 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
    if (key.includes('mood')) return 'M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z';
    return 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z';
};
</script>

<template>
    <Head title="Settings" />
    <AdminLayout>
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Header -->
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Settings</h2>
                <p class="text-slate-500 text-sm mt-1">Manage global configuration for your portfolio.</p>
            </div>

            <form @submit.prevent="submit" class="space-y-8">
                <div v-for="(groupSettings, groupName) in groupedSettings" :key="groupName"
                     class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                    <!-- Group Header -->
                    <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100">
                        <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider">{{ groupName }}</h3>
                    </div>

                    <!-- Settings -->
                    <div class="divide-y divide-slate-100">
                        <div v-for="setting in groupSettings" :key="setting.key"
                             class="px-6 py-5 flex flex-col md:flex-row md:items-center gap-4">
                            <!-- Label -->
                            <div class="md:w-1/3 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" :d="getSettingIcon(setting.key)"/>
                                    </svg>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">{{ setting.label }}</label>
                                    <p class="text-xs text-slate-400 mt-0.5 font-mono">{{ setting.key }}</p>
                                </div>
                            </div>

                            <!-- Input -->
                            <div class="md:w-2/3">
                                <!-- Image Path -->
                                <div v-if="isImagePath(setting.type)" class="space-y-2">
                                    <input v-model="getSettingByKey(setting.key).value" type="text"
                                           class="w-full px-4 py-2.5 rounded-lg border border-slate-200 text-sm font-mono focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"/>
                                    <p class="text-xs text-slate-400">Path relative to storage. Use Media Upload for better management.</p>
                                </div>

                                <!-- Boolean -->
                                <div v-else-if="isBoolean(setting.type)" class="flex items-center gap-3">
                                    <input v-model="getSettingByKey(setting.key).value" type="checkbox"
                                           true-value="1" false-value="0"
                                           class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"/>
                                    <span class="text-sm text-slate-600">{{ getSettingByKey(setting.key).value === '1' || getSettingByKey(setting.key).value === true ? 'Enabled' : 'Disabled' }}</span>
                                </div>

                                <!-- Text -->
                                <input v-else v-model="getSettingByKey(setting.key).value" type="text"
                                       class="w-full px-4 py-2.5 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"/>

                                <p v-if="form.errors[`settings.${setting.key}.value`]" class="mt-1 text-xs text-red-500">
                                    {{ form.errors[`settings.${setting.key}.value`] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-end gap-3">
                    <button type="submit" :disabled="form.processing"
                            class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed shadow-md shadow-indigo-500/20">
                        <span v-if="form.processing" class="flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            Saving...
                        </span>
                        <span v-else>Save Settings</span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
