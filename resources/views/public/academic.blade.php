{{-- resources/views/public/academic.blade.php --}}
@php
$heroTitle = $section ? ucfirst($section) : 'Academia';
$heroSubtitle = match($section) {
    'bio' => 'Background, education, and professional journey',
    'research' => 'Publications, papers, and research contributions',
    'teaching' => 'Courses, lectures, and educational materials',
    default => 'Researcher, Educator, Scholar',
};
@endphp

<x-public-layout
    :title="$settings['siteTitleAcademic'] ?? 'Dr. Portfolio – Academia'"
    theme="academic"
    :heroImage="$heroImage"
    :heroTitle="$heroTitle"
    :heroSubtitle="$heroSubtitle"
    :defaultMood="$defaultMood">

    {{-- Section Navigation Tabs --}}
    <div class="mb-10">
        <div class="flex flex-wrap gap-2 justify-center md:justify-start">
            <a href="{{ route('academic') }}"
               class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 {{ !$section ? 'bg-academic text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Overview
            </a>
            <a href="{{ route('academic', 'bio') }}"
               class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 {{ $section === 'bio' ? 'bg-academic text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Bio
            </a>
            <a href="{{ route('academic', 'research') }}"
               class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 {{ $section === 'research' ? 'bg-academic text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Research
            </a>
            <a href="{{ route('academic', 'teaching') }}"
               class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 {{ $section === 'teaching' ? 'bg-academic text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Teaching
            </a>
        </div>
    </div>

    @if(!$section)
        {{-- Overview Dashboard --}}
        <div class="space-y-16">
            {{-- Bio / Designations --}}
            @if(!empty($records['designation']) && $records['designation']->count() > 0)
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-slate-800">Bio & Designations</h2>
                        <a href="{{ route('academic', 'bio') }}" class="text-sm text-academic hover:text-academic-dark font-medium">View All →</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($records['designation']->take(3) as $record)
                            <x-record-card type="designation" :record="$record" theme="academic" />
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Research / Publications --}}
            @if(!empty($records['publication']) && $records['publication']->count() > 0)
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-slate-800">Research & Publications</h2>
                        <a href="{{ route('academic', 'research') }}" class="text-sm text-academic hover:text-academic-dark font-medium">View All →</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($records['publication']->take(4) as $record)
                            <x-record-card type="publication" :record="$record" theme="academic" />
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Teaching / Courses --}}
            @if(!empty($records['course']) && $records['course']->count() > 0)
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-slate-800">Teaching & Courses</h2>
                        <a href="{{ route('academic', 'teaching') }}" class="text-sm text-academic hover:text-academic-dark font-medium">View All →</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($records['course']->take(3) as $record)
                            <x-record-card type="course" :record="$record" theme="academic" />
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Achievements --}}
            @if(!empty($records['achievement']) && $records['achievement']->count() > 0)
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-slate-800">Achievements</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($records['achievement']->take(3) as $record)
                            <x-record-card type="achievement" :record="$record" theme="academic" />
                        @endforeach
                    </div>
                </section>
            @endif
        </div>

    @else
        {{-- Section-specific Paginated View --}}
        <div class="mb-6">
            <p class="text-gray-500">
                @if($isPaginated && $records instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    Showing {{ $records->firstItem() ?? 0 }}–{{ $records->lastItem() ?? 0 }} of {{ $records->total() }} {{ $section }}
                @else
                    {{ count($records) }} {{ $section }} found
                @endif
            </p>
        </div>

        @php
            $recordType = match($section) {
                'bio' => 'designation',
                'research' => 'publication',
                'teaching' => 'course',
                default => $section,
            };
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if($isPaginated)
                @foreach($records as $record)
                    <x-record-card :type="$recordType" :record="$record" theme="academic" />
                @endforeach
            @else
                @foreach($records as $record)
                    <x-record-card :type="$recordType" :record="$record" theme="academic" />
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
    <section class="mt-20 pt-12 border-t border-gray-200">
        <div class="text-center mb-8">
            <h3 class="text-xl font-semibold text-slate-700 mb-2">Explore the Other Side</h3>
            <p class="text-gray-500">Discover the musician behind the professor</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-3xl mx-auto">
            @foreach($worldMap as $academicKey => $musicKey)
                @php
                    $labels = [
                        'bio' => 'See the Band',
                        'research' => 'View Discography',
                        'teaching' => 'Music Courses',
                        'contact' => 'Get in Touch',
                    ];
                    $icons = [
                        'bio' => '🎸',
                        'research' => '💿',
                        'teaching' => '🎵',
                        'contact' => '📧',
                    ];
                @endphp
                <a href="{{ $academicKey === 'contact' ? route('contact') : route('music', $musicKey) }}"
                   class="group flex flex-col items-center p-6 bg-gray-50 hover:bg-academic/5 rounded-xl border border-gray-200 hover:border-academic/30 transition-all duration-300">
                    <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">{{ $icons[$academicKey] ?? '→' }}</span>
                    <span class="text-sm font-medium text-gray-600 group-hover:text-academic text-center">{{ $labels[$academicKey] ?? ucfirst($musicKey) }}</span>
                </a>
            @endforeach
        </div>
    </section>

</x-public-layout>
