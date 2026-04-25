<link rel="stylesheet" href="{{ url('css/home.css') }}">
@extends('user.layouts.master')
@section('title')
    الرئيسية
@endsection

@section('content')
    @livewire('view-products', ['user' => $user])
    <style>
        /* ================= APP MECHANISM SECTION ================= */
        .app-mechanism-section {
            max-width: 1200px;
            margin: 4rem auto;
            padding: 0 1.5rem;
        }

        /* العنوان */
        .section-header-centered {
            text-align: center;
            margin-bottom: 3rem;
        }

        .mechanism-title {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(120deg, #ffffff, #60a5fa);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
        }

        .mechanism-subtitle {
            color: #94a3b8;
            font-size: 1.1rem;
        }

        /* شبكة البطاقات */
        .mechanism-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .mechanism-card {
            background: rgba(18, 28, 45, 0.6);
            border: 1px solid rgba(59, 130, 246, 0.15);
            border-radius: 1.2rem;
            padding: 1.8rem 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .mechanism-card:hover {
            transform: translateY(-5px);
            background: rgba(25, 38, 60, 0.8);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.2rem;
        }

        /* ألوان الأيقونات حسب النوع */
        .viewed-icon {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
        }

        .clicked-icon {
            background: rgba(139, 92, 246, 0.15);
            color: #8b5cf6;
        }

        .purchased-icon {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
        }

        .rating-icon {
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
        }

        .mechanism-card h3 {
            color: #fff;
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
            font-weight: 700;
        }

        .mechanism-card p {
            color: #cbd5e1;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* شريط الفائدة السفلي */
        .benefit-banner {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1));
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 1.2rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.2rem;
            backdrop-filter: blur(5px);
        }

        .benefit-banner i {
            font-size: 2rem;
            color: #60a5fa;
            flex-shrink: 0;
        }

        .benefit-banner p {
            color: #e2e8ff;
            font-size: 1rem;
            line-height: 1.7;
            margin: 0;
        }

        .benefit-banner strong {
            color: #fff;
            font-weight: 700;
            text-decoration: underline;
            text-decoration-color: #3b82f6;
            text-decoration-thickness: 2px;
        }

        /* التجاوب */
        @media (max-width: 768px) {
            .mechanism-title {
                font-size: 1.5rem;
                flex-direction: column;
            }

            .benefit-banner {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
        }

        /* استبدل أو أضف هذا الكلاس */
        .incart-icon {
            background: rgba(139, 92, 246, 0.15);
            color: #8b5cf6;
        }
    </style>
    <!-- قسم شرح آلية العمل والاقتراحات -->
    <section class="app-mechanism-section">
        <div class="section-header-centered">
            <h2 class="mechanism-title">
                <i class="fas fa-brain"></i> كيف يعمل الذكاء الاصطناعي لدينا؟
            </h2>
            <p class="mechanism-subtitle">نقوم بتحليل سلوكك لتقديم أفضل المنتجات التي تناسب اهتماماتك</p>
        </div>

        <div class="mechanism-grid">
            <!-- البطاقة الأولى: التصفح -->
            <div class="mechanism-card">
                <div class="card-icon viewed-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>المشاهدة (Viewed)</h3>
                <p>عند فتح تفاصيل المنتج، يتم تسجيل المنتج كمنتجات "تمت مشاهدتها"، مما يساعدنا على
                    معرفة اهتماماتك</p>
            </div>

            <!-- البطاقة الثانية: التفاعل -->
            <div class="mechanism-card">
                <div class="card-icon incart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3>الإضافة للسلة (InCart)</h3>
                <p>عند الضغط على زر "إضافة للسلة"، يسجل النظام أنك قمت بالتفاعل مع المنتج ويتم اعتباره جزءاً من
                    سلة مشترياتك الحالية.</p>
            </div>

            <!-- البطاقة الثالثة: الشراء -->
            <div class="mechanism-card">
                <div class="card-icon purchased-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h3>إتمام الشراء (Purchased)</h3>
                <p>عند إتمام عملية الشراء، يتم اعتبار المنتج "تم شراؤه"، هذه الخطوة هي الأهم لفهم ذوقك
                    الحقيقي.</p>
            </div>

            <!-- البطاقة الرابعة: التقييم -->
            <div class="mechanism-card">
                <div class="card-icon rating-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3>التقييم (Rating)</h3>
                <p>عند قيامك بتقييم أي منتج، يتم حفظ تقييمك كبيانات دقيقة تساعدنا في تحسين جودة المنتجات المقترحة لك.</p>
            </div>
        </div>

        <!-- ملخص الفائدة -->
        <div class="benefit-banner">
            <i class="fas fa-chart-pie"></i>
            <p>
                يتم تجميع كل هذه البيانات (المشاهدات، النقرات، المشتريات، والتقييمات) وتحليلها في
                <strong>سجل النشاط</strong> الخاص بحسابك، وذلك لغرض وحيد هو <strong>تحسين اقتراحات المنتجات</strong>
                وعرضها لك بشكل ذكي مع كل تحديث للصفحة.
            </p>
        </div>
    </section>
@endsection
