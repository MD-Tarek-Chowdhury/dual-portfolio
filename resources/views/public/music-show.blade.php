@extends('layouts.app')
@section('title', $record->title)
@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">{{ $record->title }}</h1>
        @if($record->media_url)
            <img src="{{ $record->media_url }}" alt="{{ $record->title }}" class="w-full h-auto rounded-lg mb-6">
        @endif
        <div class="prose max-w-none text-slate-700">
            {!! $record->body !!}
        </div>
        <a href="{{ route('music') }}" class="mt-8 inline-flex items-center text-sm font-medium text-music hover:text-music-neon">
            ← Back to Music
        </a>
    </div>
</div>
@endsection
