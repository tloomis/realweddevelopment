<x-app-layout>
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1 class="dashboard-title">Create New Client</h1>
        <p class="dashboard-subtitle">Add a new client user to the system</p>
    </div>

    <!-- Create Client Form -->
    <div class="content-card" style="max-width: 600px; margin: 0 auto;">
        <div class="content-card-header">
            <h2 class="content-card-title">Client Information</h2>
        </div>
        <div class="content-card-body">
            <form method="POST" action="{{ route('admin.clients.store') }}">
                @csrf

                <!-- Name -->
                <div style="margin-bottom: 1.5rem;">
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
                        style="width: 100%; padding: 0.875rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; font-size: 0.9375rem; transition: all 0.2s ease;"
                        onfocus="this.style.borderColor='#0891b2'; this.style.boxShadow='0 0 0 3px rgba(8, 145, 178, 0.1)';"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                    >
                    @error('name')
                        <p style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; font-weight: 500;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="email" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                        Email Address
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        style="width: 100%; padding: 0.875rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; font-size: 0.9375rem; transition: all 0.2s ease;"
                        onfocus="this.style.borderColor='#0891b2'; this.style.boxShadow='0 0 0 3px rgba(8, 145, 178, 0.1)';"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                    >
                    @error('email')
                        <p style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; font-weight: 500;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="password" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                        Password
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        style="width: 100%; padding: 0.875rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; font-size: 0.9375rem; transition: all 0.2s ease;"
                        onfocus="this.style.borderColor='#0891b2'; this.style.boxShadow='0 0 0 3px rgba(8, 145, 178, 0.1)';"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                    >
                    @error('password')
                        <p style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; font-weight: 500;">{{ $message }}</p>
                    @enderror
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
                        style="width: 100%; padding: 0.875rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; font-size: 0.9375rem; transition: all 0.2s ease;"
                        onfocus="this.style.borderColor='#0891b2'; this.style.boxShadow='0 0 0 3px rgba(8, 145, 178, 0.1)';"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                    >
                    @error('password_confirmation')
                        <p style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; font-weight: 500;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <a href="{{ route('admin.dashboard') }}" class="btn-dashboard-secondary" style="flex: 1; justify-content: center; text-align: center;">
                        Cancel
                    </a>
                    <button type="submit" class="btn-dashboard" style="flex: 1; justify-content: center; text-align: center;">
                        Create Client
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
