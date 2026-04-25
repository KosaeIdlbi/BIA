<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} | @yield('title')</title> <!-- Google Fonts + Font Awesome -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            background: linear-gradient(135deg, #0a0f1e 0%, #0c1222 100%);
            color: #eef2ff;
            min-height: 100vh;
        }

        /* ========== NAVBAR STYLES ========== */
        .navbar {
            background: rgba(10, 20, 35, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(59, 130, 246, 0.2);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            font-size: 1.8rem;
            color: #3b82f6;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(120deg, #fff, #90b4ff);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .user-greeting {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(59, 130, 246, 0.15);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .user-name {
            font-weight: 600;
            color: #e2e8ff;
        }

        .user-greeting-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(59, 130, 246, 0.15);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            border: 1px solid rgba(59, 130, 246, 0.3);
            text-decoration: none;
            color: inherit;
            transition: all 0.2s ease;
            cursor: pointer;
            font-family: inherit;
            font-size: inherit;
            width: auto;
        }

        .user-greeting-btn:hover {
            background: rgba(59, 130, 246, 0.25);
            transform: translateY(-1px);
            border-color: rgba(59, 130, 246, 0.5);
        }

        .user-greeting-btn:active {
            transform: translateY(0px);
        }

        /* Cart Icon as Link */
        .cart-icon {
            position: relative;
            cursor: pointer;
            transition: transform 0.2s;
            background: rgba(59, 130, 246, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: inherit;
        }

        .cart-icon:hover {
            transform: scale(1.02);
            background: rgba(59, 130, 246, 0.2);
        }

        .cart-icon i {
            font-size: 1.2rem;
            color: #fbbf24;
        }

        .cart-text {
            font-weight: 500;
            font-size: 0.9rem;
            color: #e2e8ff;
        }

        .logout-btn {
            background: linear-gradient(95deg, #dc2626, #b91c1c);
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 2rem;
            color: white;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .auth-links {
            display: flex;
            gap: 1rem;
        }

        .auth-link {
            color: #a5b4fc;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            background: rgba(59, 130, 246, 0.1);
            cursor: pointer;
        }

        .auth-link:hover {
            background: #3b82f6;
            color: white;
        }

        /* تنسيق زر الشعار ليبدو كشعار */
        .logo-btn {
            background: transparent;
            /* خلفية شفافة */
            border: none;
            /* إزالة الحدود */
            padding: 0;
            /* إزالة الحواف الداخلية */
            margin: 0;
            /* إزالة الهوامش الافتراضية للزر */
            display: flex;
            /* لترتيب الأيقونة والنص بجانب بعض */
            align-items: center;
            /* محاذاة عمودية */
            gap: 0.75rem;
            /* مسافة بين الأيقونة والنص */
            cursor: pointer;
            /* مؤشر اليد عند التحويم */
            font-family: inherit;
            /* استخدام نفس خط الصفحة */
            text-decoration: none;
            /* بدون خط أسفل النص */
            transition: all 0.3s ease;
            /* تأثير حركي ناعم */
        }

        /* تأثير عند التحويم (Hover) */
        .logo-btn:hover .logo-icon {
            color: #60a5fa;
            /* تغيير لون الأيقونة للأزرق الفاتح */
            transform: rotate(-10deg) scale(1.1);
            /* حركة بسيطة للأيقونة */
        }

        .logo-btn:hover .logo-text {
            /* تغيير لون النص عند التحويم */
            color: #ffffff;
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }

        /* التركيز (Focus) - للوصولية ولإزالة الإطار الأزرق المزعج في بعض المتصفحات */
        .logo-btn:focus {
            outline: none;
        }

        /* تنسيق الأيقونة والنص بداخل الزر */
        .logo-btn .logo-icon {
            font-size: 1.8rem;
            /* نفس الحجم الأصلي */
            color: #3b82f6;
            /* اللون الأزرق الأصلي */
            transition: all 0.3s ease;
        }

        .logo-btn .logo-text {
            font-size: 1.5rem;
            /* نفس الحجم الأصلي */
            font-weight: 800;
            /* التدرج اللوني الأصلي */
            background: linear-gradient(120deg, #fff, #90b4ff);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }
    </style>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo-area">
                <button class="logo-btn" onclick="window.location.href='{{ route('home') }}'">
                    <i class="fas fa-store logo-icon"></i>
                    <span class="logo-text">متجر</span>
                </button>
            </div>
            <div class="user-area">
                @if ($user)
                    <button onclick="window.location.href='{{ route('activity_log') }}'" class="user-greeting-btn">
                        <i class="fas fa-user-circle"></i>
                        <span class="user-name">{{ $user->name }}</span>
                    </button>
                    <a href="{{ route('cart') }}" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-text">سلة المشتريات</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> تسجيل خروج
                        </button>
                    </form>
                @else
                    <div class="auth-links">
                        <a href="{{ route('login.create') }}" class="auth-link">
                            <i class="fas fa-sign-in-alt"></i> تسجيل دخول
                        </a>
                        <a href="{{ route('register.create') }}" class="auth-link">
                            <i class="fas fa-user-plus"></i> إنشاء حساب
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </nav>
