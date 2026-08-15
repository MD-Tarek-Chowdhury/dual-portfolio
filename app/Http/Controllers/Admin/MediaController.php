<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadHeroImageRequest;
use App\Models\PortfolioSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class MediaController extends Controller
{
    public function index()
    {
        return view('admin.media.index', [
            'heroImages' => [
                'parent' => PortfolioSetting::get('hero_parent_image'),
                'academic' => PortfolioSetting::get('hero_academic_image'),
                'music' => PortfolioSetting::get('hero_music_image'),
            ],
        ]);
    }

    public function store(UploadHeroImageRequest $request)
    {
        $file = $request->file('image');
        $settingKey = $request->setting_key;

        // Generate clean filename
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '_' . time()
            . '.' . $file->getClientOriginalExtension();

        $path = config('portfolio.images.hero_path');

        // Store original
        $storedPath = $file->storeAs($path, $filename, 'public');

        // Optimize using Intervention Image
        $fullPath = Storage::disk('public')->path($storedPath);

        try {
            $image = Image::read($fullPath);
            $image->scale(width: 1920); // Max width 1920px
            $image->save($fullPath, quality: 85); // 85% quality JPEG/PNG

            // Create WebP variant for modern browsers
            $webpFilename = Str::replaceLast(
                $file->getClientOriginalExtension(),
                'webp',
                $filename
            );
            $webpPath = $path . '/' . $webpFilename;
            $image->save(Storage::disk('public')->path($webpPath), quality: 80);
        } catch (\Exception $e) {
            // Log but don't fail - original is still saved
            \Log::warning('Image optimization failed: ' . $e->getMessage());
        }

        // Update setting
        PortfolioSetting::set($settingKey, $storedPath, 'image_path');

        return redirect()->route('admin.media.index')
            ->with('success', 'Hero image uploaded and optimized successfully.');
    }
}
