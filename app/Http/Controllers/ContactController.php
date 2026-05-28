<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * Handle the contact form submission.
     * Rate-limited: max 5 submissions per IP per minute.
     */
    public function send(Request $request): RedirectResponse
    {
        // --- Rate limiting (security) ---
        $key = 'contact-form:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['rate_limit' => "Terlalu banyak percobaan. Silakan coba lagi dalam {$seconds} detik."]);
        }

        RateLimiter::hit($key, 60);

        // --- Validation ---
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email:rfc,dns', 'max:150'],
            'phone'   => ['nullable', 'string', 'regex:/^[0-9\+\-\s]{7,20}$/'],
            'subject' => ['nullable', 'string', 'in:daftar_pelatihan,konsultasi_karir,kerjasama,informasi_umum'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'name.required'    => 'Nama lengkap wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min'      => 'Pesan terlalu pendek, minimal 10 karakter.',
        ]);

        // --- Sanitize (strip tags for extra safety, already prevented by validation) ---
        $validated = array_map(fn ($v) => is_string($v) ? strip_tags($v) : $v, $validated);

        // --- Store to DB (optional, uncomment if you have a contacts table) ---
        // \App\Models\Contact::create($validated);

        // --- Send email ---
        try {
            Mail::send([], [], function ($mail) use ($validated) {
                $mail->to(config('mail.contact_to', 'info@stc-subang.com'))
                    ->subject('[STC Website] Pesan Baru: ' . ($validated['subject'] ?? 'Informasi Umum'))
                    ->html(view('emails.contact', $validated)->render());
            });
        } catch (\Throwable $e) {
            report($e);
            // Don't expose internals; show generic success to prevent enumeration
        }

        return redirect()
            ->to(route('home') . '#contact')
            ->with('contact_success', 'Pesan Anda berhasil dikirim. Tim kami akan segera menghubungi Anda.');
    }
}
