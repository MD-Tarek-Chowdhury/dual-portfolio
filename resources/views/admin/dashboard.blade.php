{{-- resources/views/admin/dashboard.blade.php --}}
<x-admin-layout title="Dashboard" subtitle="Overview of your portfolio content">

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Academic Records Card --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Academic Records</h3>
                </div>
                <span class="text-2xl font-bold text-gray-900">{{ $stats['academic_records']['total'] }}</span>
            </div>

            <div class="grid grid-cols-3 gap-2 text-center mb-4">
                <div class="bg-green-50 rounded-lg p-2">
                    <p class="text-lg font-bold text-green-700">{{ $stats['academic_records']['active'] }}</p>
                    <p class="text-xs text-green-600">Active</p>
                </div>
                <div class="bg-red-50 rounded-lg p-2">
                    <p class="text-lg font-bold text-red-700">{{ $stats['academic_records']['trashed'] }}</p>
                    <p class="text-xs text-red-600">Trashed</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-2">
                    <p class="text-lg font-bold text-gray-700">{{ $stats['academic_records']['total'] - $stats['academic_records']['active'] - $stats['academic_records']['trashed'] }}</p>
                    <p class="text-xs text-gray-600">Inactive</p>
                </div>
            </div>

            {{-- Breakdown by type --}}
            <div class="space-y-2">
                @foreach(['publication', 'course', 'designation', 'achievement'] as $type)
                    @php $count = $stats['academic_records']['by_type'][$type] ?? 0; @endphp
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 capitalize">{{ $type }}</span>
                        <div class="flex items-center gap-2">
                            <div class="w-24 h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 rounded-full" style="width: {{ $stats['academic_records']['total'] > 0 ? ($count / $stats['academic_records']['total'] * 100) : 0 }}%"></div>
                            </div>
                            <span class="text-gray-900 font-medium w-6 text-right">{{ $count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <a href="{{ route('admin.academic-records.index') }}" class="mt-4 block text-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                Manage Academic Records →
            </a>
        </div>

        {{-- Music Records Card --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Music Records</h3>
                </div>
                <span class="text-2xl font-bold text-gray-900">{{ $stats['music_records']['total'] }}</span>
            </div>

            <div class="grid grid-cols-3 gap-2 text-center mb-4">
                <div class="bg-green-50 rounded-lg p-2">
                    <p class="text-lg font-bold text-green-700">{{ $stats['music_records']['active'] }}</p>
                    <p class="text-xs text-green-600">Active</p>
                </div>
                <div class="bg-red-50 rounded-lg p-2">
                    <p class="text-lg font-bold text-red-700">{{ $stats['music_records']['trashed'] }}</p>
                    <p class="text-xs text-red-600">Trashed</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-2">
                    <p class="text-lg font-bold text-gray-700">{{ $stats['music_records']['total'] - $stats['music_records']['active'] - $stats['music_records']['trashed'] }}</p>
                    <p class="text-xs text-gray-600">Inactive</p>
                </div>
            </div>

            {{-- Breakdown by type --}}
            <div class="space-y-2">
                @foreach(['band_info', 'discography', 'instrument', 'course'] as $type)
                    @php $count = $stats['music_records']['by_type'][$type] ?? 0; @endphp
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $type) }}</span>
                        <div class="flex items-center gap-2">
                            <div class="w-24 h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-red-500 rounded-full" style="width: {{ $stats['music_records']['total'] > 0 ? ($count / $stats['music_records']['total'] * 100) : 0 }}%"></div>
                            </div>
                            <span class="text-gray-900 font-medium w-6 text-right">{{ $count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <a href="{{ route('admin.music-records.index') }}" class="mt-4 block text-center text-sm text-red-600 hover:text-red-800 font-medium">
                Manage Music Records →
            </a>
        </div>

        {{-- Contact Submissions Card --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Contact Submissions</h3>
                </div>
                <span class="text-2xl font-bold text-gray-900">{{ $stats['contact_submissions']['total'] }}</span>
            </div>

            <div class="grid grid-cols-2 gap-2 text-center mb-4">
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-lg font-bold text-gray-700">{{ $stats['contact_submissions']['total'] - $stats['contact_submissions']['unread'] }}</p>
                    <p class="text-xs text-gray-600">Read</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-3 relative">
                    @if($stats['contact_submissions']['unread'] > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $stats['contact_submissions']['unread'] }}</span>
                    @endif
                    <p class="text-lg font-bold text-purple-700">{{ $stats['contact_submissions']['unread'] }}</p>
                    <p class="text-xs text-purple-600">Unread</p>
                </div>
            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-500 mb-3">Recent activity overview</p>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Messages are automatically emailed to the configured contact addresses.</span>
                </div>
            </div>

            <a href="{{ route('admin.contact-submissions.index') }}" class="mt-4 block text-center text-sm text-purple-600 hover:text-purple-800 font-medium">
                View Inbox →
            </a>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.academic-records.create') }}" class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-200">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700">New Academic Record</span>
            </a>

            <a href="{{ route('admin.music-records.create') }}" class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200">
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700">New Music Record</span>
            </a>

            <a href="{{ route('admin.media.index') }}" class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 hover:border-green-300 hover:bg-green-50 transition-all duration-200">
                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700">Upload Hero Images</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 hover:border-gray-400 hover:bg-gray-50 transition-all duration-200">
                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700">Settings</span>
            </a>
        </div>
    </div>

</x-admin-layout>
@endsection
