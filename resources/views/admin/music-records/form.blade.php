{{-- resources/views/admin/music-records/form.blade.php --}}
@php
$isEdit = isset($record);
$title = $isEdit ? 'Edit Music Record' : 'Create Music Record';
$subtitle = $isEdit ? 'Update record details' : 'Add a new music record';
$action = $isEdit ? route('admin.music-records.update', $record) : route('admin.music-records.store');
$method = $isEdit ? 'PUT' : 'POST';
@endphp

<x-admin-layout :title="$title" :subtitle="$subtitle">

    <div class="max-w-3xl">
        <form action="{{ $action }}" method="POST" class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 space-y-6">
            @csrf
            @method($method)

            {{-- Record Type --}}
            <div>
                <label for="record_type" class="block text-sm font-medium text-gray-700 mb-1">Record Type <span class="text-red-500">*</span></label>
                <select name="record_type" id="record_type" required
                        class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 @error('record_type') border-red-500 @enderror">
                    <option value="">Select a type...</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ old('record_type', $record->record_type ?? '') === $type ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
                @error('record_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $record->title ?? '') }}" required
                       class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 @error('title') border-red-500 @enderror"
                       placeholder="e.g., Sonic Temple Album, Guitar Masterclass">
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Media URL --}}
            <div>
                <label for="media_url" class="block text-sm font-medium text-gray-700 mb-1">Media URL</label>
                <input type="url" name="media_url" id="media_url" value="{{ old('media_url', $record->media_url ?? '') }}"
                       class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 @error('media_url') border-red-500 @enderror"
                       placeholder="https://example.com/image.jpg or video embed URL">
                <p class="mt-1 text-xs text-gray-500">Image URL for album covers, band photos, or instrument images.</p>
                @error('media_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Body --}}
            <div>
                <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Body / Description</label>
                <textarea name="body" id="body" rows="6"
                          class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 @error('body') border-red-500 @enderror resize-none"
                          placeholder="Enter a detailed description, track listing, or biography...">{{ old('body', $record->body ?? '') }}</textarea>
                @error('body')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Slug --}}
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $record->slug ?? '') }}"
                       class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 @error('slug') border-red-500 @enderror"
                       placeholder="Auto-generated from title if left empty">
                <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate from title. Changing slug may break existing links.</p>
                @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Display Order --}}
            <div>
                <label for="display_order" class="block text-sm font-medium text-gray-700 mb-1">Display Order <span class="text-red-500">*</span></label>
                <input type="number" name="display_order" id="display_order" value="{{ old('display_order', $record->display_order ?? 0) }}" required min="0"
                       class="w-32 rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 @error('display_order') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">Lower numbers appear first.</p>
                @error('display_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Is Active --}}
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $record->is_active ?? true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-red-600 focus:ring-red-500 h-4 w-4">
                <label for="is_active" class="ml-2 block text-sm text-gray-700">Active (visible on public site)</label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin.music-records.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    ← Back to Records
                </a>
                <div class="flex gap-3">
                    <button type="reset" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Reset
                    </button>
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                        {{ $isEdit ? 'Update Record' : 'Create Record' }}
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-admin-layout>
@endsection
