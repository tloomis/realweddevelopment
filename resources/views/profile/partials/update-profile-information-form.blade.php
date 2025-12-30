<section>
    <p style="font-size: 0.9375rem; color: #64748b; margin-bottom: 1.5rem;">
        {{ __("Update your account's profile information and email address.") }}
    </p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="display: grid; gap: 1.25rem;">
        @csrf
        @method('patch')

        <div>
            <label for="name" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s ease;" onfocus="this.style.borderColor='#0891b2'; this.style.boxShadow='0 0 0 3px rgba(8, 145, 178, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" />
            @error('name')
                <p style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; font-weight: 500;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s ease;" onfocus="this.style.borderColor='#0891b2'; this.style.boxShadow='0 0 0 3px rgba(8, 145, 178, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" />
            @error('email')
                <p style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; font-weight: 500;">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 0.75rem; padding: 0.875rem; background: #fef3c7; border: 1px solid #fde047; border-radius: 0.5rem;">
                    <p style="font-size: 0.875rem; color: #92400e;">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" type="submit" style="color: #0891b2; font-weight: 600; text-decoration: underline; background: none; border: none; cursor: pointer;">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top: 0.5rem; font-weight: 500; font-size: 0.875rem; color: #065f46;">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <button type="submit" class="btn-dashboard">Save Changes</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" style="font-size: 0.875rem; color: #10b981; font-weight: 600;">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
