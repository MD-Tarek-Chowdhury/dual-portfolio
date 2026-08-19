{{-- resources/views/components/mood-toggle.blade.php --}}
@props(['mode' => 'academic'])

<div class="mood-toggle-{{ $mode }} flex items-center gap-3">
    <span class="text-sm font-medium transition-opacity duration-300" :class="mood === 'day' || mood === 'studio' ? 'opacity-100' : 'opacity-50'">
        @if($mode === 'academic')
            Day
        @else
            Studio
        @endif
    </span>

    <div class="mood-toggle-track" :class="{ 'active': mood === 'dim' || mood === 'neon' }" @click="toggle()">
        <div class="mood-toggle-thumb"></div>
    </div>

    <span class="text-sm font-medium transition-opacity duration-300" :class="mood === 'dim' || mood === 'neon' ? 'opacity-100' : 'opacity-50'">
        @if($mode === 'academic')
            Dimmer
        @else
            Arena
        @endif
    </span>
</div>
