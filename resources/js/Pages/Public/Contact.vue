<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/Public.vue';
import { ref } from 'vue';

const props = defineProps({
    settings: { type: Object, default: () => ({}) },
    academicContact: { type: Object, default: () => ({}) },
    musicContact: { type: Object, default: () => ({}) },
});

const form = useForm({
    contact_type: 'academic',
    name: '',
    email: '',
    subject: '',
    message: '',
});

const submitting = ref(false);

const submit = () => {
    submitting.value = true;
    form.post(route('contact.store'), {
        preserveScroll: true,
        onFinish: () => {
            submitting.value = false;
            if (!form.hasErrors) {
                form.reset('name', 'email', 'subject', 'message');
            }
        },
    });
};

const contactTypes = [
    { value: 'academic', label: 'Academic Inquiry' },
    { value: 'music', label: 'Music / Booking' },
];
</script>

<template>
    <Head title="Contact" />
    <PublicLayout>
        <!-- Hero -->
        <section class="relative h-[35vh] min-h-[280px] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0" style="background: linear-gradient(135deg, #1e3a5f 0%, #7c2d12 100%);"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
            </div>
            <div class="relative z-10 text-center px-4">
                <h1 class="font-serif text-4xl md:text-5xl font-bold text-white mb-3">Get in Touch</h1>
                <p class="text-white/60 max-w-lg mx-auto text-sm md:text-base">
                    Whether it's academic collaboration or a gig booking, I'd love to hear from you.
                </p>
            </div>
        </section>

        <!-- Contact Cards -->
        <section class="py-16 px-4" style="background: var(--bg);">
            <div class="max-w-5xl mx-auto">
                <!-- Dual Contact Display -->
                <div class="grid md:grid-cols-2 gap-6 mb-12">
                    <!-- Academic Contact Card -->
                    <div class="rounded-2xl p-8 transition-all duration-300 hover:shadow-xl"
                         style="background: var(--surface); border: 2px solid #3b82f6;">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold" style="color: var(--text);">Academic Contact</h2>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider opacity-50" style="color: var(--muted);">Email</p>
                                    <a :href="`mailto:${academicContact.email}`" class="text-sm font-medium hover:underline" style="color: var(--text);">
                                        {{ academicContact.email }}
                                    </a>
                                </div>
                            </div>
                            <div v-if="academicContact.office" class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider opacity-50" style="color: var(--muted);">Office</p>
                                    <p class="text-sm font-medium" style="color: var(--text);">{{ academicContact.office }}</p>
                                </div>
                            </div>
                            <div v-if="academicContact.hours" class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider opacity-50" style="color: var(--muted);">Hours</p>
                                    <p class="text-sm font-medium" style="color: var(--text);">{{ academicContact.hours }}</p>
                                </div>
                            </div>
                            <div v-if="academicContact.phone" class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider opacity-50" style="color: var(--muted);">Phone</p>
                                    <p class="text-sm font-medium" style="color: var(--text);">{{ academicContact.phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Music Contact Card -->
                    <div class="rounded-2xl p-8 transition-all duration-300 hover:shadow-xl"
                         style="background: var(--surface); border: 2px solid #ec4899;">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-pink-500/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold" style="color: var(--text);">Music Contact</h2>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider opacity-50" style="color: var(--muted);">Email</p>
                                    <a :href="`mailto:${musicContact.email}`" class="text-sm font-medium hover:underline" style="color: var(--text);">
                                        {{ musicContact.email }}
                                    </a>
                                </div>
                            </div>
                            <div v-if="musicContact.studio" class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider opacity-50" style="color: var(--muted);">Studio</p>
                                    <p class="text-sm font-medium" style="color: var(--text);">{{ musicContact.studio }}</p>
                                </div>
                            </div>
                            <div v-if="musicContact.booking" class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider opacity-50" style="color: var(--muted);">Booking</p>
                                    <p class="text-sm font-medium" style="color: var(--text);">{{ musicContact.booking }}</p>
                                </div>
                            </div>
                            <div v-if="musicContact.phone" class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider opacity-50" style="color: var(--muted);">Phone</p>
                                    <p class="text-sm font-medium" style="color: var(--text);">{{ musicContact.phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="rounded-2xl p-8" style="background: var(--surface); border: 1px solid var(--border);">
                    <h2 class="text-2xl font-bold mb-2 text-center" style="color: var(--text);">Send a Message</h2>
                    <p class="text-sm text-center mb-8 opacity-60" style="color: var(--muted);">Fill out the form below and I'll get back to you as soon as possible.</p>

                    <form @submit.prevent="submit" class="max-w-2xl mx-auto space-y-5">
                        <!-- Contact Type -->
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text);">Contact Type</label>
                            <div class="grid grid-cols-2 gap-3">
                                <button v-for="type in contactTypes" :key="type.value" type="button"
                                        @click="form.contact_type = type.value"
                                        :class="[
                                            'px-4 py-3 rounded-lg text-sm font-medium border-2 transition-all duration-200',
                                            form.contact_type === type.value
                                                ? 'border-blue-500 bg-blue-50 text-blue-700'
                                                : 'border-slate-200 text-slate-600 hover:border-slate-300'
                                        ]">
                                    {{ type.label }}
                                </button>
                            </div>
                            <p v-if="form.errors.contact_type" class="mt-1 text-xs text-red-500">{{ form.errors.contact_type }}</p>
                        </div>

                        <!-- Name & Email -->
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color: var(--text);">Name</label>
                                <input v-model="form.name" type="text" placeholder="Your name"
                                       class="w-full px-4 py-3 rounded-lg border text-sm transition-all focus:ring-2"
                                       :class="form.errors.name ? 'border-red-300 focus:ring-red-200' : 'border-slate-200 focus:ring-blue-200 focus:border-blue-400'"
                                       style="background: var(--bg); color: var(--text);" />
                                <p v-if="form.errors.name" class="mt-1 text-xs text-red-500">{{ form.errors.name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color: var(--text);">Email</label>
                                <input v-model="form.email" type="email" placeholder="your@email.com"
                                       class="w-full px-4 py-3 rounded-lg border text-sm transition-all focus:ring-2"
                                       :class="form.errors.email ? 'border-red-300 focus:ring-red-200' : 'border-slate-200 focus:ring-blue-200 focus:border-blue-400'"
                                       style="background: var(--bg); color: var(--text);" />
                                <p v-if="form.errors.email" class="mt-1 text-xs text-red-500">{{ form.errors.email }}</p>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text);">Subject</label>
                            <input v-model="form.subject" type="text" placeholder="What's this about?"
                                   class="w-full px-4 py-3 rounded-lg border text-sm transition-all focus:ring-2"
                                   :class="form.errors.subject ? 'border-red-300 focus:ring-red-200' : 'border-slate-200 focus:ring-blue-200 focus:border-blue-400'"
                                   style="background: var(--bg); color: var(--text);" />
                            <p v-if="form.errors.subject" class="mt-1 text-xs text-red-500">{{ form.errors.subject }}</p>
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text);">Message</label>
                            <textarea v-model="form.message" rows="5" placeholder="Write your message here..."
                                      class="w-full px-4 py-3 rounded-lg border text-sm transition-all focus:ring-2 resize-none"
                                      :class="form.errors.message ? 'border-red-300 focus:ring-red-200' : 'border-slate-200 focus:ring-blue-200 focus:border-blue-400'"
                                      style="background: var(--bg); color: var(--text);"></textarea>
                            <p v-if="form.errors.message" class="mt-1 text-xs text-red-500">{{ form.errors.message }}</p>
                        </div>

                        <!-- Submit & Rate Limit -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
                            <button type="submit" :disabled="form.processing || submitting"
                                    class="w-full sm:w-auto px-8 py-3 rounded-lg text-sm font-semibold text-white transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                                    :style="{ background: form.contact_type === 'academic' ? '#3b82f6' : '#ec4899' }">
                                <span v-if="form.processing || submitting" class="flex items-center gap-2">
                                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                    </svg>
                                    Sending...
                                </span>
                                <span v-else>Send Message</span>
                            </button>

                            <div class="flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-medium"
                                 style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Rate Limit: 5 messages / 60 min
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer Note -->
                <p class="text-center text-xs mt-6 opacity-40" style="color: var(--muted);">
                    Emails queued via Database Queue • Flash messages via Inertia shared data
                </p>
            </div>
        </section>
    </PublicLayout>
</template>
