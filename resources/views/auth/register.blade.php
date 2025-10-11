<x-guest-layout>
    <style>
        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            max-width: 520px;
            margin: 0 auto;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-title {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 12px;
            text-align: center;
        }

        .register-subtitle {
            font-size: 16px;
            color: #6b7280;
            text-align: center;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
        }

        .actions-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 32px;
        }

        .btn-primary {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .login-link-container {
            text-align: center;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
        }

        .link {
            font-size: 14px;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .link:hover {
            color: #2563eb;
            text-decoration: underline;
        }

        .password-strength {
            margin-top: 8px;
            font-size: 12px;
            color: #6b7280;
        }

        @media (max-width: 640px) {
            .register-container {
                padding: 32px 24px;
            }

            .register-title {
                font-size: 28px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .register-container {
                background: rgba(31, 41, 55, 0.95);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .register-title {
                color: #f9fafb;
            }

            .register-subtitle {
                color: #d1d5db;
            }

            .form-label {
                color: #e5e7eb;
            }

            .form-input {
                background: #374151;
                border-color: #4b5563;
                color: #f9fafb;
            }

            .form-input:focus {
                background: #1f2937;
                border-color: #60a5fa;
            }

            .login-link-container {
                border-top-color: #374151;
            }

            .password-strength {
                color: #d1d5db;
            }
        }
    </style>

    <div class="register-container">
        <h2 class="register-title">Create Account</h2>
        <p class="register-subtitle">Join us today and start your journey</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name and Nickname Row -->
            <div class="form-row">
                <div class="form-group">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input 
                        id="name" 
                        class="form-input" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus 
                        autocomplete="name"
                        placeholder="John"
                    />
                    @if ($errors->get('name'))
                        <div class="error-message">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="nickname" class="form-label">{{ __('Nickname') }}</label>
                    <input 
                        id="nickname" 
                        class="form-input" 
                        type="text" 
                        name="nickname" 
                        value="{{ old('nickname') }}" 
                        required 
                        autocomplete="nickname"
                        placeholder="johnny"
                    />
                    @if ($errors->get('nickname'))
                        <div class="error-message">
                            {{ $errors->first('nickname') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input 
                    id="email" 
                    class="form-input" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autocomplete="username"
                    placeholder="john@example.com"
                />
                @if ($errors->get('email'))
                    <div class="error-message">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input 
                    id="password" 
                    class="form-input"
                    type="password"
                    name="password"
                    required 
                    autocomplete="new-password"
                    placeholder="Enter your password"
                />
                <div class="password-strength">
                    Use at least 8 characters with a mix of letters and numbers
                </div>
                @if ($errors->get('password'))
                    <div class="error-message">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input 
                    id="password_confirmation" 
                    class="form-input"
                    type="password"
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    placeholder="Re-enter your password"
                />
                @if ($errors->get('password_confirmation'))
                    <div class="error-message">
                        {{ $errors->first('password_confirmation') }}
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="actions-container">
                <button type="submit" class="btn-primary">
                    {{ __('Register') }}
                </button>

                <!-- Login Link -->
                <div class="login-link-container">
                    <a class="link" href="{{ route('login') }}">
                        {{ __('Already registered?') }} <strong>Sign in</strong>
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>