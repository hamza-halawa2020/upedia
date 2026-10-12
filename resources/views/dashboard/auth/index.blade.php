@extends('layout.auth')

@section('content')
    @include('components.alert')

    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="max-w-464-px mx-auto w-100 p-3">
            <div>
                <a href="#" class="auth-logo mb-40 max-w-290-px">
                    @if (config('app.client_name') == 'Alkarim')
                        <img src="{{ asset('assets/images/alkarim-dark.png') }}" alt="">
                    @elseif(config('app.client_name') == 'Upedia')
                        <img src="{{ asset('assets/images/logo.png') }}" alt="">
                    @else
                        <img src="{{ asset('assets/images/tailors.png') }}" alt="site logo" class="light-logo">
                    @endif
                </a>
                <h4 class="mb-12">Sign In to your Account</h4>
                <p class="mb-32 text-secondary-light text-lg">Welcome back! please enter your detail</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="login-form">
                @csrf

                <div class="icon-field mb-16">
                    <span class="icon top-50 translate-middle-y">
                        <i class="ri-mail-line"></i>
                    </span>
                    <input type="text" name="email" class="form-control h-56-px bg-neutral-50 radius-12"
                        placeholder="Email or Username" value="{{ old('email') }}" required>
                </div>

                <div class="position-relative mb-20">
                    <div class="icon-field">
                        <span class="icon top-50 translate-middle-y">
                            <i class="ri-lock-password-line"></i>
                        </span>
                        <input type="password" name="password" class="form-control h-56-px bg-neutral-50 radius-12 pe-50"
                            id="your-password" placeholder="Password" required>

                        <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                            style="cursor: pointer;">
                            <i class="ri-eye-off-line show-icon"></i>
                            <i class="ri-eye-line hide-icon" style="display: none;"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-20">
                    <div class="d-flex justify-content-between gap-2">
                        <div class="form-check style-check d-flex align-items-center">
                            <input class="form-check-input border border-neutral-300" type="checkbox" name="remember"
                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                    </div>
                </div>

                <button type="submit" id="login-button"
                    class="btn btn-outline-primary text-sm btn-sm px-12 py-16 w-100 radius-12"
                    data-default-text="Sign In"
                    data-loading-text="Signing In...">
                    Sign In
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggle = document.querySelector('.toggle-password');
            var passwordField = document.getElementById('your-password');
            var showIcon = document.querySelector('.show-icon');
            var hideIcon = document.querySelector('.hide-icon');

            if (toggle && passwordField && showIcon && hideIcon) {
                toggle.addEventListener('click', function() {
                    var isPassword = passwordField.type === 'password';

                    passwordField.type = isPassword ? 'text' : 'password';
                    showIcon.style.display = isPassword ? 'none' : '';
                    hideIcon.style.display = isPassword ? '' : 'none';
                });
            }

            var loginForm = document.getElementById('login-form');
            var loginButton = document.getElementById('login-button');
            var isSubmitting = false;

            if (loginForm && loginButton) {
                loginForm.addEventListener('submit', function(event) {
                    if (isSubmitting) {
                        event.preventDefault();
                        return;
                    }

                    isSubmitting = true;
                    loginButton.disabled = true;
                    loginButton.setAttribute('aria-busy', 'true');
                    loginButton.textContent = loginButton.dataset.loadingText;
                });

                window.addEventListener('pageshow', function(event) {
                    if (!event.persisted) {
                        return;
                    }

                    isSubmitting = false;
                    loginButton.disabled = false;
                    loginButton.removeAttribute('aria-busy');
                    loginButton.textContent = loginButton.dataset.defaultText;
                });
            }
        });
    </script>
@endpush
