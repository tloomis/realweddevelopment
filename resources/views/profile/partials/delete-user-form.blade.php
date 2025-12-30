<section>
    <style>
        .delete-modal-overlay {
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

        .delete-modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .delete-modal-content {
            background: white;
            border-radius: 1rem;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
        }

        .delete-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .delete-modal-body {
            padding: 1.5rem;
        }

        .delete-modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
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

    <p style="font-size: 0.9375rem; color: #64748b; margin-bottom: 1.5rem;">
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </p>

    <button onclick="document.getElementById('deleteAccountModal').classList.add('active')" type="button" style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); color: white; border: none; padding: 0.875rem 1.75rem; border-radius: 0.75rem; font-size: 0.9375rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(220, 38, 38, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(220, 38, 38, 0.3)';">
        Delete Account
    </button>

    <!-- Delete Account Modal -->
    <div id="deleteAccountModal" class="delete-modal-overlay" onclick="if(event.target === this) this.classList.remove('active')">
        <div class="delete-modal-content">
            <div class="delete-modal-header">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">
                    {{ __('Are you sure you want to delete your account?') }}
                </h3>
                <p style="font-size: 0.875rem; color: #64748b;">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
            </div>

            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="delete-modal-body">
                    <label for="password" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Password</label>
                    <input id="password" name="password" type="password" placeholder="Enter your password" style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s ease;" onfocus="this.style.borderColor='#dc2626'; this.style.boxShadow='0 0 0 3px rgba(220, 38, 38, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" />
                    @if($errors->userDeletion->get('password'))
                        <p style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; font-weight: 500;">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="delete-modal-footer">
                    <button type="button" onclick="document.getElementById('deleteAccountModal').classList.remove('active')" class="btn-dashboard-secondary">
                        Cancel
                    </button>
                    <button type="submit" style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); color: white; border: none; padding: 0.875rem 1.75rem; border-radius: 0.75rem; font-size: 0.9375rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(220, 38, 38, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(220, 38, 38, 0.3)';">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($errors->userDeletion->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('deleteAccountModal').classList.add('active');
            });
        </script>
    @endif
</section>
