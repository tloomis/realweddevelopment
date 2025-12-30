<x-guest-layout>
    <h2 class="auth-title">Reset Password</h2>
    <p class="auth-subtitle">Enter your email and we'll send you a reset link</p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="status-message">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary">
            Send Reset Link
        </button>

        <div class="auth-footer">
            Remember your password? <a href="{{ route('login') }}">Back to login</a>
        </div>
    </form>
</x-guest-layout>
