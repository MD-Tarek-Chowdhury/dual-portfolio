<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMusicalRecordRequest;
use App\Models\MusicalRecord;
use Illuminate\Http\Request;

class MusicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MusicalRecord::withTrashed()
            ->when($request->search, function ($q, $search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->when($request->type, function ($q, $type) {
                $q->where('record_type', $type);
            })
            ->when($request->status === 'active', fn ($q) => $q->whereNull('deleted_at'))
            ->when($request->status === 'trashed', fn ($q) => $q->whereNotNull('deleted_at'))
            ->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'desc');

        return view('admin.music-records.index', [
            'records' => $query->paginate(15)->withQueryString(),
            'filters' => $request->only(['search', 'type', 'status']),
            'types' => ['band_info', 'discography', 'instrument', 'course'],
        ]);
    }

    public function create()
    {
        return view('admin.music-records.form', [
            'types' => ['band_info', 'discography', 'instrument', 'course'],
            'record' => null,
        ]);
    }

    public function store(StoreMusicalRecordRequest $request)
    {
        $record = MusicalRecord::create($request->validated());

        return redirect()->route('admin.music-records.index')
            ->with('success', 'Music record created successfully.');
    }

    public function edit(MusicalRecord $musicalRecord)
    {
        return view('admin.music-records.form', [
            'types' => ['band_info', 'discography', 'instrument', 'course'],
            'record' => $musicalRecord,
        ]);
    }

    public function update(StoreMusicalRecordRequest $request, MusicalRecord $musicalRecord)
    {
        $musicalRecord->update($request->validated());

        return redirect()->route('admin.music-records.index')
            ->with('success', 'Music record updated successfully.');
    }

    public function destroy(MusicalRecord $musicalRecord)
    {
        $musicalRecord->delete();

        return redirect()->route('admin.music-records.index')
            ->with('success', 'Music record moved to trash.');
    }

    public function restore(MusicalRecord $musicalRecord)
    {
        $musicalRecord->restore();

        return redirect()->route('admin.trash.index')
            ->with('success', 'Music record restored successfully.');
    }

    public function forceDelete(MusicalRecord $musicalRecord)
    {
        $musicalRecord->forceDelete();

        return redirect()->route('admin.trash.index')
            ->with('success', 'Music record permanently deleted.');
    }
}
