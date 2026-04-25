<link rel="stylesheet" href="{{ url('css/activity-log.css') }}">

@extends('user.layouts.master')
@section('title')
    سجل النشاط
@endsection

@section('content')
    <br>
    <div class="user-profile-header">
        <div class="profile-card">
            <div class="profile-details">
                <div class="name-image-container">
                    <div class="avatar-placeholder">
                        <i class="fas fa-user-astronaut"></i>
                    </div>

                    <div>
                        <h3 class="profile-name">{{ $user->name }}</h3>
                    </div>
                </div>

                <div class="profile-meta">
                    <span class="meta-item">
                        <i class="fas fa-envelope"></i> {{ $user->email }}
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-birthday-cake"></i> {{ $user->age }} سنة
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-globe-americas"></i> {{ $user->country }}
                    </span>
                </div>

                {{-- عرض القسمين بشكل أفقي على نفس المستوى --}}
                <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 15px;">

                    {{-- القسم الأول: شرح طريقة حساب النقاط --}}
                    <div class="calculation-explanation"
                        style="flex: 1; min-width: 250px;
                               background: rgba(59, 130, 246, 0.08); 
                               padding: 12px 15px; 
                               border-radius: 1rem; 
                               border: 1px solid rgba(59, 130, 246, 0.15);">
                        <h5
                            style="color: #a5b4fc; font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-calculator"></i> طريقة حساب النقاط لكل منتج:
                        </h5>
                        <div style="display: flex; flex-wrap: wrap; gap: 12px; font-size: 12px; color: #94a3b8;">
                            <span><i class="fas fa-eye" style="color: #3b82f6;"></i> مشاهدة المنتج: <strong
                                    style="color: #fff;">1 نقطة</strong></span>
                            <span><i class="fas fa-star" style="color: #fbbf24;"></i> كل نجمة تقييم: <strong
                                    style="color: #fff;">1 نقطة</strong></span>
                            <span><i class="fas fa-shopping-cart" style="color: #3b82f6;"></i> إضافة للسلة: <strong
                                    style="color: #fff;">3 نقاط</strong></span>
                            <span><i class="fas fa-check-circle" style="color: #34d399;"></i> عملية شراء: <strong
                                    style="color: #fff;">7 نقاط</strong></span>
                        </div>
                    </div>

                    {{-- القسم الثاني: عرض المصفوفة والنسب المئوية --}}
                    <div class="stats-container" style="flex: 2; min-width: 300px;">
                        <h4 class="stats-title" style="margin-top: 0;">
                            <i class="fas fa-chart-pie"></i>
                            توزيع المنتجات حسب الفئات (النسبة المئوية للنقاط)
                        </h4>

                        {{-- عرض النسب المئوية على شكل أيقونات دائرية --}}
                        <div class="icons-container" style="margin-bottom: 10px;">
                            {{-- Electronics --}}
                            <div class="icon-item">
                                <div class="circle-icon">
                                    <i class="fas fa-microchip"></i>
                                </div>
                                <div class="category-name">Electronics</div>
                                <div class="percentage-value">{{ $user_profile['Electronics'] }}<span
                                        class="percentage-sign">%</span></div>
                            </div>

                            {{-- Cleaning_products --}}
                            <div class="icon-item">
                                <div class="circle-icon">
                                    <i class="fas fa-soap"></i>
                                </div>
                                <div class="category-name">Cleaning_products</div>
                                <div class="percentage-value">{{ $user_profile['Cleaning_products'] }}<span
                                        class="percentage-sign">%</span></div>
                            </div>

                            {{-- Food products --}}
                            <div class="icon-item">
                                <div class="circle-icon">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <div class="category-name">Food</div>
                                <div class="percentage-value">{{ $user_profile['Food'] }}<span
                                        class="percentage-sign">%</span></div>
                            </div>

                            {{-- Clothing --}}
                            <div class="icon-item">
                                <div class="circle-icon">
                                    <i class="fas fa-tshirt"></i>
                                </div>
                                <div class="category-name">Clothing</div>
                                <div class="percentage-value">{{ $user_profile['Clothing'] }}<span
                                        class="percentage-sign">%</span></div>
                            </div>
                        </div>

                        {{-- ملخص طريقة حساب النسبة المئوية --}}
                        <div class="calculation-summary"
                            style="background: rgba(16, 185, 129, 0.08); 
                                   padding: 10px 12px; 
                                   border-radius: 0.8rem; 
                                   margin-top: 10px;
                                   border: 1px solid rgba(16, 185, 129, 0.15);">
                            <p style="font-size: 11px; color: #94a3b8; margin: 0; line-height: 1.5;">
                                <i class="fas fa-chart-line" style="color: #34d399;"></i>
                                <strong style="color: #34d399;">كيف تم حساب النسب؟</strong><br>
                                يتم حساب إجمالي النقاط لكل قسم = ( المشاهدة × 1) + (مجموع التقييمات × 1) + (
                                الإضافة للسلة × 3) + (الشراء × 7).<br>
                                ثم تحسب النسبة المئوية لكل قسم = (نقاط القسم ÷ إجمالي نقاط جميع الأقسام) × 100
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-chart-line"></i>
                <h2>سجل النشاط</h2>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th>القسم</th>
                    <th>مشاهدة</th>
                    <th>في السلة</th>
                    <th>تم الشراء</th>
                    <th>التقييم</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->ActivityLog as $activity)
                    <tr>
                        <td>
                            <div class="product-info-cell">
                                <i class="fas fa-box"></i>
                                <span>
                                    <div class="product-name">
                                        <a href="{{ route('product-details', ['id' => $activity->product->id]) }}"
                                            style="text-decoration: none; color: inherit;">
                                            {{ $activity->product->name }}
                                        </a>
                                    </div>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="product-info-cell">
                                <span>
                                    <div class="product-name">
                                        {{ $activity->product->category }}
                                    </div>
                                </span>
                            </div>
                        </td>
                        <td>
                            @if ($activity->viewed)
                                <span class="status-badge yes"><i class="fas fa-eye"></i> نعم</span>
                            @else
                                <span class="status-badge no"><i class="fas fa-eye-slash"></i> لا</span>
                            @endif
                        </td>
                        <td>
                            @if ($activity->incart)
                                <span class="status-badge yes"><i class="fas fa-shopping-cart"></i> نعم</span>
                            @else
                                <span class="status-badge no"><i class="fas fa-cart-plus"></i> لا</span>
                            @endif
                        </td>
                        <td>
                            @if ($activity->purchased)
                                <span class="status-badge yes"><i class="fas fa-check-circle"></i> نعم</span>
                            @else
                                <span class="status-badge no"><i class="fas fa-times-circle"></i> لا</span>
                            @endif
                        </td>
                        <td>
                            <div class="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($activity->rating))
                                        <i class="fas fa-star active"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                @if ($activity->rating == 0)
                                    <span class="no-rating">لا يوجد</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
@endsection
