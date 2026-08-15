<?php

namespace Database\Seeders;

use App\Models\PortfolioSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Portfolio Admin',
            'email' => 'admin@dualportfolio.com',
            'password' => Hash::make('SecurePass123!'), // Change immediately after first login
            'email_verified_at' => now(),
        ]);

        // Seed default settings
        $defaults = [
            'hero_parent_image' => ['value' => '/images/default/parent.jpg', 'type' => 'image_path'],
            'hero_academic_image' => ['value' => '/images/default/academic.jpg', 'type' => 'image_path'],
            'hero_music_image' => ['value' => '/images/default/music.jpg', 'type' => 'image_path'],
            'academic_mood_default' => ['value' => 'day', 'type' => 'text'],
            'music_mood_default' => ['value' => 'studio', 'type' => 'text'],
            'footer_copyright' => ['value' => '© ' . date('Y') . ' – All Rights Reserved', 'type' => 'text'],
            'site_title_academic' => ['value' => 'Dr. Portfolio – Academia', 'type' => 'text'],
            'site_title_music' => ['value' => 'Sonic Temple – Music', 'type' => 'text'],
            'contact_email_academic' => ['value' => 'professor@university.edu', 'type' => 'text'],
            'contact_email_music' => ['value' => 'booking@sonictemple.com', 'type' => 'text'],
            'academic_office' => ['value' => 'Room 302, Science Building', 'type' => 'text'],
            'academic_hours' => ['value' => 'By Appointment', 'type' => 'text'],
            'music_studio' => ['value' => 'Sonic Temple Studio', 'type' => 'text'],
            'music_booking' => ['value' => 'Available for Gigs', 'type' => 'text'],
        ];

        foreach ($defaults as $key => $config) {
            PortfolioSetting::create([
                'setting_key' => $key,
                'setting_value' => $config['value'],
                'setting_type' => $config['type'],
            ]);
        }

        $this->command->info('Admin user created: admin@dualportfolio.com / SecurePass123!');
        $this->command->info('Please change the password immediately after first login.');
    }
}
