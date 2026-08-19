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
        return response()->view('seo.robots')->header('Content-Type', 'text/plain');
    }
}
