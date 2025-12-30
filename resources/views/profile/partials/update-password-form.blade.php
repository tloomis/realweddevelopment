<section>
    <p style="font-size: 0.9375rem; color: #64748b; margin-bottom: 1.5rem;">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </p>

    <form method="post" action="{{ route('password.update') }}" style="display: grid; gap: 1.25rem;">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s ease;" onfocus="this.style.borderColor='#0891b2'; this.style.boxShadow='0 0 0 3px rgba(8, 145, 178, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" />
            @if($errors->updatePassword->get('current_password'))
                <p style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; font-weight: 500;">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">New Password</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password" style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s ease;" onfocus="this.style.borderColor='#0891b2'; this.style.boxShadow='0 0 0 3px rgba(8, 145, 178, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" />
            @if($errors->updatePassword->get('password'))
                <p style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; font-weight: 500;">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s ease;" onfocus="this.style.borderColor='#0891b2'; this.style.boxShadow='0 0 0 3px rgba(8, 145, 178, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" />
            @if($errors->updatePassword->get('password_confirmation'))
                <p style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; font-weight: 500;">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <button type="submit" class="btn-dashboard">Save Changes</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" style="font-size: 0.875rem; color: #10b981; font-weight: 600;">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
