<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Tagihan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #40eabcff 0%, #e6e3e8ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .invoice-container { 
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            position: relative;
            min-height: 600px;
            padding-bottom: 30px;
        }

        .invoice-header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .invoice-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            animation: float 20s linear infinite;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-20px, -20px) rotate(360deg); }
        }

        .close-btn {
            position: absolute;
            top: 15px;
            left: 20px;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .close-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .invoice-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .invoice-body { padding: 40px; }

        .invoice-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 0;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .invoice-item:hover {
            background: #f8f9ff;
            margin: 0 -20px;
            padding-left: 20px;
            padding-right: 20px;
            border-radius: 10px;
        }

        .item-name { font-size: 16px; color: #333; font-weight: 500; }
        .item-amount { font-size: 16px; color: #666; font-weight: 600; }

        .subtotal {
            background: linear-gradient(135deg, #f8f9ff, #e8f2ff);
            margin: 20px -40px;
            padding: 20px 40px;
            border-top: 2px dashed #ddd;
            border-bottom: 2px dashed #ddd;
        }

        .grand-total {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            margin: 20px -40px 0;
            padding: 25px 40px;
            font-size: 20px;
            font-weight: 700;
            position: relative;
            overflow: hidden;
        }

        .grand-total::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .currency { font-size: 14px; opacity: 0.8; }
        .amount { font-weight: 700; }

        .back-btn {
            display:inline-block;
            margin-top: 25px;
            padding: 12px 24px;
            background:#4CAF50;
            color:#fff;
            text-decoration:none;
            border-radius:8px;
            font-weight:600;
            transition:background 0.3s;
        }
        .back-btn:hover {
            background:#43a047;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #888;
            font-size: 14px;
            background: #f9f9f9;
        }

        @media (max-width: 480px) {
            .invoice-container { margin: 10px; border-radius: 15px; }
            .invoice-header { padding: 20px; }
            .invoice-title { font-size: 24px; }
            .invoice-body { padding: 20px; }
            .subtotal, .grand-total {
                margin-left: -20px;
                margin-right: -20px;
                padding-left: 20px;
                padding-right: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
    <!-- Tombol close balik ke user.home -->
    <a href="{{ route('user.home.index') }}" class="close-btn">&times;</a>

    <h1 class="invoice-title">
        Tagihan Bulan {{ \Carbon\Carbon::parse($pembayaran->created_at)->translatedFormat('F Y') }}
    </h1>
    
    </div>
        
        <div class="invoice-body">
    @php
        $subtotal = 0;
    @endphp

    {{-- Item Keamanan --}}
    <div class="invoice-item">
        <div class="item-name">Pengganti Pengelolaan Lingkungan</div>
        <div class="item-amount">
            <span class="currency">Rp</span>
            <span class="amount">{{ number_format($pembayaran->keamanan, 0, ',', '.') }}</span>
        </div>
    </div>
    @php $subtotal += $pembayaran->keamanan; @endphp

    {{-- Item Kebersihan --}}
    <div class="invoice-item">
        <div class="item-name">Pengelolaan Sampah</div>
        <div class="item-amount">
            <span class="currency">Rp</span>
            <span class="amount">{{ number_format($pembayaran->kebersihan, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Item tanggal jatuh tempo --}}
    <div class="invoice-item">
        <div class="item-name">Jatuh Tempo</div>
        <div class="item-amount">
            
            <span class="amount">{{ \Carbon\Carbon::parse($pembayaran->tanggal_jatuh_tempo)->format('d-m-Y') }}</span>
        </div>
    </div>

    @php $subtotal += $pembayaran->kebersihan; @endphp

    {{-- Subtotal --}}
    <div class="subtotal">
        <div class="invoice-item" style="border: none; margin: 0; padding: 0;">
            <div class="item-name" style="font-weight: 600;">Sub Total</div>
            <div class="item-amount">
                <span class="currency">Rp</span>
                <span class="amount">{{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Grand Total --}}
    <div class="grand-total">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>Grand Total</div>
            <div>
                <span class="currency">Rp</span>
                <span class="amount">{{ number_format($pembayaran->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
        </div>    
        <div class="footer">
            Terima kasih atas kepercayaan Anda
        </div>
    </div>
</body>
</html>