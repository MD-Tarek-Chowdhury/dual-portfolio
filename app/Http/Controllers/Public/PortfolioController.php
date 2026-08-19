<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AcademicRecord;
use App\Models\MusicalRecord;
use App\Models\PortfolioSetting;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function landing()
    {
        return view('public.landing', [
            'settings' => $this->getPublicSettings(),
            'heroImage' => PortfolioSetting::get('hero_parent_image', asset('images/default/parent.jpg')),
        ]);
    }

    public function academic(Request $request, ?string $section = null)
    {
        $records = [];
        $isPaginated = false;

        // Map URL sections to database record types
        $sectionToType = [
            'bio' => 'designation',
            'research' => 'publication',
            'teaching' => 'course',
        ];

        if ($section) {
            $recordType = $sectionToType[$section] ?? $section;
            $records = AcademicRecord::forPublic()
                ->byType($recordType)
                ->paginate(12)
                ->withQueryString();
            $isPaginated = true;
        } else {
            $types = ['publication', 'course', 'designation', 'achievement'];
            foreach ($types as $type) {
                $records[$type] = AcademicRecord::forPublic()
                    ->byType($type)
                    ->limit(6)
                    ->get();
            }
        }

        return view('public.academic', [
            'section' => $section,
            'records' => $records,
            'isPaginated' => $isPaginated,
            'settings' => $this->getPublicSettings(),
            'heroImage' => PortfolioSetting::get('hero_academic_image', asset('images/default/academic.jpg')),
            'defaultMood' => PortfolioSetting::get('academic_mood_default', 'day'),
            'worldMap' => config('portfolio.world_map.academic'),
        ]);
    }

    public function music(Request $request, ?string $section = null)
    {
        $records = [];
        $isPaginated = false;

        // Map URL sections to database record types
        $sectionToType = [
           'band' => 'band_info',
           'courses' => 'course',
           'booking' => 'band_info', // Map booking to band_info to prevent SQL errors
       ];

        if ($section) {
            $recordType = $sectionToType[$section] ?? $section;
            $records = MusicalRecord::forPublic()
                ->byType($recordType)
                ->paginate(12)
                ->withQueryString();
            $isPaginated = true;
        } else {
            $types = ['band_info', 'discography', 'instrument', 'course'];
            foreach ($types as $type) {
                $records[$type] = MusicalRecord::forPublic()
                    ->byType($type)
                    ->limit(6)
                    ->get();
            }
        }

        return view('public.music', [
            'section' => $section,
            'records' => $records,
            'isPaginated' => $isPaginated,
            'settings' => $this->getPublicSettings(),
            'heroImage' => PortfolioSetting::get('hero_music_image', asset('images/default/music.jpg')),
            'defaultMood' => PortfolioSetting::get('music_mood_default', 'studio'),
            'worldMap' => config('portfolio.world_map.music'),
        ]);
    }

    public function contact()
    {
        return view('public.contact', [
            'settings' => $this->getPublicSettings(),
            'academicContact' => [
                'email' => PortfolioSetting::get('contact_email_academic', 'professor@university.edu'),
                'office' => PortfolioSetting::get('academic_office', 'Room 302, Science Building'),
                'hours' => PortfolioSetting::get('academic_hours', 'By Appointment'),
                'phone' => PortfolioSetting::get('academic_phone', ''),
            ],
            'musicContact' => [
                'email' => PortfolioSetting::get('contact_email_music', 'booking@band.com'),
                'studio' => PortfolioSetting::get('music_studio', 'Sonic Temple Studio'),
                'booking' => PortfolioSetting::get('music_booking', 'Available for Gigs'),
                'phone' => PortfolioSetting::get('music_phone', ''),
            ],
        ]);
    }

    private function getPublicSettings(): array
    {
        return [
            'siteTitleAcademic' => PortfolioSetting::get('site_title_academic', 'Dr. Portfolio – Academia'),
            'siteTitleMusic' => PortfolioSetting::get('site_title_music', 'Band Name – Music'),
            'footerCopyright' => PortfolioSetting::get('footer_copyright', '© ' . date('Y') . ' – All Rights Reserved'),
        ];
    }

    public function showAcademic(AcademicRecord $academicRecord)
    {
        return view('public.academic-show', [
            'record' => $academicRecord,
            'settings' => $this->getPublicSettings(),
        ]);
    }

    public function showMusic(MusicalRecord $musicalRecord)
    {
        return view('public.music-show', [
            'record' => $musicalRecord,
            'settings' => $this->getPublicSettings(),
        ]);
    }
}
