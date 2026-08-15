<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Models\PortfolioSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private array $defaultSettings;

    public function __construct()
    {
        $this->defaultSettings = [
            'hero_parent_image' => ['value' => '/images/default/parent.jpg', 'type' => 'image_path'],
            'hero_academic_image' => ['value' => '/images/default/academic.jpg', 'type' => 'image_path'],
            'hero_music_image' => ['value' => '/images/default/music.jpg', 'type' => 'image_path'],
            'academic_mood_default' => ['value' => 'day', 'type' => 'text'],
            'music_mood_default' => ['value' => 'studio', 'type' => 'text'],
            'footer_copyright' => ['value' => '© ' . date('Y') . ' – All Rights Reserved', 'type' => 'text'],
            'site_title_academic' => ['value' => 'Dr. Portfolio – Academia', 'type' => 'text'],
            'site_title_music' => ['value' => 'Band Name – Music', 'type' => 'text'],
            'contact_email_academic' => ['value' => 'professor@university.edu', 'type' => 'text'],
            'contact_email_music' => ['value' => 'booking@band.com', 'type' => 'text'],
            'academic_office' => ['value' => 'Room 302, Science Building', 'type' => 'text'],
            'academic_hours' => ['value' => 'By Appointment', 'type' => 'text'],
            'music_studio' => ['value' => 'Sonic Temple Studio', 'type' => 'text'],
            'music_booking' => ['value' => 'Available for Gigs', 'type' => 'text'],
        ];
    }

    public function index()
    {
        // Ensure all default settings exist
        foreach ($this->defaultSettings as $key => $config) {
            if (! PortfolioSetting::where('setting_key', $key)->exists()) {
                PortfolioSetting::create([
                    'setting_key' => $key,
                    'setting_value' => $config['value'],
                    'setting_type' => $config['type'],
                ]);
            }
        }

        $settings = PortfolioSetting::all()->map(function ($setting) {
            return [
                'key' => $setting->setting_key,
                'value' => $setting->setting_value,
                'type' => $setting->setting_type,
                'label' => $this->getSettingLabel($setting->setting_key),
            ];
        });

        return view('admin.settings.index', [
            'settings' => $settings,
        ]);
    }

    public function update(UpdateSettingRequest $request)
    {
        foreach ($request->settings as $setting) {
            PortfolioSetting::set(
                $setting['key'],
                $setting['value'],
                $setting['type']
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    private function getSettingLabel(string $key): string
    {
        return match($key) {
            'hero_parent_image' => 'Parent Landing Hero Image',
            'hero_academic_image' => 'Academic Hero Image',
            'hero_music_image' => 'Music Hero Image',
            'academic_mood_default' => 'Default Academic Mood',
            'music_mood_default' => 'Default Music Mood',
            'footer_copyright' => 'Footer Copyright Text',
            'site_title_academic' => 'Academic Site Title',
            'site_title_music' => 'Music Site Title',
            'contact_email_academic' => 'Academic Contact Email',
            'contact_email_music' => 'Music Contact Email',
            'academic_office' => 'Academic Office Location',
            'academic_hours' => 'Academic Office Hours',
            'music_studio' => 'Music Studio Name',
            'music_booking' => 'Music Booking Status',
            default => $key,
        };
    }
}
