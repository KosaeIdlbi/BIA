@extends('user.auth.partial.master')
@section('title')
    حساب جديد
@endsection

@section('content')
    <link rel="stylesheet" href={{ url('css/register.css') }}>
    <div class="register-container">
        <div class="form-header">
            <h1>إنشاء حساب</h1>
            <p>انضم إلى التجربة — آمن وسلس</p>
        </div>

        <!-- Laravel form with POST method -->
        <form action="{{ route('register.store') }}" method="POST" id="registerForm">
            @csrf

            <!-- Username field -->
            <div class="input-group">
                <div class="input-label">
                    <i class="fas fa-user-astronaut"></i>
                    <span>اسم المستخدم</span>
                </div>
                <input class="input-field" type="text" name="name" value="{{ old('name') }}"
                    placeholder="مثال: أحمد_السلامي" autocomplete="username">
                @if ($errors->has('name'))
                    <div class="input-error">
                        <i class="fas fa-exclamation-circle" style="font-size: 10px;"></i> {{ $errors->first('name') }}
                    </div>
                @endif
                <div class="helper-text"><i class="fas fa-info-circle"></i> المعرف العام لحسابك</div>
            </div>

            <!-- Email field -->
            <div class="input-group">
                <div class="input-label">
                    <i class="fas fa-envelope"></i>
                    <span>البريد الإلكتروني</span>
                </div>
                <input class="input-field" type="email" name="email" value="{{ old('email') }}"
                    placeholder="example@domain.com" autocomplete="email">
                @if ($errors->has('email'))
                    <div class="input-error">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <!-- Password field -->
            <div class="input-group">
                <div class="input-label">
                    <i class="fas fa-lock"></i>
                    <span>كلمة المرور</span>
                </div>
                <input class="input-field" type="password" name="password" placeholder="••••••••"
                    autocomplete="new-password">
                @if ($errors->has('password'))
                    <div class="input-error">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->first('password') }}
                    </div>
                @endif
                <div class="helper-text"><i class="fas fa-shield-alt"></i> 8 أحرف على الأقل، يفضل أن تكون قوية</div>
            </div>

            <!-- Confirm Password field -->
            <div class="input-group">
                <div class="input-label">
                    <i class="fas fa-check-circle"></i>
                    <span>تأكيد كلمة المرور</span>
                </div>
                <input class="input-field" type="password" name="password_confirmation" placeholder="أعد إدخال كلمة المرور"
                    autocomplete="off">
            </div>

            <!-- Country + Age inline row (responsive) -->
            <div class="inline-row">
                <!-- Country Select -->
                <div class="input-group">
                    <div class="input-label">
                        <i class="fas fa-globe-asia"></i>
                        <span>الدولة</span>
                    </div>
                    <select class="input-field" name="country">
                        <option value="syria" selected>🇸🇾 سوريا</option>
                        <option value="dubai">🇦🇪 دبي (الإمارات)</option>
                        <option value="egypt">🇪🇬 مصر</option>
                        <option value="saudi">🇸🇦 السعودية</option>
                        <option value="lebanon">🇱🇧 لبنان</option>
                        <option value="jordan">🇯🇴 الأردن</option>
                        <option value="kuwait">🇰🇼 الكويت</option>
                    </select>
                </div>

                <!-- Age field with min/max -->
                <div class="input-group">
                    <div class="input-label">
                        <i class="fas fa-cake-candles"></i>
                        <span>العمر</span>
                    </div>
                    <input class="input-field" type="number" name="age" min="18" max="90"
                        value="{{ old('age', 18) }}" step="1">
                    @if ($errors->has('age'))
                        <div class="input-error">
                            {{ $errors->first('age') }}
                        </div>
                    @endif
                    <div class="helper-text">يجب أن يكون 18 سنة أو أكثر</div>
                </div>
            </div>

            <!-- Submit button -->
            <button type="submit" class="submit-btn">
                <i class="fas fa-user-plus"></i> تسجيل الآن
            </button>
        </form>

        <!-- روابط التنقل -->
        <div class="auth-footer-links">
            <a href="{{ route('login.create') }}" class="footer-link">
                <i class="fas fa-sign-in-alt"></i> لديك حساب بالفعل؟ تسجيل الدخول
            </a>
            <span class="divider">•</span>
            <a href="{{ route('home') }}" class="footer-link">
                <i class="fas fa-home"></i> الرئيسية
            </a>
        </div>
    </div>
    <script src={{ url('js/register.js') }}></script>
@endsection
