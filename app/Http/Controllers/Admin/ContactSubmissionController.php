<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactSubmission::query()
            ->when($request->type, function ($q, $type) {
                $q->where('contact_type', $type);
            })
            ->when($request->search, function ($q, $search) {
                $q->where(function ($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%")
                       ->orWhere('subject', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc');

        return view('admin.contact-submissions.index', [
            'submissions' => $query->paginate(20)->withQueryString(),
            'filters' => $request->only(['type', 'search']),
        ]);
    }

    public function show(ContactSubmission $submission)
    {
        if (! $submission->read_at) {
            $submission->update(['read_at' => now()]);
        }

        return view('admin.contact-submissions.show', [
            'submission' => $submission,
        ]);
    }

    public function destroy(ContactSubmission $submission)
    {
        $submission->delete();

        return redirect()->route('admin.contact-submissions.index')
            ->with('success', 'Submission deleted.');
    }
}
