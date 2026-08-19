{{-- resources/views/admin/music-records/index.blade.php --}}
<x-admin-layout title="Music Records" subtitle="Manage band info, discography, instruments, and music courses">

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6 shadow-sm">
        <form method="GET" action="{{ route('admin.music-records.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                       class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm"
                       placeholder="Search by title...">
            </div>

            <div class="w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm">
                    <option value="">All Types</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ ($filters['type'] ?? '') === $type ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm">
                    <option value="">All Status</option>
                    <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="trashed" {{ ($filters['status'] ?? '') === 'trashed' ? 'selected' : '' }}>Trashed</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-gray-900 transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.music-records.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                    Reset
                </a>
            </div>

            <div class="ml-auto">
                <a href="{{ route('admin.music-records.create') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Record
                </a>
            </div>
        </form>
    </div>

    {{-- Records Table --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Media</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($records as $record)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ match($record->record_type) {
                                        'band_info' => 'bg-purple-100 text-purple-800',
                                        'discography' => 'bg-red-100 text-red-800',
                                        'instrument' => 'bg-orange-100 text-orange-800',
                                        'course' => 'bg-green-100 text-green-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    } }}">
                                    {{ ucfirst(str_replace('_', ' ', $record->record_type)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $record->title }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">/{{ $record->slug }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($record->media_url)
                                    <span class="inline-flex items-center text-xs text-green-600">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Has Media
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $record->display_order }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($record->trashed())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Trashed
                                    </span>
                                @elseif($record->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($record->trashed())
                                    <form action="{{ route('admin.music-records.restore', $record) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Restore</button>
                                    </form>
                                    <form action="{{ route('admin.music-records.force-delete', $record) }}" method="POST" class="inline" x-data="deleteConfirm()" @submit.prevent="confirming ? $el.submit() : ask()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        <template x-if="confirming">
                                            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                                                <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
                                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Permanently Delete?</h3>
                                                    <p class="text-sm text-gray-500 mb-4">This action cannot be undone.</p>
                                                    <div class="flex justify-end gap-3">
                                                        <button type="button" @click="cancel()" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Cancel</button>
                                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </form>
                                @else
                                    <a href="{{ route('admin.music-records.edit', $record) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                    <form action="{{ route('admin.music-records.destroy', $record) }}" method="POST" class="inline" onsubmit="return confirm('Move this record to trash?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Trash</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                </svg>
                                <p class="text-sm">No music records found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($records->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $records->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>
@endsection
