<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email BiConnect</title>
</head>
<body style="margin: 0; padding: 0; background-color: #F5F7FA; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="480" cellpadding="0" cellspacing="0" style="background-color: #FFFFFF; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    {{-- Header --}}
                    <tr>
                        <td style="padding: 40px 40px 20px; text-align: center;">
                            <img src="{{ asset('images/biconnect-logo.webp') }}" alt="BiConnect" style="height: 36px; width: auto;">
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 20px 40px 40px; text-align: left;">
                            <h2 style="font-size: 20px; font-weight: 700; color: #111827; margin: 0 0 12px; text-align: center;">
                                Verifikasi Email Kamu
                            </h2>
                            <p style="font-size: 14px; color: #6B7280; line-height: 1.6; margin: 0 0 24px; text-align: center;">
                                Terima kasih telah mendaftar di BiConnect. Klik tombol di bawah ini untuk memverifikasi alamat email kamu.
                            </p>

                            {{-- CTA Button --}}
                            <div style="text-align: center; margin-bottom: 24px;">
                                <a href="{{ $verificationUrl }}"
                                   style="display: inline-block; padding: 14px 40px; background-color: #2C5BFF; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-size: 15px; font-weight: 600; text-align: center;">
                                    Verifikasi Email
                                </a>
                            </div>

                            <p style="font-size: 12px; color: #9CA3AF; line-height: 1.5; margin: 0 0 8px; text-align: center;">
                                Atau salin dan tempel tautan ini di browser:
                            </p>
                            <p style="font-size: 11px; color: #6B7280; line-height: 1.5; margin: 0 0 24px; text-align: center; word-break: break-all;">
                                {{ $verificationUrl }}
                            </p>

                            {{-- Divider --}}
                            <hr style="border: none; border-top: 1px solid #E5E7EB; margin: 0 0 20px;">

                            <p style="font-size: 11px; color: #9CA3AF; line-height: 1.5; margin: 0; text-align: center;">
                                Tautan ini berlaku selama 24 jam. Jika kamu tidak mendaftar di BiConnect, abaikan email ini.
                            </p>
                        </td>
                    </tr>
                </table>

                {{-- Footer --}}
                <p style="font-size: 11px; color: #9CA3AF; margin-top: 16px; text-align: center;">
                    &copy; {{ date('Y') }} BiConnect. Platform Kolaborasi Mahasiswa BSI.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
