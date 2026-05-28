{{-- resources/views/emails/contact.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<style>
    body { font-family: Arial, sans-serif; line-height: 1.6; color: #1a1b1e; margin: 0; padding: 0; background: #f4f7f9; }
    .wrapper { max-width: 600px; margin: 32px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
    .header  { background: #002046; padding: 24px 32px; }
    .header h1 { color: #fff; margin: 0; font-size: 20px; }
    .header span { color: #F96302; font-size: 12px; letter-spacing: 2px; text-transform: uppercase; }
    .body    { padding: 32px; }
    .row     { margin-bottom: 20px; }
    .label   { font-size: 11px; font-weight: 700; color: #74777f; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
    .value   { font-size: 15px; color: #1a1b1e; padding: 10px 14px; background: #f4f7f9; border-radius: 4px; border-left: 3px solid #F96302; }
    .footer  { background: #f4f7f9; padding: 16px 32px; font-size: 12px; color: #74777f; text-align: center; }
</style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <span>STC Indonesia</span>
        <h1>Pesan Baru dari Website</h1>
    </div>
    <div class="body">
        <div class="row">
            <div class="label">Nama</div>
            <div class="value">{{ $name }}</div>
        </div>
        <div class="row">
            <div class="label">Email</div>
            <div class="value">{{ $email }}</div>
        </div>
        @if (!empty($phone))
        <div class="row">
            <div class="label">Telepon</div>
            <div class="value">{{ $phone }}</div>
        </div>
        @endif
        @if (!empty($subject))
        <div class="row">
            <div class="label">Topik</div>
            <div class="value">{{ $subject }}</div>
        </div>
        @endif
        <div class="row">
            <div class="label">Pesan</div>
            <div class="value" style="white-space: pre-wrap;">{{ $message }}</div>
        </div>
    </div>
    <div class="footer">
        Pesan ini dikirim melalui form kontak website STC Indonesia.<br />
        &copy; {{ date('Y') }} Subang Training Center
    </div>
</div>
</body>
</html>
