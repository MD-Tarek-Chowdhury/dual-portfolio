{{-- resources/views/admin/contact-submissions/index.blade.php --}}
<x-admin-layout title="Contact Submissions" subtitle="Manage incoming messages from the contact form">

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6 shadow-sm">
        <form method="GET" action="{{ route('admin.contact-submissions.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 text-sm">
                    <option value="">All Types</option>
                    <option value="academic" {{ ($filters['type'] ?? '') === 'academic' ? 'selected' : '' }}>Academic</option>
                    <option value="music" {{ ($filters['type'] ?? '') === 'music' ? 'selected' : '' }}>Music</option>
                </select>
            </div>

            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                       class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 text-sm"
                       placeholder="Search by name, email, or subject...">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-gray-900 transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.contact-submissions.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Submissions List --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($submissions as $submission)
                        <tr class="hover:bg-gray-50 transition-colors {{ !$submission->read_at ? 'bg-purple-50/30' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(!$submission->read_at)
                                    <span class="inline-flex items-center w-2.5 h-2.5 bg-purple-500 rounded-full" title="Unread"></span>
                                @else
                                    <span class="inline-flex items-center w-2.5 h-2.5 bg-gray-300 rounded-full" title="Read"></span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium {{ !$submission->read_at ? 'text-gray-900' : 'text-gray-600' }}">{{ $submission->name }}</div>
                                <div class="text-xs text-gray-500">{{ $submission->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $submission->contact_type === 'academic' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($submission->contact_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm {{ !$submission->read_at ? 'font-semibold text-gray-900' : 'text-gray-600' }}">{{ $submission->subject }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $submission->created_at->format('M j, Y g:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.contact-submissions.show', $submission) }}" class="text-purple-600 hover:text-purple-900 mr-3">View</a>
                                <form action="{{ route('admin.contact-submissions.destroy', $submission) }}" method="POST" class="inline" onsubmit="return confirm('Delete this submission?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm">No contact submissions found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($submissions->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>
@endsection
