{{-- resources/views/admin/settings/index.blade.php --}}
<x-admin-layout title="Settings" subtitle="Configure site titles, hero images, contact info, and mood defaults">

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- Hero Images Group --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Hero Images
            </h3>
            <p class="text-sm text-gray-500 mb-4">Manage hero images in the <a href="{{ route('admin.media.index') }}" class="text-blue-600 hover:underline">Media section</a>.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach(['hero_parent_image', 'hero_academic_image', 'hero_music_image'] as $key)
                    @php $setting = $settings->firstWhere('key', $key); @endphp
                    @if($setting)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $setting['label'] }}</label>
                            <input type="hidden" name="settings[{{ $loop->index }}][key]" value="{{ $key }}">
                            <input type="hidden" name="settings[{{ $loop->index }}][type]" value="image_path">
                            <div class="relative">
                                <input type="text" name="settings[{{ $loop->index }}][value]" value="{{ $setting['value'] }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm pr-20"
                                       placeholder="Image path...">
                                @if($setting['value'] && !str_starts_with($setting['value'], '/images/default'))
                                    <span class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-green-600 font-medium">✓ Set</span>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Site Titles Group --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Site Titles
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach(['site_title_academic', 'site_title_music'] as $key)
                    @php
                        $setting = $settings->firstWhere('key', $key);
                        $idx = $loop->index + 3;
                    @endphp
                    @if($setting)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $setting['label'] }}</label>
                            <input type="hidden" name="settings[{{ $idx }}][key]" value="{{ $key }}">
                            <input type="hidden" name="settings[{{ $idx }}][type]" value="text">
                            <input type="text" name="settings[{{ $idx }}][value]" value="{{ $setting['value'] }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                   placeholder="Enter site title...">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Mood Defaults Group --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                Mood Defaults
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach(['academic_mood_default', 'music_mood_default'] as $key)
                    @php
                        $setting = $settings->firstWhere('key', $key);
                        $idx = $loop->index + 5;
                    @endphp
                    @if($setting)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $setting['label'] }}</label>
                            <input type="hidden" name="settings[{{ $idx }}][key]" value="{{ $key }}">
                            <input type="hidden" name="settings[{{ $idx }}][type]" value="text">
                            <select name="settings[{{ $idx }}][value]" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                                @if($key === 'academic_mood_default')
                                    <option value="day" {{ $setting['value'] === 'day' ? 'selected' : '' }}>Day (Normal)</option>
                                    <option value="dim" {{ $setting['value'] === 'dim' ? 'selected' : '' }}>Dimmer</option>
                                @else
                                    <option value="studio" {{ $setting['value'] === 'studio' ? 'selected' : '' }}>Studio (Normal)</option>
                                    <option value="arena" {{ $setting['value'] === 'arena' ? 'selected' : '' }}>Arena (Neon)</option>
                                @endif
                            </select>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Contact Info Group --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Contact Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php $contactKeys = ['contact_email_academic', 'contact_email_music', 'academic_office', 'academic_hours', 'music_studio', 'music_booking']; @endphp
                @foreach($contactKeys as $key)
                    @php
                        $setting = $settings->firstWhere('key', $key);
                        $idx = $loop->index + 7;
                    @endphp
                    @if($setting)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $setting['label'] }}</label>
                            <input type="hidden" name="settings[{{ $idx }}][key]" value="{{ $key }}">
                            <input type="hidden" name="settings[{{ $idx }}][type]" value="text">
                            <input type="text" name="settings[{{ $idx }}][value]" value="{{ $setting['value'] }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                   placeholder="Enter value...">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Footer Group --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Footer
            </h3>
            @php $footerSetting = $settings->firstWhere('key', 'footer_copyright'); $footerIdx = 13; @endphp
            @if($footerSetting)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $footerSetting['label'] }}</label>
                    <input type="hidden" name="settings[{{ $footerIdx }}][key]" value="footer_copyright">
                    <input type="hidden" name="settings[{{ $footerIdx }}][type]" value="text">
                    <input type="text" name="settings[{{ $footerIdx }}][value]" value="{{ $footerSetting['value'] }}"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                           placeholder="© {{ date('Y') }} – All Rights Reserved">
                </div>
            @endif
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition-colors shadow-lg">
                Save All Settings
            </button>
        </div>
    </form>

</x-admin-layout>
@endsection
