<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Show the contact page.
     */
    public function index(): View
    {
        return view('contact.index');
    }

    /**
     * Handle the contact form submission.
     * Rate-limited: max 5 submissions per IP per minute.
     */
    public function send(Request $request): RedirectResponse
    {
        // ── Rate limiting ────────────────────────────────────────────────
        $key = 'contact-form:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['rate_limit' => "Terlalu banyak percobaan. Silakan coba lagi dalam {$seconds} detik."]);
        }

        RateLimiter::hit($key, 60);

        // ── Validation ───────────────────────────────────────────────────
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email:rfc,dns', 'max:150'],
            'phone'   => ['nullable', 'string', 'regex:/^[0-9\+\-\s]{7,20}$/'],
            'company' => ['nullable', 'string', 'max:150'],
            'subject' => ['nullable', 'string', 'in:daftar_pelatihan,konsultasi_karir,kerjasama,informasi_umum'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'name.required'    => 'Nama lengkap wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min'      => 'Pesan terlalu pendek, minimal 10 karakter.',
        ]);

        // ── Sanitize ─────────────────────────────────────────────────────
        $validated = array_map(
            fn ($v) => is_string($v) ? strip_tags($v) : $v,
            $validated
        );

        // ── Store to DB ──────────────────────────────────────────────────
        Contact::create([
            ...$validated,
            'ip_address' => $request->ip(),
            'user_agent' => substr($request->userAgent() ?? '', 0, 512),
            'status'     => Contact::STATUS_UNREAD,
        ]);

        // ── Send email notification ──────────────────────────────────────
        try {
            Mail::send([], [], function ($mail) use ($validated) {
                $mail->to(config('mail.contact_to', 'info@stc-subang.com'))
                    ->subject('[STC Website] Pesan Baru: ' . ($validated['subject'] ?? 'Informasi Umum'))
                    ->html(view('emails.contact', $validated)->render());
            });
        } catch (\Throwable $e) {
            // Log error tapi jangan expose ke user
            report($e);
        }

        return redirect()
            ->to(route('contact.index') . '#contact-form')
            ->with('contact_success', 'Pesan Anda berhasil dikirim. Tim kami akan segera menghubungi Anda dalam 1×24 jam kerja.');
    }
}