<x-app-layout>
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1 class="dashboard-title">Profile Settings</h1>
        <p class="dashboard-subtitle">Manage your account information and security settings</p>
    </div>

    <div style="display: grid; gap: 1.5rem; max-width: 800px;">
        <!-- Profile Information Card -->
        <div class="content-card">
            <div class="content-card-header">
                <h2 class="content-card-title">Profile Information</h2>
            </div>
            <div class="content-card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password Card -->
        <div class="content-card">
            <div class="content-card-header">
                <h2 class="content-card-title">Update Password</h2>
            </div>
            <div class="content-card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account Card -->
        <div class="content-card">
            <div class="content-card-header">
                <h2 class="content-card-title">Delete Account</h2>
            </div>
            <div class="content-card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
