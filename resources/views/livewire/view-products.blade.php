<div>
    <main class="main-container">
        @if (session('login_alert'))
            <div class="modal-overlay">
                <div class="login-modal">
                    <!-- زر إغلاق النافذة -->
                    <a href={{ route('home') }} class="close-modal">
                        <i class="fas fa-times"></i>
                    </a>

                    <!-- أيقونة النافذة -->
                    <div class="modal-icon">
                        <i class="fas fa-user-lock"></i>
                    </div>

                    <!-- عنوان النافذة -->
                    <h2 class="modal-title">مرحباً بك!</h2>

                    <!-- النص التعريفي -->
                    <p class="modal-description">
                        يرجى تسجيل الدخول للمتابعة والاستفادة من جميع خدمات المتجر
                    </p>


                    <a href={{ route('login.create') }} class="login-btn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>تسجيل الدخول</span>
                    </a>

                    <!-- رابط التسجيل (يقوم بتوجيه المستخدم لصفحة التسجيل) -->
                    <div class="register-link">
                        <a href={{ route('register.create') }}>
                            <i class="fas fa-user-plus"></i>
                            ليس لديك حساب؟ سجل الآن
                        </a>
                    </div>
                </div>
            </div>
        @endif
        <!-- ALL PRODUCTS SECTION -->
        <div class="section-header">
            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <h2 class="section-title">✨ كل المنتجات</h2>

                <!-- زر تحديث المنتجات -->
                <button class="refresh-btn" wire:click.prevent='refreshProducts' title="تحديث المنتجات">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>

            <span class="products-count">{{ $count }} منتج</span>
        </div>

        @if ($count > 0)
            <div class="products-grid">
                @foreach ($products as $product)
                    @livewire('product', ['user_id' => $user ? $user->id : null, 'product' => $product], key($product->id))
                @endforeach
            </div>
        @else
            <div class="empty-message">
                <i class="fas fa-box-open fa-2x"></i>
                <p>لا توجد منتجات متاحة حالياً</p>
            </div>
        @endif
        @livewire('suggestions', ['user' => $user])
    </main>
</div>
