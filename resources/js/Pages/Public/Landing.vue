<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/Public.vue';

const props = defineProps({
    settings: { type: Object, default: () => ({}) },
    heroImage: { type: String, default: '' },
});
</script>

<template>
    <Head title="Welcome" />
    <PublicLayout>
        <!-- Hero Section -->
        <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img :src="heroImage" alt="Hero" class="w-full h-full object-cover" />
                <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(15,23,42,0.85) 0%, rgba(30,58,95,0.75) 50%, rgba(124,45,18,0.7) 100%);"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
                <div class="animate-fade-in-up">
                    <p class="text-sm md:text-base tracking-[0.3em] uppercase mb-4 text-white/70 font-medium">
                        Two Worlds. One Portfolio.
                    </p>
                    <h1 class="font-serif text-5xl md:text-7xl lg:text-8xl font-bold text-white mb-6 leading-tight">
                        Choose Your<br/>Path
                    </h1>
                    <p class="text-lg md:text-xl text-white/60 mb-12 max-w-2xl mx-auto leading-relaxed">
                        Explore the dual identity of a passionate academic and a dedicated musician.
                        Each world tells a different story.
                    </p>
                </div>

                <!-- Dual CTA Cards -->
                <div class="grid md:grid-cols-2 gap-6 max-w-3xl mx-auto">
                    <!-- Academic Card -->
                    <Link :href="route('academic')"
                          class="group relative overflow-hidden rounded-2xl p-8 text-left transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl"
                          style="background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.15);">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-400/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                        <div class="relative z-10">
                            <div class="w-14 h-14 rounded-xl bg-blue-500/20 flex items-center justify-center mb-5 group-hover:bg-blue-500/30 transition-colors">
                                <svg class="w-7 h-7 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-serif font-bold text-white mb-2">Academic World</h2>
                            <p class="text-white/50 text-sm mb-5 leading-relaxed">Research, publications, teaching, and scholarly achievements in academia.</p>
                            <div class="flex items-center gap-2 text-blue-300 text-sm font-medium group-hover:gap-3 transition-all">
                                Enter Academia
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </Link>

                    <!-- Music Card -->
                    <Link :href="route('music')"
                          class="group relative overflow-hidden rounded-2xl p-8 text-left transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl"
                          style="background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.15);">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-400/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                        <div class="relative z-10">
                            <div class="w-14 h-14 rounded-xl bg-orange-500/20 flex items-center justify-center mb-5 group-hover:bg-orange-500/30 transition-colors">
                                <svg class="w-7 h-7 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-serif font-bold text-white mb-2">Music World</h2>
                            <p class="text-white/50 text-sm mb-5 leading-relaxed">Band performances, discography, instruments, and music courses.</p>
                            <div class="flex items-center gap-2 text-orange-300 text-sm font-medium group-hover:gap-3 transition-all">
                                Enter Music
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>

            <!-- Scroll Indicator -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
                <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </section>

        <!-- About Section -->
        <section class="py-24 px-4" style="background: var(--bg);">
            <div class="max-w-4xl mx-auto text-center">
                <p class="text-sm tracking-[0.2em] uppercase mb-4 font-medium" style="color: var(--accent);">About This Portfolio</p>
                <h2 class="font-serif text-3xl md:text-4xl font-bold mb-6" style="color: var(--text);">A Life of Dual Passions</h2>
                <p class="text-lg leading-relaxed max-w-2xl mx-auto" style="color: var(--muted);">
                    This portfolio showcases the journey of someone who has dedicated their life to both
                    rigorous academic pursuit and creative musical expression. Each world is a testament
                    to the belief that intellectual depth and artistic passion can coexist and enrich one another.
                </p>
            </div>
        </section>
    </PublicLayout>
</template>
