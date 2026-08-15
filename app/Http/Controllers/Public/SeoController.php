<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AcademicRecord;
use App\Models\MusicalRecord;
use App\Models\PortfolioSetting;

class SeoController extends Controller
{
    public function sitemap()
    {
        $academicRecords = AcademicRecord::forPublic()->get();
        $musicRecords = MusicalRecord::forPublic()->get();

        return response()->view('seo.sitemap', [
            'academicRecords' => $academicRecords,
            'musicRecords' => $musicRecords,
            'settings' => [
                'siteTitleAcademic' => PortfolioSetting::get('site_title_academic'),
                'siteTitleMusic' => PortfolioSetting::get('site_title_music'),
            ],
        ])->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        $content = "User-agent: *\n";
        $content .= "Disallow: /admin\n";
        $content .= "Disallow: /login\n";
        $content .= "Disallow: /register\n";
        $content .= "Allow: /\n";
        $content .= "Sitemap: " . route('sitemap') . "\n";

        return response($content)->header('Content-Type', 'text/plain');
    }
}
