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
                background: #f8fafc;
            }

            .dashboard-nav {
                background: white;
                border-bottom: 1px solid #e2e8f0;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            }

            .dashboard-container {
                max-width: 1400px;
                margin: 0 auto;
                padding: 2rem 1rem;
            }

            .dashboard-header {
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
                color: white;
                padding: 2rem;
                border-radius: 1rem;
                margin-bottom: 2rem;
                box-shadow: 0 10px 30px rgba(8, 145, 178, 0.2);
            }

            .dashboard-title {
                font-size: 2rem;
                font-weight: 800;
                margin-bottom: 0.5rem;
            }

            .dashboard-subtitle {
                opacity: 0.95;
                font-size: 1rem;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                background: white;
                padding: 1.75rem;
                border-radius: 1rem;
                border: 1px solid #e2e8f0;
                transition: all 0.2s ease;
            }

            .stat-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 24px rgba(8, 145, 178, 0.1);
                border-color: var(--primary-light);
            }

            .stat-label {
                font-size: 0.875rem;
                color: #64748b;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin-bottom: 0.5rem;
            }

            .stat-value {
                font-size: 2.5rem;
                font-weight: 800;
                color: var(--primary);
                line-height: 1;
            }

            .content-card {
                background: white;
                border-radius: 1rem;
                border: 1px solid #e2e8f0;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            }

            .content-card-header {
                padding: 1.5rem;
                border-bottom: 1px solid #e2e8f0;
                background: #f8fafc;
            }

            .content-card-title {
                font-size: 1.25rem;
                font-weight: 700;
                color: #1e293b;
            }

            .content-card-body {
                padding: 1.5rem;
            }

            .btn-dashboard {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1.5rem;
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
                color: white;
                border: none;
                border-radius: 0.5rem;
                font-size: 0.9375rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s ease;
                text-decoration: none;
            }

            .btn-dashboard:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 16px rgba(8, 145, 178, 0.25);
            }

            .btn-dashboard-secondary {
                background: white;
                color: var(--primary);
                border: 1.5px solid var(--primary);
            }

            .btn-dashboard-secondary:hover {
                background: var(--primary);
                color: white;
            }

            .action-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }

            .action-card {
                background: white;
                padding: 1.5rem;
                border-radius: 0.75rem;
                border: 1.5px solid #e2e8f0;
                text-align: center;
                transition: all 0.2s ease;
                cursor: pointer;
                text-decoration: none;
                color: inherit;
                display: block;
            }

            .action-card:hover {
                border-color: var(--primary);
                transform: translateY(-4px);
                box-shadow: 0 8px 16px rgba(8, 145, 178, 0.15);
            }

            .action-icon {
                font-size: 2rem;
                margin-bottom: 0.75rem;
            }

            .action-title {
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 0.25rem;
            }

            .action-description {
                font-size: 0.875rem;
                color: #64748b;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .dashboard-table {
                width: 100%;
                border-collapse: collapse;
            }

            .dashboard-table th {
                background: #f8fafc;
                padding: 1rem;
                text-align: left;
                font-weight: 600;
                font-size: 0.875rem;
                color: #475569;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border-bottom: 2px solid #e2e8f0;
            }

            .dashboard-table td {
                padding: 1rem;
                border-bottom: 1px solid #f1f5f9;
                color: #334155;
            }

            .dashboard-table tr:hover {
                background: #f8fafc;
            }

            .badge {
                display: inline-block;
                padding: 0.375rem 0.75rem;
                border-radius: 0.375rem;
                font-size: 0.8125rem;
                font-weight: 600;
            }

            .badge-success {
                background: #d1fae5;
                color: #065f46;
            }

            .badge-primary {
                background: #cffafe;
                color: #0e7490;
            }

            @media (max-width: 768px) {
                .dashboard-title {
                    font-size: 1.5rem;
                }

                .stats-grid {
                    grid-template-columns: 1fr;
                }

                .stat-value {
                    font-size: 2rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Impersonation Banner -->
            @if(session('impersonate_admin_id'))
                <div style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%); color: white; padding: 0.875rem 0; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span style="font-weight: 600; font-size: 0.9375rem;">
                                Viewing as {{ Auth::user()->name }}
                            </span>
                        </div>
                        <form method="POST" action="{{ route('stop-impersonating') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="background: white; color: #ea580c; border: none; padding: 0.5rem 1.25rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='rgba(255,255,255,0.9)';" onmouseout="this.style.background='white';">
                                Return to Admin
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Page Heading -->
            @isset($header)
                <header class="dashboard-nav">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="dashboard-container">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
