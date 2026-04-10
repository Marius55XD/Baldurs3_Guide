<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactController extends Controller
{
    public function show()
    {
        return view('ContactUs');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        $adminEmail = config('mail.contact_to');

        if (! filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            return back()->withInput()->with('error', 'Contact recipient email is not configured correctly.');
        }

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
            'submitted_at' => now()->toDateTimeString(),
        ];

        $contactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        $payload['message_id'] = $contactMessage->id;

        try {
            Mail::to($adminEmail)->send(new ContactFormSubmitted($payload));
        } catch (TransportExceptionInterface $exception) {
            report($exception);

            return back()->with('success', 'Message saved successfully. Email delivery is temporarily unavailable, but support can still review your message.');
        }

        Log::info('Contact form submission', [
            'message_id' => $contactMessage->id,
            'name' => $payload['name'],
            'email' => $payload['email'],
            'subject' => $payload['subject'],
            'message' => $payload['message'],
            'ip' => $payload['ip'],
            'admin_email' => $adminEmail,
        ]);

        return back()->with('success', 'Message sent successfully to support.');
    }
}
