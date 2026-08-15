<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/Public.vue';
import { computed } from 'vue';

const props = defineProps({
    section: { type: String, default: null },
    records: { type: [Object, Array], default: () => ({}) },
    settings: { type: Object, default: () => ({}) },
    heroImage: { type: String, default: '' },
    defaultMood: { type: String, default: 'studio' },
    worldMap: { type: Object, default: () => ({}) },
});

const isSectionView = computed(() => !!props.section);

const sectionTitle = computed(() => {
    const titles = {
        band: 'The Band',
        discography: 'Discography',
        courses: 'Music Courses',
        booking: 'Booking & Contact',
    };
    return titles[props.section] || 'Music Portfolio';
});

const sectionDescription = computed(() => {
    const descs = {
        band: 'Meet the band, our story, and musical journey.',
        discography: 'Albums, singles, EPs, and released tracks.',
        courses: 'Music lessons, workshops, and educational programs.',
        booking: 'Book us for gigs, events, and collaborations.',
    };
    return descs[props.section] || 'Explore the musical world of performances, recordings, and creative expression.';
});

const sectionIcon = computed(() => {
    const icons = {
        band: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
        discography: 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3',
        courses: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        booking: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
    };
    return icons[props.section] || icons.discography;
});

const typeLabels = {
    band_info: 'Band Info',
    discography: 'Discography',
    instrument: 'Instrument',
    course: 'Course',
};

const typeColors = {
    band_info: 'bg-orange-100 text-orange-700',
    discography: 'bg-rose-100 text-rose-700',
    instrument: 'bg-amber-100 text-amber-700',
    course: 'bg-emerald-100 text-emerald-700',
};
</script>

<template>
    <Head :title="section ? sectionTitle : 'Music Portfolio'" />
    <PublicLayout identity="music" :mood="defaultMood" :worldMap="worldMap">
        <!-- Hero Section -->
        <section class="relative h-[50vh] min-h-[350px] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0">
                <img :src="heroImage" alt="Music Hero" class="w-full h-full object-cover" />
                <div class="absolute inset-0" style="background: var(--hero-overlay);"></div>
            </div>
            <div class="relative z-10 text-center px-4">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium mb-4 glass text-white/80">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="sectionIcon"/>
                    </svg>
                    {{ section ? sectionTitle : 'Music Portfolio' }}
                </div>
                <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
                    {{ section ? sectionTitle : settings.siteTitleMusic || 'Sonic Temple' }}
                </h1>
                <p class="text-white/60 max-w-xl mx-auto text-sm md:text-base">
                    {{ sectionDescription }}
                </p>
            </div>
        </section>

        <!-- Content -->
        <section class="py-16 px-4" style="background: var(--bg); min-height: 50vh;">
            <div class="max-w-6xl mx-auto">

                <!-- Section View (Single Section) -->
                <template v-if="isSectionView">
                    <!-- Back Link -->
                    <Link :href="route('music')"
                          class="inline-flex items-center gap-2 text-sm mb-8 opacity-60 hover:opacity-100 transition-opacity"
                          style="color: var(--text);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Overview
                    </Link>

                    <!-- Records Grid -->
                    <div v-if="records.data && records.data.length" class="space-y-6">
                        <div v-for="record in records.data" :key="record.id"
                             class="record-card rounded-xl p-6 transition-all duration-300"
                             style="background: var(--surface); border: 1px solid var(--border);">
                            <div class="flex flex-col md:flex-row gap-5">
                                <!-- Media -->
                                <div v-if="record.media_url" class="md:w-48 shrink-0">
                                    <div class="aspect-square rounded-lg overflow-hidden" style="background: var(--bg);">
                                        <img v-if="record.media_url.match(/\.(jpg|jpeg|png|gif|webp)$/i)"
                                             :src="record.media_url"
                                             :alt="record.title"
                                             class="w-full h-full object-cover" />
                                        <div v-else class="w-full h-full flex items-center justify-center">
                                            <svg class="w-10 h-10 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span :class="['px-2.5 py-0.5 rounded-full text-xs font-medium', typeColors[record.record_type] || 'bg-slate-100 text-slate-600']">
                                            {{ typeLabels[record.record_type] || record.record_type }}
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-semibold mb-2" style="color: var(--text);">{{ record.title }}</h3>
                                    <div v-if="record.media_url && !record.media_url.match(/\.(jpg|jpeg|png|gif|webp)$/i)" class="mb-3">
                                        <a :href="record.media_url" target="_blank" rel="noopener"
                                           class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg transition-colors"
                                           style="background: var(--accent); color: var(--bg);">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Listen / Watch
                                        </a>
                                    </div>
                                    <p v-if="record.body" class="text-sm leading-relaxed" style="color: var(--muted);">
                                        {{ record.body }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div v-if="records.links" class="flex justify-center mt-8">
                            <div class="flex items-center gap-1">
                                <template v-for="(link, index) in records.links" :key="index">
                                    <div v-if="link.url === null"
                                         class="px-3 py-1.5 rounded-md text-sm opacity-40 cursor-not-allowed"
                                         style="color: var(--muted);"
                                         v-html="link.label"/>
                                    <Link v-else
                                          :href="link.url"
                                          :class="[
                                              'px-3 py-1.5 rounded-md text-sm font-medium transition-all duration-200',
                                              link.active
                                                  ? 'text-white'
                                                  : 'opacity-60 hover:opacity-100'
                                          ]"
                                          :style="link.active ? { background: 'var(--secondary)' } : { color: 'var(--text)' }"
                                          v-html="link.label"/>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-else class="text-center py-20">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4"
                             style="background: var(--surface); border: 1px solid var(--border);">
                            <svg class="w-8 h-8 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" :d="sectionIcon"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium mb-2" style="color: var(--text);">No records found</h3>
                        <p class="text-sm opacity-50" style="color: var(--muted);">Check back later for updates.</p>
                    </div>
                </template>

                <!-- Overview View (All Sections) -->
                <template v-else>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div v-for="(sectionRecords, type) in records" :key="type" class="space-y-4">
                            <!-- Section Header -->
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-semibold flex items-center gap-2" style="color: var(--text);">
                                    <span class="w-2 h-2 rounded-full" style="background: var(--accent);"></span>
                                    {{ typeLabels[type] || type }}
                                </h2>
                                <Link :href="route('music', type)"
                                      class="text-xs font-medium opacity-60 hover:opacity-100 transition-opacity flex items-center gap-1"
                                      style="color: var(--accent);">
                                    View All
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </Link>
                            </div>

                            <!-- Section Cards -->
                            <div v-if="sectionRecords && sectionRecords.length" class="space-y-3">
                                <div v-for="record in sectionRecords.slice(0, 3)" :key="record.id"
                                     class="record-card rounded-lg p-4 transition-all duration-300"
                                     style="background: var(--surface); border: 1px solid var(--border);">
                                    <div class="flex items-start gap-3">
                                        <div v-if="record.media_url" class="w-12 h-12 rounded-lg overflow-hidden shrink-0" style="background: var(--bg);">
                                            <img v-if="record.media_url.match(/\.(jpg|jpeg|png|gif|webp)$/i)"
                                                 :src="record.media_url" :alt="record.title" class="w-full h-full object-cover" />
                                            <div v-else class="w-full h-full flex items-center justify-center">
                                                <svg class="w-5 h-5 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-sm truncate" style="color: var(--text);">{{ record.title }}</h4>
                                            <p v-if="record.body" class="text-xs mt-1 line-clamp-2" style="color: var(--muted);">
                                                {{ record.body }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="rounded-lg p-6 text-center" style="background: var(--surface); border: 1px dashed var(--border);">
                                <p class="text-sm opacity-40" style="color: var(--muted);">No {{ type }} records yet</p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </section>
    </PublicLayout>
</template>
