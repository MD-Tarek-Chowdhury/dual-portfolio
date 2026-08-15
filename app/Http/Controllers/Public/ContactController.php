<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\ContactFormRequest;
use App\Jobs\SendContactEmail;
use App\Models\ContactSubmission;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    public function store(ContactFormRequest $request)
    {
        $key = 'contact-form:' . $request->ip() . ':' . md5($request->email);

        $executed = RateLimiter::attempt(
            $key,
            $perMinute = config('portfolio.contact.rate_limit', 5),
            function () use ($request) {
                $submission = ContactSubmission::create([
                    'contact_type' => $request->contact_type,
                    'name' => $request->name,
                    'email' => $request->email,
                    'subject' => $request->subject,
                    'message' => $request->message,
                    'ip_address' => $request->ip(),
                ]);

                // Dispatch queued email job
                SendContactEmail::dispatch($submission);

                return true;
            },
            $decaySeconds = config('portfolio.contact.rate_window', 60)
        );

        if (! $executed) {
            return redirect()->back()->with('error', 'Too many messages sent. Please wait a minute before trying again.');
        }

        return redirect()->back()->with('success', 'Your message has been sent successfully. We will get back to you soon.');
    }
}
