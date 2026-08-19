{{-- resources/views/admin/academic-records/form.blade.php --}}
@php
$isEdit = isset($record);
$title = $isEdit ? 'Edit Academic Record' : 'Create Academic Record';
$subtitle = $isEdit ? 'Update record details' : 'Add a new academic record';
$action = $isEdit ? route('admin.academic-records.update', $record) : route('admin.academic-records.store');
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
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('record_type') border-red-500 @enderror">
                    <option value="">Select a type...</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ old('record_type', $record->record_type ?? '') === $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
                @error('record_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $record->title ?? '') }}" required
                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                       placeholder="e.g., Advanced Machine Learning">
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Subtitle / Institution --}}
            <div>
                <label for="subtitle_or_institution" class="block text-sm font-medium text-gray-700 mb-1">Subtitle / Institution</label>
                <input type="text" name="subtitle_or_institution" id="subtitle_or_institution" value="{{ old('subtitle_or_institution', $record->subtitle_or_institution ?? '') }}"
                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('subtitle_or_institution') border-red-500 @enderror"
                       placeholder="e.g., MIT Press, Stanford University">
                @error('subtitle_or_institution')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Date / Year --}}
            <div>
                <label for="date_or_year" class="block text-sm font-medium text-gray-700 mb-1">Date / Year</label>
                <input type="text" name="date_or_year" id="date_or_year" value="{{ old('date_or_year', $record->date_or_year ?? '') }}"
                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('date_or_year') border-red-500 @enderror"
                       placeholder="e.g., 2024 or January 2024">
                @error('date_or_year')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="5"
                          class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror resize-none"
                          placeholder="Enter a detailed description...">{{ old('description', $record->description ?? '') }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Slug --}}
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $record->slug ?? '') }}"
                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('slug') border-red-500 @enderror"
                       placeholder="Auto-generated from title if left empty">
                <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate from title. Changing slug may break existing links.</p>
                @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Display Order --}}
            <div>
                <label for="display_order" class="block text-sm font-medium text-gray-700 mb-1">Display Order <span class="text-red-500">*</span></label>
                <input type="number" name="display_order" id="display_order" value="{{ old('display_order', $record->display_order ?? 0) }}" required min="0"
                       class="w-32 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('display_order') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">Lower numbers appear first.</p>
                @error('display_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Is Active --}}
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $record->is_active ?? true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-4 w-4">
                <label for="is_active" class="ml-2 block text-sm text-gray-700">Active (visible on public site)</label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin.academic-records.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    ← Back to Records
                </a>
                <div class="flex gap-3">
                    <button type="reset" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Reset
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                        {{ $isEdit ? 'Update Record' : 'Create Record' }}
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-admin-layout>
@endsection
