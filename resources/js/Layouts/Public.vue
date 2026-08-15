<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    title: { type: String, default: '' },
    identity: { type: String, default: null }, // 'academic' | 'music'
    mood: { type: String, default: null },
    worldMap: { type: Object, default: () => ({}) },
});

const page = usePage();
const currentMood = ref(props.mood || 'day');
const showWorldSwitch = ref(false);
const mobileMenuOpen = ref(false);

const isAcademic = computed(() => props.identity === 'academic');
const isMusic = computed(() => props.identity === 'music');

const themeClass = computed(() => {
    if (isAcademic.value) return `theme-academic-${currentMood.value}`;
    if (isMusic.value) return `theme-music-${currentMood.value}`;
    return 'theme-academic-day';
});

const settings = computed(() => page.props.settings || {});
const auth = computed(() => page.props.auth || {});

const academicNav = [
    { label: 'Bio', route: 'academic', section: 'bio' },
    { label: 'Research', route: 'academic', section: 'research' },
    { label: 'Teaching', route: 'academic', section: 'teaching' },
    { label: 'Contact', route: 'academic', section: 'contact' },
];

const musicNav = [
    { label: 'Band', route: 'music', section: 'band' },
    { label: 'Discography', route: 'music', section: 'discography' },
    { label: 'Courses', route: 'music', section: 'courses' },
    { label: 'Booking', route: 'music', section: 'booking' },
];

const currentNav = computed(() => isAcademic.value ? academicNav : musicNav);

const toggleMood = () => {
    currentMood.value = currentMood.value === 'day' || currentMood.value === 'studio'
        ? (isAcademic.value ? 'evening' : 'club')
        : (isAcademic.value ? 'day' : 'studio');
};

const getOppositeWorld = (currentSection) => {
    if (!props.worldMap || !currentSection) return isAcademic.value ? 'music' : 'academic';
    const mapped = props.worldMap[currentSection];
    return mapped || (isAcademic.value ? 'music' : 'academic');
};

const getOppositeSection = (currentSection) => {
    if (!props.worldMap || !currentSection) return null;
    return props.worldMap[currentSection];
};

onMounted(() => {
    if (props.mood) currentMood.value = props.mood;
    setTimeout(() => showWorldSwitch.value = true, 800);
});
</script>

<template>
    <div :class="[themeClass, 'theme-transition min-h-screen flex flex-col']"
         style="background-color: var(--bg); color: var(--text);">

        <!-- Navigation -->
        <nav class="sticky top-0 z-50 glass" style="border-bottom: 1px solid var(--border);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <Link :href="route('landing')" class="flex items-center gap-2 group">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm"
                             :style="{ background: 'var(--accent)', color: 'var(--bg)' }">
                            DP
                        </div>
                        <span class="font-serif text-lg font-semibold tracking-tight group-hover:opacity-80 transition-opacity">
                            {{ isAcademic ? settings.siteTitleAcademic : isMusic ? settings.siteTitleMusic : 'Dual Portfolio' }}
                        </span>
                    </Link>

                    <!-- Desktop Nav -->
                    <div class="hidden md:flex items-center gap-1">
                        <template v-if="identity">
                            <Link v-for="item in currentNav" :key="item.section"
                                  :href="route(item.route, item.section)"
                                  class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-200"
                                  :class="$page.url.includes(item.section) ? 'opacity-100' : 'opacity-60 hover:opacity-100'"
                                  :style="$page.url.includes(item.section) ? { background: 'var(--surface)', color: 'var(--primary)' } : {}"
                                  style="color: var(--text);">
                                {{ item.label }}
                            </Link>
                        </template>
                        <Link v-else :href="route('landing')"
                              class="px-3 py-2 rounded-md text-sm font-medium opacity-60 hover:opacity-100 transition-opacity"
                              style="color: var(--text);">
                            Home
                        </Link>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center gap-3">
                        <!-- Mood Toggle -->
                        <button v-if="identity" @click="toggleMood"
                                class="p-2 rounded-full transition-all duration-300 hover:scale-110"
                                :title="`Switch to ${currentMood === 'day' || currentMood === 'studio' ? (isAcademic ? 'evening' : 'club') : (isAcademic ? 'day' : 'studio')}`"
                                style="background: var(--surface); border: 1px solid var(--border);">
                            <svg v-if="isAcademic" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path v-if="currentMood === 'day'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path v-if="currentMood === 'studio'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </button>

                        <!-- Admin Link -->
                        <Link v-if="auth.user" :href="route('admin.dashboard')"
                              class="hidden md:flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-medium transition-all"
                              style="background: var(--accent); color: var(--bg);">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Admin
                        </Link>

                        <!-- Mobile Menu Button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-md"
                                style="color: var(--text);">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div v-if="mobileMenuOpen" class="md:hidden pb-4 space-y-1 animate-fade-in-up"
                     style="border-top: 1px solid var(--border);">
                    <template v-if="identity">
                        <Link v-for="item in currentNav" :key="item.section"
                              :href="route(item.route, item.section)"
                              @click="mobileMenuOpen = false"
                              class="block px-3 py-2 rounded-md text-sm font-medium transition-opacity"
                              :class="$page.url.includes(item.section) ? 'opacity-100' : 'opacity-60'"
                              style="color: var(--text);">
                            {{ item.label }}
                        </Link>
                    </template>
                    <Link v-if="auth.user" :href="route('admin.dashboard')"
                          class="block px-3 py-2 rounded-md text-sm font-medium"
                          style="color: var(--accent);">
                        Admin Dashboard
                    </Link>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="py-8 mt-auto" style="border-top: 1px solid var(--border); background: var(--surface);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-sm opacity-60" style="color: var(--muted);">
                        {{ settings.footerCopyright || '© 2026 – All Rights Reserved' }}
                    </p>
                    <div class="flex items-center gap-4">
                        <Link :href="route('landing')" class="text-sm opacity-60 hover:opacity-100 transition-opacity" style="color: var(--muted);">
                            Home
                        </Link>
                        <Link :href="route('contact')" class="text-sm opacity-60 hover:opacity-100 transition-opacity" style="color: var(--muted);">
                            Contact
                        </Link>
                    </div>
                </div>
            </div>
        </footer>

        <!-- World Switch Widget -->
        <Transition name="world-switch">
            <div v-if="showWorldSwitch && identity"
                 class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-2">

                <!-- Tooltip -->
                <div v-if="showWorldSwitch" class="px-3 py-1.5 rounded-lg text-xs font-medium glass mb-1"
                     style="color: var(--text);">
                    Switch to {{ isAcademic ? 'Music' : 'Academic' }} World
                </div>

                <!-- Switch Button -->
                <Link :href="route(isAcademic ? 'music' : 'academic', getOppositeSection($page.props.section))"
                      class="world-switch-active w-14 h-14 rounded-full flex items-center justify-center shadow-2xl transition-transform hover:scale-110 active:scale-95"
                      :style="{ background: isAcademic ? 'var(--color-music-studio-secondary)' : 'var(--color-academic-day-secondary)' }"
                      :title="`Switch to ${isAcademic ? 'Music' : 'Academic'} World`">
                    <svg v-if="isAcademic" class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                    <svg v-else class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </Link>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
.world-switch-enter-active,
.world-switch-leave-active {
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.world-switch-enter-from,
.world-switch-leave-to {
    opacity: 0;
    transform: translateY(20px) scale(0.8);
}
</style>
