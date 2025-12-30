<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --primary: #0891b2;
                --primary-dark: #0e7490;
                --primary-light: #06b6d4;
            }

            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #f0fdfa 0%, #e0f2fe 50%, #f0f9ff 100%);
            }

            .auth-container {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1rem;
            }

            .auth-card {
                background: white;
                border-radius: 1.5rem;
                box-shadow: 0 20px 60px rgba(8, 145, 178, 0.08);
                padding: 3rem;
                width: 100%;
                max-width: 480px;
                border: 1px solid rgba(8, 145, 178, 0.1);
            }

            .auth-logo {
                text-align: center;
                margin-bottom: 2rem;
            }

            .auth-logo a {
                font-size: 2rem;
                font-weight: 800;
                color: #1e293b;
                text-decoration: none;
                letter-spacing: -0.02em;
            }

            .auth-logo a span {
                color: var(--primary);
            }

            .auth-logo p {
                color: #64748b;
                font-size: 0.9375rem;
                margin-top: 0.5rem;
                font-weight: 500;
            }

            .auth-title {
                font-size: 1.75rem;
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 0.5rem;
                text-align: center;
            }

            .auth-subtitle {
                color: #64748b;
                text-align: center;
                margin-bottom: 2rem;
                font-size: 0.9375rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-label {
                display: block;
                font-size: 0.875rem;
                font-weight: 600;
                color: #334155;
                margin-bottom: 0.5rem;
            }

            .form-input {
                width: 100%;
                padding: 0.875rem 1rem;
                border: 1.5px solid #e2e8f0;
                border-radius: 0.75rem;
                font-size: 0.9375rem;
                transition: all 0.2s ease;
                background: white;
            }

            .form-input:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(8, 145, 178, 0.1);
            }

            .form-error {
                color: #ef4444;
                font-size: 0.8125rem;
                margin-top: 0.5rem;
                font-weight: 500;
            }

            .form-checkbox {
                width: 1.125rem;
                height: 1.125rem;
                border: 1.5px solid #cbd5e1;
                border-radius: 0.375rem;
                cursor: pointer;
                accent-color: var(--primary);
            }

            .form-checkbox-label {
                display: flex;
                align-items: center;
                gap: 0.625rem;
                font-size: 0.875rem;
                color: #475569;
                cursor: pointer;
            }

            .btn-primary {
                width: 100%;
                padding: 0.875rem 1.5rem;
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
                color: white;
                border: none;
                border-radius: 0.75rem;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s ease;
                margin-top: 0.5rem;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 24px rgba(8, 145, 178, 0.25);
            }

            .btn-primary:active {
                transform: translateY(0);
            }

            .link-text {
                color: var(--primary);
                text-decoration: none;
                font-weight: 600;
                font-size: 0.875rem;
                transition: color 0.2s ease;
            }

            .link-text:hover {
                color: var(--primary-dark);
            }

            .auth-footer {
                text-align: center;
                margin-top: 2rem;
                padding-top: 2rem;
                border-top: 1px solid #f1f5f9;
                color: #64748b;
                font-size: 0.875rem;
            }

            .auth-footer a {
                color: var(--primary);
                text-decoration: none;
                font-weight: 600;
            }

            .auth-footer a:hover {
                color: var(--primary-dark);
            }

            .status-message {
                padding: 0.875rem 1rem;
                background: #ecfdf5;
                border: 1px solid #a7f3d0;
                border-radius: 0.75rem;
                color: #065f46;
                font-size: 0.875rem;
                margin-bottom: 1.5rem;
                font-weight: 500;
            }

            .flex-between {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 1.5rem;
            }

            @media (max-width: 640px) {
                .auth-card {
                    padding: 2rem 1.5rem;
                }

                .auth-title {
                    font-size: 1.5rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-logo">
                    <a href="/">Real<span>Web</span>Development</a>
                    <p>Professional Web Development Services</p>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
