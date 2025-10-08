<x-guest-layout>
    <style>
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            max-width: 480px;
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

        .login-title {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 12px;
            text-align: center;
        }

        .login-subtitle {
            font-size: 16px;
            color: #6b7280;
            text-align: center;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 24px;
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

        .checkbox-container {
            display: flex;
            align-items: center;
            margin: 24px 0;
        }

        .checkbox-input {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            border: 2px solid #d1d5db;
            cursor: pointer;
            accent-color: #3b82f6;
        }

        .checkbox-label {
            margin-left: 8px;
            font-size: 14px;
            color: #6b7280;
            cursor: pointer;
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

        .links-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
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

        .status-message {
            padding: 12px 16px;
            background: #dbeafe;
            color: #1e40af;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            border-left: 4px solid #3b82f6;
        }

        @media (max-width: 640px) {
            .login-container {
                padding: 32px 24px;
            }

            .login-title {
                font-size: 28px;
            }

            .links-container {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .login-container {
                background: #151922;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .login-title {
                color: #f9fafb;
            }

            .login-subtitle {
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

            .checkbox-label {
                color: #d1d5db;
            }

            .links-container {
                border-top-color: #374151;
            }
        }
    </style>

    <div class="login-container">
        <h2 class="login-title">Welcome Back</h2>
        <p class="login-subtitle">Sign in to continue to your account</p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

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
                    autofocus 
                    autocomplete="username"
                    placeholder="Enter your email"
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
                    autocomplete="current-password"
                    placeholder="Enter your password"
                />
                @if ($errors->get('password'))
                    <div class="error-message">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="checkbox-container">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="checkbox-input" 
                    name="remember"
                >
                <label for="remember_me" class="checkbox-label">
                    {{ __('Remember me') }}
                </label>
            </div>

            <!-- Submit Button -->
            <div class="actions-container">
                <button type="submit" class="btn-primary">
                    {{ __('Log in') }}
                </button>

                <!-- Links -->
                <div class="links-container">
                    <a class="link" href="{{ route('register') }}">
                        Don't have an account?
                    </a>
                    
                    @if (Route::has('password.request'))
                        <a class="link" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>