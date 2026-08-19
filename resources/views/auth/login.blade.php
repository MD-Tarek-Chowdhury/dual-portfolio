@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf

    <div>
        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
        <input type="email" name="email" id="email" required autofocus
               class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
               value="{{ old('email') }}">
        @error('email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
        <input type="password" name="password" id="password" required
               class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
        @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between">
        <label class="flex items-center">
            <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
            <span class="ml-2 text-sm text-slate-600">Remember me</span>
        </label>
        @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700">Forgot password?</a>
        @endif
    </div>

    <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
        Sign In
    </button>
</form>
@endsection
