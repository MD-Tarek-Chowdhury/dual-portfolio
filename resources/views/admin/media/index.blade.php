{{-- resources/views/admin/media/index.blade.php --}}
<x-admin-layout title="Media Manager" subtitle="Upload and manage hero images for the portfolio">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Parent Landing Hero --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Parent Landing Hero</h3>
                <p class="text-sm text-gray-500 mb-4">Displayed on the split-screen landing page.</p>

                <div class="aspect-video rounded-lg overflow-hidden bg-gray-100 mb-4 border border-gray-200">
                    <img src="{{ $heroImages['parent'] }}" alt="Parent Hero" class="w-full h-full object-cover" loading="lazy">
                </div>

                <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" x-data="imageUpload()">
                    @csrf
                    <input type="hidden" name="setting_key" value="hero_parent_image">

                    <div class="relative">
                        <input type="file" name="image" id="parent_image" accept="image/jpeg,image/png" required
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer"
                               @change="handleFile($event)">
                    </div>

                    <div x-show="preview" class="mt-3" style="display: none;">
                        <p class="text-xs text-gray-500 mb-1">Preview: <span x-text="filename"></span></p>
                        <img :src="preview" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                    </div>

                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="mt-4 w-full py-2.5 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Upload & Optimize
                    </button>
                </form>
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                <p class="text-xs text-gray-500">Max 2MB • JPG or PNG only</p>
            </div>
        </div>

        {{-- Academic Hero --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Academic Hero</h3>
                <p class="text-sm text-gray-500 mb-4">Displayed on the academic section pages.</p>

                <div class="aspect-video rounded-lg overflow-hidden bg-gray-100 mb-4 border border-gray-200">
                    <img src="{{ $heroImages['academic'] }}" alt="Academic Hero" class="w-full h-full object-cover" loading="lazy">
                </div>

                <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" x-data="imageUpload()">
                    @csrf
                    <input type="hidden" name="setting_key" value="hero_academic_image">

                    <div class="relative">
                        <input type="file" name="image" id="academic_image" accept="image/jpeg,image/png" required
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer"
                               @change="handleFile($event)">
                    </div>

                    <div x-show="preview" class="mt-3" style="display: none;">
                        <p class="text-xs text-gray-500 mb-1">Preview: <span x-text="filename"></span></p>
                        <img :src="preview" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                    </div>

                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="mt-4 w-full py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Upload & Optimize
                    </button>
                </form>
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                <p class="text-xs text-gray-500">Max 2MB • JPG or PNG only</p>
            </div>
        </div>

        {{-- Music Hero --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Music Hero</h3>
                <p class="text-sm text-gray-500 mb-4">Displayed on the music section pages.</p>

                <div class="aspect-video rounded-lg overflow-hidden bg-gray-100 mb-4 border border-gray-200">
                    <img src="{{ $heroImages['music'] }}" alt="Music Hero" class="w-full h-full object-cover" loading="lazy">
                </div>

                <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" x-data="imageUpload()">
                    @csrf
                    <input type="hidden" name="setting_key" value="hero_music_image">

                    <div class="relative">
                        <input type="file" name="image" id="music_image" accept="image/jpeg,image/png" required
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer"
                               @change="handleFile($event)">
                    </div>

                    <div x-show="preview" class="mt-3" style="display: none;">
                        <p class="text-xs text-gray-500 mb-1">Preview: <span x-text="filename"></span></p>
                        <img :src="preview" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                    </div>

                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="mt-4 w-full py-2.5 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Upload & Optimize
                    </button>
                </form>
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                <p class="text-xs text-gray-500">Max 2MB • JPG or PNG only</p>
            </div>
        </div>

    </div>

    {{-- Upload Tips --}}
    <div class="mt-8 bg-blue-50 rounded-xl border border-blue-200 p-6">
        <h4 class="text-sm font-semibold text-blue-900 mb-2 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Image Optimization Tips
        </h4>
        <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
            <li>Images are automatically resized to a maximum width of 1920px</li>
            <li>JPEG/PNG quality is optimized to 85% for fast loading</li>
            <li>A WebP variant is generated for modern browsers</li>
            <li>Recommended aspect ratio for heroes: 16:9 or 21:9</li>
        </ul>
    </div>

</x-admin-layout>
@endsection
