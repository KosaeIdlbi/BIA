<div>
    <div class="cart-container">
        <!-- Cart Header -->
        <div class="cart-header">
            <h1 class="cart-title">
                <i class="fas fa-shopping-cart"></i>
                سلة المشتريات
                <span class="cart-count">({{ $cartItems->count() }} منتج)</span>
            </h1>

            <!-- Action Buttons (Only show if cart not empty) -->
            @if ($cartItems->count() > 0)
                <div class="cart-actions">

                    <button wire:click.prevent='buyAll' type="submit" class="buy-all-btn">
                        <i class="fas fa-credit-card"></i>
                        شراء الكل
                    </button>
                    <button wire:click.prevent='removeAll' type="submit" class="clear-all-btn">
                        <i class="fas fa-trash-alt"></i>
                        إفراغ الكل
                    </button>

                </div>
            @endif
        </div>

        @if (session('purchased'))
            <div class="purchase-alert" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>✓ تم شراء المنتجات بنجاح</span>
                    <button class="alert-close" @click="show = false">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
        <!-- Cart Items -->
        @if ($cartItems->count() > 0)
            <div class="cart-items">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>السعر</th>
                            <th>الإجمالي</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <div class="product-img">

                                            <i class="fas fa-box-open"></i>

                                        </div>
                                        <div class="product-details">
                                            <h4>
                                                <div class="product-name">
                                                    <a href="{{ route('product-details', ['id' => $item->id]) }}"
                                                        style="text-decoration: none; color: inherit;">
                                                        {{ $item->name }}
                                                    </a>
                                                </div>
                                            </h4>
                                            <span class="product-category">{{ $item->category }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="product-price">{{ number_format($item->price) }} ل.س</td>
                                <td>
                                    <button wire:click.prevent='remove({{ $item->id }})' type="submit"
                                        class="remove-item-btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Continue Shopping -->
            <a href="{{ route('home') }}" class="continue-shopping">
                <i class="fas fa-arrow-right"></i>
                متابعة التسوق
            </a>
        @else
            <!-- Empty Cart -->
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <p>سلة المشتريات فارغة</p>
                <a href="{{ route('home') }}" class="continue-shopping">
                    تسوق الآن
                </a>
            </div>
        @endif
    </div>
</div>
