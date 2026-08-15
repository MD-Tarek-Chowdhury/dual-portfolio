<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAcademicRecordRequest;
use App\Models\AcademicRecord;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = AcademicRecord::withTrashed()
            ->when($request->search, function ($q, $search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle_or_institution', 'like', "%{$search}%");
            })
            ->when($request->type, function ($q, $type) {
                $q->where('record_type', $type);
            })
            ->when($request->status === 'active', fn ($q) => $q->whereNull('deleted_at'))
            ->when($request->status === 'trashed', fn ($q) => $q->whereNotNull('deleted_at'))
            ->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'desc');

        return Inertia::render('Admin/AcademicRecords/Index', [
            'records' => $query->paginate(15)->withQueryString(),
            'filters' => $request->only(['search', 'type', 'status']),
            'types' => ['publication', 'course', 'designation', 'achievement'],
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/AcademicRecords/Form', [
            'types' => ['publication', 'course', 'designation', 'achievement'],
            'record' => null,
        ]);
    }

    public function store(StoreAcademicRecordRequest $request)
    {
        $record = AcademicRecord::create($request->validated());

        return redirect()->route('admin.academic-records.index')
            ->with('success', 'Academic record created successfully.');
    }

    public function edit(AcademicRecord $academicRecord)
    {
        return Inertia::render('Admin/AcademicRecords/Form', [
            'types' => ['publication', 'course', 'designation', 'achievement'],
            'record' => $academicRecord,
        ]);
    }

    public function update(StoreAcademicRecordRequest $request, AcademicRecord $academicRecord)
    {
        $academicRecord->update($request->validated());

        return redirect()->route('admin.academic-records.index')
            ->with('success', 'Academic record updated successfully.');
    }

    public function destroy(AcademicRecord $academicRecord)
    {
        $academicRecord->delete();

        return redirect()->route('admin.academic-records.index')
            ->with('success', 'Academic record moved to trash.');
    }

    public function restore(AcademicRecord $academicRecord)
    {
        $academicRecord->restore();

        return redirect()->route('admin.trash.index')
            ->with('success', 'Academic record restored successfully.');
    }

    public function forceDelete(AcademicRecord $academicRecord)
    {
        $academicRecord->forceDelete();

        return redirect()->route('admin.trash.index')
            ->with('success', 'Academic record permanently deleted.');
    }
}
