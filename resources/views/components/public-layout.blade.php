{{-- resources/views/components/public-layout.blade.php --}}
@props(['title', 'theme' => 'academic', 'heroImage' => null, 'heroTitle' => null, 'heroSubtitle' => null, 'defaultMood' => 'normal'])

@php
$isAcademic = $theme === 'academic';
$bgClass = $isAcademic ? 'bg-white' : 'bg-stone-50';
$navBgClass = $isAcademic ? 'bg-white/90 backdrop-blur-sm border-b border-gray-200' : 'bg-stone-900/90 backdrop-blur-sm border-b border-stone-800';
$textClass = $isAcademic ? 'text-slate-800' : 'text-stone-100';
$linkClass = $isAcademic ? 'text-slate-600 hover:text-academic' : 'text-stone-300 hover:text-music-neon';
$activeClass = $isAcademic ? 'text-academic border-b-2 border-academic' : 'music-nav-active';
$btnClass = $isAcademic ? 'bg-academic text-white hover:bg-academic-dark' : 'music-btn-primary';
$portalText = $isAcademic ? 'Switch to Music' : 'Switch to Academia';
$portalUrl = $isAcademic ? route('music') : route('academic');
$portalIcon = $isAcademic ? '🎸' : '🎓';
$moodMode = $isAcademic ? 'academic' : 'music';

$sections = $isAcademic
    ? ['bio' => 'Bio', 'research' => 'Research', 'teaching' => 'Teaching']
    : ['band' => 'Band', 'discography' => 'Discography', 'courses' => 'Courses'];
@endphp

@extends('layouts.app', ['moodMode' => $moodMode, 'defaultMood' => $defaultMood])

@section('title', $title)

@section('content')
<div class="mood-transition {{ $bgClass }}">
    {{-- Navigation --}}
    <nav class="fixed top-0 left-0 right-0 z-40 {{ $navBgClass }} mood-transition" x-data="mobileMenu()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                {{-- Logo --}}
                <div class="flex items-center">
                    <a href="{{ route('landing') }}" class="text-xl font-bold {{ $textClass }} mood-transition">
                        {{ $isAcademic ? $settings['siteTitleAcademic'] ?? 'Dr. Portfolio' : $settings['siteTitleMusic'] ?? 'Band Name' }}
                    </a>
                </div>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center space-x-8">
                    @foreach($sections as $slug => $label)
                        <a href="{{ route($theme, $slug) }}"
                           class="px-1 py-5 text-sm font-medium transition-colors {{ request()->is($theme . '/' . $slug) ? $activeClass : $linkClass }}">
                            {{ $label }}
                        </a>
                    @endforeach

                    <a href="{{ route('contact') }}"
                       class="px-1 py-5 text-sm font-medium transition-colors {{ request()->is('contact') ? $activeClass : $linkClass }}">
                        Contact
                    </a>

                    {{-- Mood Toggle --}}
                    <div class="ml-4">
                        <x-mood-toggle :mode="$moodMode" />
                    </div>

                    {{-- Portal Link --}}
                    <a href="{{ $portalUrl }}"
                       class="ml-4 px-4 py-2 rounded-lg text-sm font-medium {{ $btnClass }} transition-all duration-300">
                        {{ $portalIcon }} {{ $portalText }}
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <div class="flex items-center md:hidden">
                    <button @click="toggle()" class="{{ $textClass }} p-2">
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-1"
             class="md:hidden {{ $isAcademic ? 'bg-white border-b border-gray-200' : 'bg-stone-900 border-b border-stone-800' }} mood-transition"
             style="display: none;">
            <div class="px-4 pt-2 pb-4 space-y-1">
                @foreach($sections as $slug => $label)
                    <a href="{{ route($theme, $slug) }}"
                       class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is($theme . '/' . $slug) ? ($isAcademic ? 'bg-academic/10 text-academic' : 'bg-music/20 text-music-neon') : $linkClass }}">
                        {{ $label }}
                    </a>
                @endforeach

                <a href="{{ route('contact') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('contact') ? ($isAcademic ? 'bg-academic/10 text-academic' : 'bg-music/20 text-music-neon') : $linkClass }}">
                    Contact
                </a>

                <div class="px-3 py-2">
                    <x-mood-toggle :mode="$moodMode" />
                </div>

                <a href="{{ $portalUrl }}"
                   class="block px-3 py-2 rounded-md text-base font-medium {{ $isAcademic ? 'bg-academic/10 text-academic' : 'bg-music/20 text-music-neon' }}">
                    {{ $portalIcon }} {{ $portalText }}
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero Banner --}}
    @if($heroImage)
    <div class="relative pt-16">
        <div class="relative h-64 md:h-80 lg:h-96 overflow-hidden {{ $isAcademic ? 'academic-hero' : 'music-hero' }} mood-transition">
            <img src="{{ $heroImage }}" alt="Hero" class="w-full h-full object-cover opacity-40 mood-transition" loading="eager">
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center px-4">
                    @if($heroTitle)
                        <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold {{ $isAcademic ? 'text-white text-shadow-lg' : 'text-white text-shadow-neon-cyan' }} mood-transition">
                            {{ $heroTitle }}
                        </h1>
                    @endif
                    @if($heroSubtitle)
                        <p class="mt-4 text-lg md:text-xl {{ $isAcademic ? 'text-white/90' : 'text-music-neon' }} mood-transition">
                            {{ $heroSubtitle }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="pt-16"></div>
    @endif

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{ $slot }}
    </div>

    {{-- Footer --}}
    <footer class="{{ $isAcademic ? 'bg-gray-50 border-t border-gray-200' : 'bg-stone-900 border-t border-stone-800' }} mood-transition">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm {{ $isAcademic ? 'text-gray-500' : 'text-stone-400' }} mood-transition">
                    {{ $settings['footerCopyright'] ?? '© ' . date('Y') . ' – All Rights Reserved' }}
                </p>
                <div class="mt-4 md:mt-0 flex space-x-6">
                    <a href="{{ route('sitemap') }}" class="text-sm {{ $isAcademic ? 'text-gray-500 hover:text-academic' : 'text-stone-400 hover:text-music-neon' }} mood-transition">Sitemap</a>
                    <a href="{{ route('robots') }}" class="text-sm {{ $isAcademic ? 'text-gray-500 hover:text-academic' : 'text-stone-400 hover:text-music-neon' }} mood-transition">Robots</a>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection
