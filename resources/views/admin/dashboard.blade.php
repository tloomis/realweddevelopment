<x-app-layout>
    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            animation: fadeIn 0.2s ease;
        }

        .modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .modal-content {
            background: white;
            border-radius: 1rem;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #64748b;
            cursor: pointer;
            padding: 0;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .modal-close:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .modal-body {
            padding: 1.5rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>

    <!-- Success Message -->
    @if(session('success'))
        <div style="padding: 1rem 1.5rem; background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 0.75rem; color: #065f46; font-size: 0.9375rem; margin-bottom: 1.5rem; font-weight: 500; display: flex; align-items: center; justify-content: space-between;">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #065f46; cursor: pointer; font-size: 1.25rem; padding: 0; margin-left: 1rem;">&times;</button>
        </div>
    @endif

    <!-- Validation Errors -->
    @if($errors->any())
        <div style="padding: 1rem 1.5rem; background: #fef2f2; border: 1px solid #fecaca; border-radius: 0.75rem; color: #991b1b; font-size: 0.9375rem; margin-bottom: 1.5rem; font-weight: 500;">
            <div style="font-weight: 600; margin-bottom: 0.5rem;">Please fix the following errors:</div>
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('createClientModal').classList.add('active');
            });
        </script>
    @endif

    <!-- Dashboard Header -->
    <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="dashboard-title">Admin Dashboard</h1>
            <p class="dashboard-subtitle">Welcome back, {{ Auth::user()->name }}! Manage your clients and monitor system activity.</p>
        </div>
        <button onclick="document.getElementById('createClientModal').classList.add('active')" class="btn-dashboard" style="background: white; color: #0891b2; border: 2px solid white; font-size: 0.9375rem; padding: 0.75rem 1.5rem;">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Client
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Clients</div>
            <div class="stat-value">{{ $clients->count() }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Active Users</div>
            <div class="stat-value">{{ $clients->count() }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">New This Month</div>
            <div class="stat-value">{{ $clients->where('created_at', '>=', now()->subMonth())->count() }}</div>
        </div>
    </div>

    <!-- Clients Table -->
    <div class="content-card">
        <div class="content-card-header">
            <h2 class="content-card-title">Client Users</h2>
        </div>
        <div class="content-card-body">
            @if($clients->count() > 0)
                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered</th>
                                <th>Status</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.clients.show', $client) }}" style="font-weight: 600; color: #0891b2; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#0e7490'" onmouseout="this.style.color='#0891b2'">
                                            {{ $client->name }}
                                        </a>
                                    </td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge badge-success">Active</span>
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                            <a href="{{ route('admin.clients.show', $client) }}" style="background: #e0f2fe; color: #0369a1; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-block;" onmouseover="this.style.background='#0891b2'; this.style.color='white';" onmouseout="this.style.background='#e0f2fe'; this.style.color='#0369a1';">
                                                View Details
                                            </a>
                                            <form method="POST" action="{{ route('admin.clients.impersonate', $client) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" style="background: #cffafe; color: #0e7490; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#06b6d4'; this.style.color='white';" onmouseout="this.style.background='#cffafe'; this.style.color='#0e7490';">
                                                    Login as User
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 4rem 2rem; color: #64748b;">
                    <svg style="width: 4rem; height: 4rem; margin: 0 auto 1rem; color: #cbd5e1;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">No Clients Yet</h3>
                    <p>Client users will appear here when they register.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Create Client Modal -->
    <div id="createClientModal" class="modal-overlay" onclick="if(event.target === this) this.classList.remove('active')">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Create New Client</h3>
                <button class="modal-close" onclick="document.getElementById('createClientModal').classList.remove('active')" type="button">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.clients.store') }}">
                    @csrf

                    <!-- Name -->
                    <div style="margin-bottom: 1.25rem;">
                        <label for="name" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                            Full Name
                        </label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s ease;"
                            onfocus="this.style.borderColor='#0891b2'; this.style.boxShadow='0 0 0 3px rgba(8, 145, 178, 0.1)';"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                        >
                    </div>

                    <!-- Email -->
                    <div style="margin-bottom: 1.25rem;">
                        <label for="email" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                            Email Address
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s ease;"
                            onfocus="this.style.borderColor='#0891b2'; this.style.boxShadow='0 0 0 3px rgba(8, 145, 178, 0.1)';"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                        >
                    </div>

                    <!-- Password -->
                    <div style="margin-bottom: 1.25rem;">
                        <label for="password" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                            Password
                        </label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s ease;"
                            onfocus="this.style.borderColor='#0891b2'; this.style.boxShadow='0 0 0 3px rgba(8, 145, 178, 0.1)';"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                        >
                    </div>

                    <!-- Confirm Password -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="password_confirmation" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                            Confirm Password
                        </label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s ease;"
                            onfocus="this.style.borderColor='#0891b2'; this.style.boxShadow='0 0 0 3px rgba(8, 145, 178, 0.1)';"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                        >
                    </div>

                    <!-- Form Actions -->
                    <div style="display: flex; gap: 1rem;">
                        <button type="button" onclick="document.getElementById('createClientModal').classList.remove('active')" class="btn-dashboard-secondary" style="flex: 1;">
                            Cancel
                        </button>
                        <button type="submit" class="btn-dashboard" style="flex: 1;">
                            Create Client
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
