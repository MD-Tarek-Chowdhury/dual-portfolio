{{-- resources/views/components/record-card.blade.php --}}
@props(['type', 'record', 'theme' => 'academic'])

@php
$isAcademic = $theme === 'academic';
$baseClasses = $isAcademic
    ? 'academic-card bg-white border border-gray-200 rounded-xl p-6 transition-all duration-300 hover:shadow-lg'
    : 'music-card bg-stone-50 border border-stone-200 rounded-xl p-6 transition-all duration-300 hover:shadow-lg';
@endphp

<div class="{{ $baseClasses }} mood-transition">
    @if($isAcademic)
        {{-- Academic Card --}}
        @if($type === 'publication' || $type === 'research')
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-academic/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-academic" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-semibold text-slate-800 academic-text-primary line-clamp-2">{{ $record->title }}</h3>
                    @if($record->subtitle_or_institution)
                        <p class="mt-1 text-sm text-slate-500">{{ $record->subtitle_or_institution }}</p>
                    @endif
                    @if($record->date_or_year)
                        <p class="mt-1 text-xs text-slate-400">{{ $record->date_or_year }}</p>
                    @endif
                    @if($record->description)
                        <p class="mt-3 text-sm text-slate-600 line-clamp-3">{{ Str::limit($record->description, 150) }}</p>
                    @endif
                    <a href="#" class="mt-4 inline-flex items-center text-sm font-medium text-academic hover:text-academic-dark transition-colors">
                        Read More
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        @elseif($type === 'course' || $type === 'teaching')
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-academic/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-academic" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-semibold text-slate-800 academic-text-primary">{{ $record->title }}</h3>
                    @if($record->subtitle_or_institution)
                        <p class="mt-1 text-sm text-slate-500">{{ $record->subtitle_or_institution }}</p>
                    @endif
                    @if($record->date_or_year)
                        <p class="mt-1 text-xs text-slate-400">{{ $record->date_or_year }}</p>
                    @endif
                </div>
            </div>
        @else
            {{-- Bio / Designation --}}
            <div class="text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-academic/10 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-academic" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-800 academic-text-primary">{{ $record->title }}</h3>
                @if($record->subtitle_or_institution)
                    <p class="mt-1 text-sm text-slate-500">{{ $record->subtitle_or_institution }}</p>
                @endif
                @if($record->date_or_year)
                    <p class="mt-1 text-xs text-slate-400">{{ $record->date_or_year }}</p>
                @endif
                @if($record->description)
                    <p class="mt-3 text-sm text-slate-600">{{ Str::limit($record->description, 200) }}</p>
                @endif
            </div>
        @endif
    @else
        {{-- Music Card --}}
        @if($type === 'discography')
            <div class="group">
                <div class="aspect-square rounded-lg bg-music/10 flex items-center justify-center mb-4 overflow-hidden relative">
                    @if($record->media_url)
                        <img src="{{ $record->media_url }}" alt="{{ $record->title }}" class="w-full h-full object-cover" loading="lazy">
                    @else
                        <svg class="w-16 h-16 text-music" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                    @endif
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                </div>
                <h3 class="text-lg font-bold music-text-primary">{{ $record->title }}</h3>
                @if($record->body)
                    <p class="mt-2 text-sm text-stone-600 line-clamp-2">{{ Str::limit(strip_tags($record->body), 100) }}</p>
                @endif
            </div>
        @elseif($type === 'band_info')
            <div class="text-center">
                <div class="w-20 h-20 mx-auto rounded-full bg-music/10 flex items-center justify-center mb-4 overflow-hidden">
                    @if($record->media_url)
                        <img src="{{ $record->media_url }}" alt="{{ $record->title }}" class="w-full h-full object-cover" loading="lazy">
                    @else
                        <svg class="w-10 h-10 text-music" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    @endif
                </div>
                <h3 class="text-xl font-bold music-text-primary">{{ $record->title }}</h3>
                @if($record->body)
                    <p class="mt-3 text-sm text-stone-600">{{ Str::limit(strip_tags($record->body), 200) }}</p>
                @endif
            </div>
        @elseif($type === 'instrument')
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-music/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-music" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-bold music-text-primary">{{ $record->title }}</h3>
                    @if($record->body)
                        <p class="mt-2 text-sm text-stone-600 line-clamp-3">{{ Str::limit(strip_tags($record->body), 150) }}</p>
                    @endif
                </div>
            </div>
        @else
            {{-- Music Course --}}
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-music/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-music" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-bold music-text-primary">{{ $record->title }}</h3>
                    @if($record->body)
                        <p class="mt-2 text-sm text-stone-600 line-clamp-3">{{ Str::limit(strip_tags($record->body), 150) }}</p>
                    @endif
                </div>
            </div>
        @endif
    @endif
</div>
