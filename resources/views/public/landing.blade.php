{{-- resources/views/public/landing.blade.php --}}
@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="min-h-screen flex flex-col">
    {{-- Hero Section: Split Screen --}}
    <div class="flex-1 flex flex-col md:flex-row min-h-[calc(100vh-4rem)]">

        {{-- Left Panel: Academic --}}
        <a href="{{ route('academic') }}"
           class="group relative flex-1 flex flex-col items-center justify-center bg-gradient-to-br from-white to-blue-50 hover:from-blue-50 hover:to-blue-100 transition-all duration-500 p-8 md:p-12 border-b md:border-b-0 md:border-r border-gray-200 overflow-hidden">

            {{-- Background Pattern --}}
            <div class="absolute inset-0 opacity-5">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <pattern id="academic-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="#6495ED"/>
                    </pattern>
                    <rect width="100" height="100" fill="url(#academic-pattern)"/>
                </svg>
            </div>

            @if($heroImage)
                <div class="absolute inset-0 opacity-10">
                    <img src="{{ $heroImage }}" alt="" class="w-full h-full object-cover" loading="eager">
                </div>
            @endif

            <div class="relative z-10 text-center max-w-md">
                <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-academic/10 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-academic" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-slate-800 mb-4 tracking-tight">
                    The <span class="text-academic">Scholar</span>
                </h1>

                <p class="text-lg text-slate-500 mb-8 leading-relaxed">
                    Explore research, publications, courses, and academic achievements.
                </p>

                <span class="inline-flex items-center px-6 py-3 bg-academic text-white rounded-xl font-medium hover:bg-academic-dark transition-colors duration-300 shadow-lg shadow-academic/20">
                    Enter Academia
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </span>
            </div>

            {{-- Decorative Corner --}}
            <div class="absolute top-6 left-6 text-academic/20">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
        </a>

        {{-- Right Panel: Music --}}
        <a href="{{ route('music') }}"
           class="group relative flex-1 flex flex-col items-center justify-center bg-gradient-to-br from-stone-50 to-red-50 hover:from-red-50 hover:to-red-100 transition-all duration-500 p-8 md:p-12 overflow-hidden">

            {{-- Background Pattern --}}
            <div class="absolute inset-0 opacity-5">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <pattern id="music-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="#722F37"/>
                    </pattern>
                    <rect width="100" height="100" fill="url(#music-pattern)"/>
                </svg>
            </div>

            @if($heroImage)
                <div class="absolute inset-0 opacity-10">
                    <img src="{{ $heroImage }}" alt="" class="w-full h-full object-cover" loading="eager">
                </div>
            @endif

            <div class="relative z-10 text-center max-w-md">
                <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-music/10 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-music" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-slate-800 mb-4 tracking-tight">
                    The <span class="text-music">Musician</span>
                </h1>

                <p class="text-lg text-slate-500 mb-8 leading-relaxed">
                    Discover the band, discography, instruments, and music courses.
                </p>

                <span class="inline-flex items-center px-6 py-3 bg-music text-white rounded-xl font-medium hover:bg-music/90 transition-colors duration-300 shadow-lg shadow-music/20">
                    Enter Studio
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </span>
            </div>

            {{-- Decorative Corner --}}
            <div class="absolute bottom-6 right-6 text-music/20">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                </svg>
            </div>
        </a>
    </div>

    {{-- Minimal Footer --}}
    <footer class="bg-white border-t border-gray-200 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm text-gray-500">
                {{ $settings['footerCopyright'] ?? '© ' . date('Y') . ' – All Rights Reserved' }}
            </p>
        </div>
    </footer>
</div>
@endsection
