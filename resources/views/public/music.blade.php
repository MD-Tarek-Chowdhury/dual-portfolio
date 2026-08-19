{{-- resources/views/public/music.blade.php --}}
@php
$heroTitle = $section ? ucfirst($section) : 'The Music';
$heroSubtitle = match($section) {
    'band' => 'Band members, history, and story',
    'discography' => 'Albums, singles, and releases',
    'courses' => 'Music lessons and workshops',
    'booking' => 'Book the band for your event',
    default => 'Musician, Band Member, Artist',
};
@endphp

<x-public-layout
    :title="$settings['siteTitleMusic'] ?? 'Band Name – Music'"
    theme="music"
    :heroImage="$heroImage"
    :heroTitle="$heroTitle"
    :heroSubtitle="$heroSubtitle"
    :defaultMood="$defaultMood">

    {{-- Section Navigation Tabs --}}
    <div class="mb-10">
        <div class="flex flex-wrap gap-2 justify-center md:justify-start">
            <a href="{{ route('music') }}"
               class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 {{ !$section ? 'bg-music text-white shadow-md' : 'bg-stone-200 text-stone-600 hover:bg-stone-300' }}">
                Overview
            </a>
            <a href="{{ route('music', 'band') }}"
               class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 {{ $section === 'band' ? 'bg-music text-white shadow-md' : 'bg-stone-200 text-stone-600 hover:bg-stone-300' }}">
                Band
            </a>
            <a href="{{ route('music', 'discography') }}"
               class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 {{ $section === 'discography' ? 'bg-music text-white shadow-md' : 'bg-stone-200 text-stone-600 hover:bg-stone-300' }}">
                Discography
            </a>
            <a href="{{ route('music', 'courses') }}"
               class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 {{ $section === 'courses' ? 'bg-music text-white shadow-md' : 'bg-stone-200 text-stone-600 hover:bg-stone-300' }}">
                Courses
            </a>
        </div>
    </div>

    @if(!$section)
        {{-- Overview Dashboard --}}
        <div class="space-y-16">
            {{-- Band Info --}}
            @if(!empty($records['band_info']) && $records['band_info']->count() > 0)
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-stone-800 music-text-primary">Band</h2>
                        <a href="{{ route('music', 'band') }}" class="text-sm text-music hover:text-music-neon font-medium">View All →</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($records['band_info']->take(2) as $record)
                            <x-record-card type="band_info" :record="$record" theme="music" />
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Discography --}}
            @if(!empty($records['discography']) && $records['discography']->count() > 0)
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-stone-800 music-text-primary">Discography</h2>
                        <a href="{{ route('music', 'discography') }}" class="text-sm text-music hover:text-music-neon font-medium">View All →</a>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($records['discography']->take(4) as $record)
                            <x-record-card type="discography" :record="$record" theme="music" />
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Instruments --}}
            @if(!empty($records['instrument']) && $records['instrument']->count() > 0)
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-stone-800 music-text-primary">Instruments & Gear</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($records['instrument']->take(3) as $record)
                            <x-record-card type="instrument" :record="$record" theme="music" />
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Music Courses --}}
            @if(!empty($records['course']) && $records['course']->count() > 0)
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-stone-800 music-text-primary">Music Courses</h2>
                        <a href="{{ route('music', 'courses') }}" class="text-sm text-music hover:text-music-neon font-medium">View All →</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($records['course']->take(3) as $record)
                            <x-record-card type="course" :record="$record" theme="music" />
                        @endforeach
                    </div>
                </section>
            @endif
        </div>

    @else
        {{-- Section-specific Paginated View --}}
        <div class="mb-6">
            <p class="text-stone-500">
                @if($isPaginated && $records instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    Showing {{ $records->firstItem() ?? 0 }}–{{ $records->lastItem() ?? 0 }} of {{ $records->total() }} {{ $section }}
                @else
                    {{ count($records) }} {{ $section }} found
                @endif
            </p>
        </div>

        @php
            $recordType = match($section) {
                'band' => 'band_info',
                'discography' => 'discography',
                'courses' => 'course',
                default => $section,
            };
            $gridCols = $section === 'discography' ? 'grid-cols-2 md:grid-cols-3 lg:grid-cols-4' : 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3';
        @endphp

        <div class="grid {{ $gridCols }} gap-6">
            @if($isPaginated)
                @foreach($records as $record)
                    <x-record-card :type="$recordType" :record="$record" theme="music" />
                @endforeach
            @else
                @foreach($records as $record)
                    <x-record-card :type="$recordType" :record="$record" theme="music" />
                @endforeach
            @endif
        </div>

        @if($isPaginated)
            <div class="mt-10">
                <x-pagination :paginator="$records" />
            </div>
        @endif
    @endif

    {{-- World Map Navigation (Crossover) --}}
    <section class="mt-20 pt-12 border-t border-stone-200">
        <div class="text-center mb-8">
            <h3 class="text-xl font-semibold text-stone-700 mb-2 music-text-primary">Explore the Other Side</h3>
            <p class="text-stone-500">Discover the professor behind the musician</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-3xl mx-auto">
            @foreach($worldMap as $musicKey => $academicKey)
                @php
                    $labels = [
                        'band' => 'View Bio',
                        'discography' => 'See Research',
                        'courses' => 'Academic Courses',
                        'contact' => 'Get in Touch',
                    ];
                    $icons = [
                        'band' => '🎓',
                        'discography' => '📚',
                        'courses' => '📖',
                        'contact' => '📧',
                    ];
                @endphp
                <a href="{{ $musicKey === 'contact' ? route('contact') : route('academic', $academicKey) }}"
                   class="group flex flex-col items-center p-6 bg-stone-100 hover:bg-music/5 rounded-xl border border-stone-200 hover:border-music/30 transition-all duration-300">
                    <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">{{ $icons[$musicKey] ?? '→' }}</span>
                    <span class="text-sm font-medium text-stone-600 group-hover:text-music text-center">{{ $labels[$musicKey] ?? ucfirst($academicKey) }}</span>
                </a>
            @endforeach
        </div>
    </section>

</x-public-layout>
