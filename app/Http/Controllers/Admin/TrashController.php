<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicRecord;
use App\Models\MusicalRecord;
use Inertia\Inertia;

class TrashController extends Controller
{
    public function index()
    {
        $academicTrashed = AcademicRecord::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();

        $musicTrashed = MusicalRecord::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();

        return Inertia::render('Admin/Trash/Index', [
            'academicRecords' => $academicTrashed,
            'musicRecords' => $musicTrashed,
        ]);
    }
}
