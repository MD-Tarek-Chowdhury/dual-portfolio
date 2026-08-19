@extends('layouts.app')
@section('title', $record->title)
@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">{{ $record->title }}</h1>
        @if($record->subtitle_or_institution)
            <p class="text-lg text-slate-500 mb-4">{{ $record->subtitle_or_institution }}</p>
        @endif
        @if($record->date_or_year)
            <p class="text-sm text-slate-400 mb-6">{{ $record->date_or_year }}</p>
        @endif
        <div class="prose max-w-none text-slate-700">
            {{ $record->description }}
        </div>
        <a href="{{ route('academic') }}" class="mt-8 inline-flex items-center text-sm font-medium text-academic hover:text-academic-dark">
            ← Back to Academia
        </a>
    </div>
</div>
@endsection
