<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/Public.vue';
import { computed } from 'vue';

const props = defineProps({
    section: { type: String, default: null },
    records: { type: [Object, Array], default: () => ({}) },
    settings: { type: Object, default: () => ({}) },
    heroImage: { type: String, default: '' },
    defaultMood: { type: String, default: 'day' },
    worldMap: { type: Object, default: () => ({}) },
});

const isSectionView = computed(() => !!props.section);

const sectionTitle = computed(() => {
    const titles = {
        bio: 'Biography',
        research: 'Research & Publications',
        teaching: 'Teaching & Courses',
        contact: 'Get in Touch',
    };
    return titles[props.section] || 'Academic Portfolio';
});

const sectionDescription = computed(() => {
    const descs = {
        bio: 'The academic journey, education, and professional background.',
        research: 'Published papers, ongoing research, and scholarly contributions.',
        teaching: 'Courses taught, workshops conducted, and educational materials.',
        contact: 'Reach out for collaborations, consultations, or academic inquiries.',
    };
    return descs[props.section] || 'Explore the academic world of research, teaching, and scholarly achievement.';
});

const sectionIcon = computed(() => {
    const icons = {
        bio: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
        research: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        teaching: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        contact: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
    };
    return icons[props.section] || icons.research;
});

const typeLabels = {
    publication: 'Publication',
    course: 'Course',
    designation: 'Designation',
    achievement: 'Achievement',
};

const typeColors = {
    publication: 'bg-blue-100 text-blue-700',
    course: 'bg-emerald-100 text-emerald-700',
    designation: 'bg-purple-100 text-purple-700',
    achievement: 'bg-amber-100 text-amber-700',
};
</script>

<template>
    <Head :title="section ? sectionTitle : 'Academic Portfolio'" />
    <PublicLayout identity="academic" :mood="defaultMood" :worldMap="worldMap">
        <!-- Hero Section -->
        <section class="relative h-[50vh] min-h-[350px] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0">
                <img :src="heroImage" alt="Academic Hero" class="w-full h-full object-cover" />
                <div class="absolute inset-0" style="background: var(--hero-overlay);"></div>
            </div>
            <div class="relative z-10 text-center px-4">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium mb-4 glass text-white/80">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="sectionIcon"/>
                    </svg>
                    {{ section ? sectionTitle : 'Academic Portfolio' }}
                </div>
                <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
                    {{ section ? sectionTitle : settings.siteTitleAcademic || 'Dr. Portfolio' }}
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
                    <Link :href="route('academic')"
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
                            <div class="flex flex-col md:flex-row md:items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span :class="['px-2.5 py-0.5 rounded-full text-xs font-medium', typeColors[record.record_type] || 'bg-slate-100 text-slate-600']">
                                            {{ typeLabels[record.record_type] || record.record_type }}
                                        </span>
                                        <span v-if="record.date_or_year" class="text-xs opacity-50" style="color: var(--muted);">
                                            {{ record.date_or_year }}
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-semibold mb-2" style="color: var(--text);">{{ record.title }}</h3>
                                    <p v-if="record.subtitle_or_institution" class="text-sm mb-3 font-medium" style="color: var(--secondary);">
                                        {{ record.subtitle_or_institution }}
                                    </p>
                                    <p v-if="record.description" class="text-sm leading-relaxed" style="color: var(--muted);">
                                        {{ record.description }}
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
                                <Link :href="route('academic', type)"
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
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-sm truncate" style="color: var(--text);">{{ record.title }}</h4>
                                            <p v-if="record.subtitle_or_institution" class="text-xs mt-1 truncate" style="color: var(--muted);">
                                                {{ record.subtitle_or_institution }}
                                            </p>
                                            <p v-if="record.date_or_year" class="text-xs mt-1 opacity-50" style="color: var(--muted);">
                                                {{ record.date_or_year }}
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
