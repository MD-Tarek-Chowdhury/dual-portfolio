<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicRecord;
use App\Models\MusicalRecord;

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

        return view('admin.trash.index', [
            'academicRecords' => $academicTrashed,
            'musicRecords' => $musicTrashed,
        ]);
    }
}
