<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body style="margin:0;padding:0;background:#eef5ff;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#eef5ff;">
    <tr><td align="center" style="padding:32px 16px;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:600px;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 8px 24px rgba(48,74,137,.12);">
            <tr><td align="center" style="padding:28px 32px 22px;background:#304a89;border-bottom:5px solid #3ea3d9;">
                <a href="{{ route('home') }}" style="text-decoration:none;"><img src="{{ asset('images/logo.png') }}" width="96" alt="Libras+" style="display:block;width:96px;max-width:100%;height:auto;border:0;"></a>
            </td></tr>
            <tr><td style="padding:38px 42px 34px;">@yield('content')</td></tr>
            <tr><td style="height:6px;background:#84c341;"><div style="height:6px;background:linear-gradient(90deg,#84c341 0 25%,#f6b739 25% 50%,#f47b2a 50% 75%,#d92d73 75%);"></div></td></tr>
            <tr><td align="center" style="padding:22px 32px;background:#18264b;color:#d9e9ff;font-size:12px;line-height:18px;">Repositório Libras+</td></tr>
        </table>
    </td></tr>
</table>
</body>
</html>
