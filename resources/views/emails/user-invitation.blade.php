@extends('emails.layout')

@section('title', 'Convite para o Repositório Libras+')

@section('content')
    <p style="margin:0 0 10px;color:#3ea3d9;font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;">Bem-vindo(a)</p>
    <h1 style="margin:0 0 22px;color:#304a89;font-size:26px;line-height:34px;">Olá, {{ $userName }}!</h1>
    <p style="margin:0 0 16px;font-size:16px;line-height:25px;">Você foi convidado(a) para fazer parte do sistema Repositório Libras+.</p>
    <p style="margin:0 0 28px;font-size:16px;line-height:25px;">Para começar, defina sua senha de acesso pelo botão abaixo.</p>
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin:0 auto 28px;"><tr><td style="border-radius:9px;background:#304a89;"><a href="{{ $actionUrl }}" style="display:inline-block;padding:14px 28px;color:#fff;font-size:16px;font-weight:700;text-decoration:none;">Definir minha senha</a></td></tr></table>
    <p style="margin:0 0 12px;padding:14px 16px;background:#eef5ff;border-left:4px solid #3ea3d9;border-radius:6px;font-size:14px;line-height:21px;color:#263c73;">Por segurança, este convite expira em 60 minutos.</p>
    <p style="margin:20px 0 0;color:#6b7280;font-size:13px;line-height:20px;">Se você não esperava este convite, pode ignorar este e-mail.</p>
@endsection
