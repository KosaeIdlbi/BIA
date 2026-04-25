<div>
    <div class="product-detail-container">
        <!-- تنبيه تم الشراء - يظهر في أعلى الصفحة -->
        @if (session('purchased'))
            <div class="purchase-alert" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>✓ تم شراء المنتج بنجاح</span>
                    <button class="alert-close" @click="show = false">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- نافذة تسجيل الدخول -->
        @if (session('login_alert'))
            <div class="modal-overlay">
                <div class="login-modal">
                    <a href="{{ route('product-details', ['id' => $product->id]) }}" class="close-modal">
                        <i class="fas fa-times"></i>
                    </a>
                    <div class="modal-icon">
                        <i class="fas fa-user-lock"></i>
                    </div>
                    <h2 class="modal-title">مرحباً بك!</h2>
                    <p class="modal-description">
                        يرجى تسجيل الدخول للمتابعة والاستفادة من جميع خدمات المتجر
                    </p>
                    <a href="{{ route('login.create') }}" class="login-btn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>تسجيل الدخول</span>
                    </a>
                    <div class="register-link">
                        <a href="{{ route('register.create') }}">
                            <i class="fas fa-user-plus"></i>
                            ليس لديك حساب؟ سجل الآن
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Product Detail Card -->
        <div class="product-detail-card">
            <!-- Image Section -->
            <div class="product-image-section">
                <div class="product-main-image">
                    @if ($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->name }}">
                    @else
                        <i class="fas fa-box-open"></i>
                    @endif
                </div>
            </div>

            <!-- Info Section -->
            <div class="product-info-section">
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-category">
                    <i class="fas fa-tag"></i>
                    <span>{{ $product->category }}</span>
                </div>
                <div class="product-price-large">
                    {{ number_format($product->price) }} <span class="price-currency">ل.س</span>
                </div>

                <!-- Rating Section -->
                <div class="rating-section">
                    <div class="rating-label">
                        <i class="fas fa-star" style="color: #fbbf24;"></i>
                        <span>تقييم المنتج</span>
                    </div>
                    <div class="rating-stars-large">
                        @for ($i = 1; $i <= 5; $i++)
                            @php
                                $ratingValue = $rating ?? 0;
                                $starClass = $i <= round($ratingValue) ? 'active' : '';
                            @endphp
                            <i wire:click.prevent="rate({{ $i }})"
                                class="fas fa-star star-large {{ $starClass }}"></i>
                        @endfor
                    </div>
                    @if (($rating ?? 0) > 0)
                        <button class="delete-rating-btn-large" wire:click.prevent="deleteRating">
                            <i class="fas fa-trash-alt"></i> حذف تقييمي
                        </button>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    @if ($incart)
                        <button class="buy-btn-large remove-from-cart-large" wire:click.prevent="removeFromCart">
                            <i class="fas fa-trash-alt"></i>
                            <span class="btn-text">إزالة من السلة</span>
                            <span class="loading-spinner" wire:loading wire:target="removeFromCart">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    @else
                        <button class="buy-btn-large add-to-cart-large" wire:click.prevent="addToCart">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="btn-text">إضافة إلى السلة</span>
                            <span class="loading-spinner" wire:loading wire:target="addToCart">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    @endif
                    <button class="buy-btn-large buy-now-btn" wire:click.prevent="purchased"
                        wire:loading.attr='disabled'>
                        <i class="fas fa-bolt"></i>
                        شراء الآن
                        <span class="loading-spinner" wire:loading wire:target="purchased">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
