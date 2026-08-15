<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AcademicRecord;
use App\Models\MusicalRecord;

class SeoController extends Controller
{
    public function sitemap()
    {
        $academicRecords = AcademicRecord::forPublic()->get();
        $musicRecords = MusicalRecord::forPublic()->get();

        return response()->view('seo.sitemap', [
            'academicRecords' => $academicRecords,
            'musicRecords' => $musicRecords,
        ])->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        $content = "User-agent: *\n";

        if (app()->environment('local', 'testing')) {
            $content .= "Disallow: /\n";
        } else {
            $content .= "Disallow: /admin\n";
            $content .= "Disallow: /login\n";
            $content .= "Disallow: /register\n";
            $content .= "Allow: /\n";
            $content .= "Sitemap: " . route('sitemap') . "\n";
        }

        return response($content)->header('Content-Type', 'text/plain');
    }
}
