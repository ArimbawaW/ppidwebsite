<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PPID Kementerian PKP - Pengembangan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --pkp-navy: #1a2e44;
            --pkp-gold: #c5a059;
            --pkp-light-gold: #e2c286;
            --text-gray: #4a5568;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: #ffffff;
            color: var(--pkp-navy);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            border-top: 6px solid var(--pkp-navy);
        }

        .content-wrapper {
            text-align: center;
            max-width: 500px;
            padding: 20px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease-out forwards;
        }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-section img {
            height: 85px;
            margin-bottom: 40px;
        }

        .divider {
            width: 0;
            height: 2px;
            background: var(--pkp-gold);
            margin: 0 auto 32px;
            animation: growWidth 1s ease-out 0.5s forwards;
        }

        @keyframes growWidth {
            to { width: 50px; }
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            margin-bottom: 16px;
            text-transform: uppercase;
        }

        .description {
            font-size: 1rem;
            color: var(--text-gray);
            line-height: 1.6;
            margin-bottom: 32px;
        }

        /* Tombol Beranda */
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: var(--pkp-navy);
            color: #ffffff;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 40px;
        }

        .btn-home:hover {
            background-color: var(--pkp-gold);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .btn-home i {
            font-size: 1.1rem;
        }

        .status-box {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .footer {
            position: absolute;
            bottom: 40px;
            font-size: 0.75rem;
            color: #94a3b8;
            letter-spacing: 0.05em;
            opacity: 0;
            animation: fadeIn 1s ease-in 1.2s forwards;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }
    </style>
</head>
<body>

    <div class="content-wrapper">
        <div class="logo-section">
            <img src="{{ asset('images/LogoPKP.png') }}" alt="Logo Kementerian PKP">
        </div>

        <div class="divider"></div>

        <h1>Under Development</h1>
        
        <p class="description">
            Layanan Informasi Publik (PPID) sedang dalam proses pembaruan sistem. Silakan kembali ke beranda utama untuk informasi lainnya.
        </p>

        <a href="/" class="btn-home">
            <i class="bi bi-house-door"></i>
            KEMBALI KE BERANDA
        </a>

        <div class="status-box">
            <i class="bi bi-info-circle-fill"></i> Maintenance Mode
        </div>
    </div>

    <div class="footer">
        &copy; 2026 KEMENTERIAN PERUMAHAN DAN KAWASAN PERMUKIMAN RI
    </div>

</body>
</html>