{{-- resources/views/admin/contact-submissions/show.blade.php --}}
<x-admin-layout title="Contact Submission" subtitle="View message details">

    <div class="max-w-3xl">
        {{-- Message Header --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $submission->contact_type === 'academic' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($submission->contact_type) }}
                    </span>
                    @if(!$submission->read_at)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            Unread
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                            Read {{ $submission->read_at->diffForHumans() }}
                        </span>
                    @endif
                </div>
                <span class="text-sm text-gray-500">{{ $submission->created_at->format('F j, Y \a\t g:i A') }}</span>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase mb-1">From</label>
                        <p class="text-sm font-medium text-gray-900">{{ $submission->name }}</p>
                        <a href="mailto:{{ $submission->email }}" class="text-sm text-purple-600 hover:text-purple-800">{{ $submission->email }}</a>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Subject</label>
                        <p class="text-sm font-medium text-gray-900">{{ $submission->subject }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Message</label>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $submission->message }}</p>
                    </div>
                </div>

                @if($submission->ip_address)
                    <div class="text-xs text-gray-400">
                        IP Address: {{ $submission->ip_address }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.contact-submissions.index') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Inbox
            </a>

            <div class="flex gap-3">
                <a href="mailto:{{ $submission->email }}?subject=Re: {{ $submission->subject }}"
                   class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Reply
                </a>
                <form action="{{ route('admin.contact-submissions.destroy', $submission) }}" method="POST" class="inline" onsubmit="return confirm('Delete this submission?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-admin-layout>
@endsection
