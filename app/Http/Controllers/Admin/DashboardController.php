<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicRecord;
use App\Models\ContactSubmission;
use App\Models\MusicalRecord;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'academic_records' => [
                'total' => AcademicRecord::count(),
                'active' => AcademicRecord::active()->count(),
                'trashed' => AcademicRecord::onlyTrashed()->count(),
                'by_type' => AcademicRecord::selectRaw('record_type, count(*) as count')
                    ->groupBy('record_type')
                    ->pluck('count', 'record_type'),
            ],
            'music_records' => [
                'total' => MusicalRecord::count(),
                'active' => MusicalRecord::active()->count(),
                'trashed' => MusicalRecord::onlyTrashed()->count(),
                'by_type' => MusicalRecord::selectRaw('record_type, count(*) as count')
                    ->groupBy('record_type')
                    ->pluck('count', 'record_type'),
            ],
            'contact_submissions' => [
                'total' => ContactSubmission::count(),
                'unread' => ContactSubmission::whereNull('read_at')->count(),
            ],
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
        ]);
    }
}
