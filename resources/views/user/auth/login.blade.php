@extends('user.auth.partial.master')
@section('title')
    تسجيل الدخول
@endsection

@section('content')
    <link rel="stylesheet" href={{ asset('css/login.css') }}>
    <div class="login-container">
        <div class="form-header">
            <h1>مرحباً بعودتك</h1>
            <p>سجّل الدخول إلى لوحة التحكم الآمنة</p>
        </div>

        <!-- Session fail message (invalid credentials) -->
        @if (session('fail'))
            <div class="redirect-message red">
                <i class="fas fa-exclamation-triangle"></i>
                <span>{{ session('fail') ?: 'البريد الإلكتروني أو كلمة المرور غير صحيحة' }}</span>
            </div>
        @endif

        <!-- Password updated success message (if passed from elsewhere) -->
        @if (session('password_updated'))
            <div class="redirect-message green">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('password_updated') ?: 'تم تحديث كلمة المرور بنجاح' }}</span>
            </div>
        @endif

        <!-- Laravel login form -->
        <form action="{{ route('login.store') }}" method="POST" id="loginForm">
            @csrf

            <!-- Email field -->
            <div class="input-group">
                <div class="input-label">
                    <i class="fas fa-envelope"></i>
                    <span>البريد الإلكتروني</span>
                </div>
                <input class="input-field" type="email" name="email" value="{{ old('email') }}"
                    placeholder="example@company.com" autocomplete="email">
                @error('email')
                    <div class="redirect-message red" style="margin-top: 0.6rem; margin-bottom: 0; padding: 0.5rem 0.8rem;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password field -->
            <div class="input-group">
                <div class="input-label">
                    <i class="fas fa-lock"></i>
                    <span>كلمة المرور</span>
                </div>
                <input class="input-field" type="password" name="password" placeholder="··········"
                    autocomplete="current-password">
                @error('password')
                    <div class="redirect-message red" style="margin-top: 0.6rem; margin-bottom: 0; padding: 0.5rem 0.8rem;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Remember me & additional actions -->
            <div class="remember-row">
                <label class="checkbox-wrapper">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>تذكرني</span>
                </label>
            </div>

            <!-- Submit button -->
            <button type="submit" class="submit-btn">
                <i class="fas fa-arrow-right-to-bracket"></i> تسجيل الدخول
            </button>
        </form>

        <!-- روابط أسفل النافذة -->
        <div class="auth-footer-links">
            <a href="{{ route('register.create') }}" class="footer-link">
                <i class="fas fa-user-plus"></i> ليس لديك حساب؟ إنشاء حساب جديد
            </a>
            <span class="divider">•</span>
            <a href="{{ route('home') }}" class="footer-link">
                <i class="fas fa-home"></i> الرئيسية
            </a>
        </div>
    </div>
    <script src={{ asset('js/login.js') }}></script>
@endsection
