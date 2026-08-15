<?php

namespace App\Jobs;

use App\Models\ContactSubmission;
use App\Models\PortfolioSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContactEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [60, 120, 300]; // 1min, 2min, 5min

    public function __construct(
        public ContactSubmission $submission
    ) {}

    public function handle(): void
    {
        $toEmail = $this->submission->contact_type === 'academic'
            ? PortfolioSetting::get('contact_email_academic', 'professor@university.edu')
            : PortfolioSetting::get('contact_email_music', 'booking@band.com');

        Mail::send('emails.contact-notification', [
            'submission' => $this->submission,
        ], function ($message) use ($toEmail) {
            $message->to($toEmail)
                    ->subject("New Contact: {$this->submission->subject}")
                    ->replyTo($this->submission->email, $this->submission->name);
        });
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error('Contact email failed', [
            'submission_id' => $this->submission->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
