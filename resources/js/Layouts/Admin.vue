<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const sidebarOpen = ref(true);
const mobileSidebarOpen = ref(false);

const user = page.props.auth?.user;

const navItems = [
    { label: 'Dashboard', route: 'admin.dashboard', icon: 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z' },
    { label: 'Academic Records', route: 'admin.academic-records.index', icon: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253' },
    { label: 'Music Records', route: 'admin.music-records.index', icon: 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3' },
    { label: 'Settings', route: 'admin.settings.index', icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z' },
    { label: 'Media Upload', route: 'admin.media.index', icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z' },
    { label: 'Trash Bin', route: 'admin.trash.index', icon: 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' },
    { label: 'Contact Submissions', route: 'admin.contact-submissions.index', icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' },
];

const isActive = (routeName) => {
    return page.url.startsWith(route(routeName));
};
</script>

<template>
    <div class="min-h-screen bg-slate-50 flex">
        <!-- Mobile Sidebar Overlay -->
        <div v-if="mobileSidebarOpen" @click="mobileSidebarOpen = false"
             class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

        <!-- Sidebar -->
        <aside :class="[
            'fixed lg:static inset-y-0 left-0 z-50 bg-slate-900 text-white transition-all duration-300 flex flex-col',
            sidebarOpen ? 'w-64' : 'w-20',
            mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
        ]">
            <!-- Header -->
            <div class="h-16 flex items-center justify-between px-4 border-b border-slate-700">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center font-bold text-sm shrink-0">
                        DP
                    </div>
                    <span v-if="sidebarOpen" class="font-semibold text-sm whitespace-nowrap">Dual Portfolio</span>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block p-1 rounded hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path v-if="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                        <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            <!-- Nav -->
            <nav class="flex-1 py-4 px-2 space-y-1 overflow-y-auto">
                <Link v-for="item in navItems" :key="item.route"
                      :href="route(item.route)"
                      @click="mobileSidebarOpen = false"
                      :class="[
                          'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200',
                          isActive(item.route)
                              ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25'
                              : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                      ]">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon"/>
                    </svg>
                    <span v-if="sidebarOpen" class="whitespace-nowrap">{{ item.label }}</span>
                </Link>
            </nav>

            <!-- User -->
            <div class="p-4 border-t border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-sm font-medium shrink-0">
                        {{ user?.name?.charAt(0) || 'A' }}
                    </div>
                    <div v-if="sidebarOpen" class="overflow-hidden">
                        <p class="text-sm font-medium truncate">{{ user?.name || 'Admin' }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ user?.email || '' }}</p>
                    </div>
                </div>
                <Link v-if="sidebarOpen" :href="route('landing')"
                      class="mt-3 flex items-center gap-2 text-xs text-slate-400 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Site
                </Link>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Bar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="mobileSidebarOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-slate-100">
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="text-xl font-semibold text-slate-800">{{ $page.props.title || 'Dashboard' }}</h1>
                </div>
                <div class="flex items-center gap-3">
                    <Link :href="route('logout')" method="post" as="button"
                          class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Logout</span>
                    </Link>
                </div>
            </header>

            <!-- Flash Messages -->
            <FlashMessages />

            <!-- Page Content -->
            <main class="flex-1 p-4 lg:p-8 overflow-y-auto">
                <slot />
            </main>
        </div>
    </div>
</template>
