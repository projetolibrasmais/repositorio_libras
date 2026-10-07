@extends('emails.layout')

@section('title', 'Resposta ao seu contato - Plataforma Digital Libras+')

@section('content')
    <p style="margin:0 0 10px;color:#d92d73;font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;">Resposta ao seu contato</p>
    <h1 style="margin:0 0 22px;color:#304a89;font-size:26px;line-height:34px;">Olá, {{ $userName}}!</h1>
    <p style="margin:0 0 28px;font-size:16px;line-height:25px;">{{ $mensagem }}</p>
    <p style="margin:0 0 12px;padding:14px 16px;background:#eef5ff;border-left:4px solid #3ea3d9;border-radius:6px;font-size:14px;line-height:21px;color:#263c73;">{{ $resposta }}</p>
    <p style="margin:20px 0 0;color:#6b7280;font-size:13px;line-height:20px;">Esta é uma mensagem automática. Por favor, não responda a este e-mail.</p>
@endsection
