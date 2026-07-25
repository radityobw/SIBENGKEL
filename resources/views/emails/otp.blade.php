<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP SIBENGKEL</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #000000;
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid #e65100;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }
        .otp-box {
            background-color: #fff3e0; /* light orange */
            border: 1px solid #ffb74d;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #e65100; /* SIBENGKEL Orange */
            letter-spacing: 5px;
            margin: 0;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666666;
        }
        .warning {
            font-size: 14px;
            color: #d32f2f;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" style="height: 50px; margin-bottom: 15px; object-fit: contain; filter: invert(1); -webkit-filter: invert(1);">
            <h1>SIBENGKEL</h1>
        </div>
        <div class="content">
            <h2>Permintaan Reset Password</h2>
            <p>Halo,</p>
            <p>Kami menerima permintaan untuk mereset kata sandi akun SIBENGKEL Anda. Gunakan kode OTP (One Time Password) berikut untuk melanjutkan proses pengaturan ulang kata sandi:</p>
            
            <div class="otp-box">
                <p class="otp-code">{{ $otp }}</p>
            </div>
            
            <p class="warning"><strong>PENTING:</strong> Kode ini hanya berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun, termasuk pihak yang mengatasnamakan SIBENGKEL.</p>
            
            <p>Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini dan pastikan akun Anda tetap aman.</p>
            
            <p>Terima kasih,<br><strong>Tim Keamanan SIBENGKEL</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} SIBENGKEL. Hak Cipta Dilindungi.</p>
            <p>Email ini dikirim secara otomatis. Mohon jangan membalas email ini.</p>
        </div>
    </div>
</body>
</html>
