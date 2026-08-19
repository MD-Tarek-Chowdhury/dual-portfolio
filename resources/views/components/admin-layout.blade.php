{{-- resources/views/components/admin-layout.blade.php --}}
@props(['title', 'subtitle' => null])

@extends('layouts.admin')

@section('title', $title)

@section('content')
    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
        @if(isset($subtitle))
            <p class="mt-1 text-sm text-gray-500">{{ $subtitle }}</p>
        @endif
    </div>

    {{-- Main Slot --}}
    {{ $slot }}
@endsection
