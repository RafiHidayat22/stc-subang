{{-- resources/views/emails/contact.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pesan Baru dari Website STC Indonesia</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f7f9;
            color: #1a1b1e;
            font-size: 15px;
            line-height: 1.6;
        }
        .wrapper {
            max-width: 620px;
            margin: 32px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,32,70,.10);
        }
        /* Header */
        .header {
            background: #002046;
            padding: 32px 40px;
            text-align: center;
        }
        .header-logo {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: .04em;
        }
        .header-logo span { color: #F96302; }
        .header-subtitle {
            margin-top: 6px;
            font-size: 12px;
            color: rgba(255,255,255,.55);
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        /* Badge */
        .badge-row {
            background: #F96302;
            padding: 10px 40px;
            text-align: center;
        }
        .badge-row p {
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            letter-spacing: .1em;
            text-transform: uppercase;
        }
        /* Body */
        .body { padding: 36px 40px; }
        .title {
            font-size: 20px;
            font-weight: 700;
            color: #002046;
            margin-bottom: 6px;
        }
        .intro {
            color: #44474e;
            font-size: 14px;
            margin-bottom: 28px;
        }
        /* Field rows */
        .field-group { margin-bottom: 20px; }
        .field-label {
            font-size: 11px;
            font-weight: 700;
            color: #F96302;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 4px;
        }
        .field-value {
            background: #f4f7f9;
            border-left: 3px solid #002046;
            padding: 10px 14px;
            border-radius: 0 6px 6px 0;
            font-size: 14px;
            color: #1a1b1e;
            word-break: break-word;
        }
        /* Message box */
        .message-box {
            background: #f4f7f9;
            border: 1px solid #e3e2e6;
            border-radius: 8px;
            padding: 16px 18px;
            font-size: 14px;
            color: #1a1b1e;
            white-space: pre-wrap;
            word-break: break-word;
            line-height: 1.7;
        }
        /* CTA */
        .cta-row {
            margin-top: 28px;
            text-align: center;
        }
        .cta-btn {
            display: inline-block;
            background: #002046;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            padding: 12px 28px;
            border-radius: 8px;
            letter-spacing: .04em;
        }
        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid #e3e2e6;
            margin: 28px 0;
        }
        /* Meta info */
        .meta {
            background: #f4f7f9;
            border-radius: 8px;
            padding: 14px 18px;
            font-size: 12px;
            color: #74777f;
        }
        .meta p { margin-bottom: 4px; }
        .meta p:last-child { margin-bottom: 0; }
        .meta strong { color: #44474e; }
        /* Footer */
        .footer {
            background: #002046;
            padding: 20px 40px;
            text-align: center;
        }
        .footer p {
            font-size: 12px;
            color: rgba(255,255,255,.45);
        }
        .footer a {
            color: #F96302;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- ── Header ── --}}
    <div class="header">
        <div class="header-logo">STC <span>Indonesia</span></div>
        <div class="header-subtitle">Subang Training Center</div>
    </div>

    {{-- ── Badge ── --}}
    <div class="badge-row">
        <p>📬 Pesan Baru Masuk dari Website</p>
    </div>

    {{-- ── Body ── --}}
    <div class="body">
        <p class="title">Ada Pesan Baru!</p>
        <p class="intro">
            Seseorang telah mengirimkan pesan melalui formulir kontak di website STC Indonesia.
            Silakan tindaklanjuti sesuai subjek yang dipilih.
        </p>

        {{-- Sender Info --}}
        <div class="field-group">
            <div class="field-label">Nama Lengkap</div>
            <div class="field-value">{{ $name }}</div>
        </div>

        @if (!empty($company))
        <div class="field-group">
            <div class="field-label">Perusahaan / Institusi</div>
            <div class="field-value">{{ $company }}</div>
        </div>
        @endif

        <div class="field-group">
            <div class="field-label">Email</div>
            <div class="field-value">
                <a href="mailto:{{ $email }}" style="color:#002046;">{{ $email }}</a>
            </div>
        </div>

        @if (!empty($phone))
        <div class="field-group">
            <div class="field-label">Nomor Telepon</div>
            <div class="field-value">
                <a href="tel:{{ $phone }}" style="color:#002046;">{{ $phone }}</a>
            </div>
        </div>
        @endif

        <div class="field-group">
            <div class="field-label">Subjek Inquiry</div>
            <div class="field-value">
                @php
                    $subjectLabels = [
                        'daftar_pelatihan' => 'Pendaftaran Training',
                        'konsultasi_karir' => 'Info Sertifikasi BNSP',
                        'kerjasama'        => 'Inhouse Training / Corporate',
                        'informasi_umum'   => 'Informasi Umum',
                    ];
                @endphp
                {{ $subjectLabels[$subject ?? ''] ?? 'Informasi Umum' }}
            </div>
        </div>

        {{-- Message --}}
        <div class="field-label" style="margin-bottom:8px;">Isi Pesan</div>
        <div class="message-box">{{ $message }}</div>

        {{-- CTA Reply --}}
        <div class="cta-row">
            <a href="mailto:{{ $email }}?subject=Re: Inquiry STC Indonesia" class="cta-btn">
                Balas Email Ini
            </a>
        </div>

        <hr class="divider" />

        {{-- Meta / Audit --}}
        <div class="meta">
            <p><strong>Waktu Terima:</strong> {{ now()->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</p>
            <p><strong>IP Address:</strong> {{ request()->ip() }}</p>
            <p><strong>Platform:</strong> Website STC Indonesia — Formulir Kontak</p>
        </div>
    </div>

    {{-- ── Footer ── --}}
    <div class="footer">
        <p>
            Email ini dikirim otomatis oleh sistem website
            <a href="https://stc-subang.com">stc-subang.com</a>.<br>
            Jangan membalas email ini secara langsung — gunakan tombol <strong style="color:#F96302">Balas Email Ini</strong> di atas.
        </p>
    </div>

</div>
</body>
</html>