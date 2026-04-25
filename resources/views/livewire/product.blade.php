<div class="product-card">
    <div class="product-img">
        @if ($product->image)
            <img src="{{ $product->image }}" alt="{{ $product->name }}">
        @else
            <i class="fas fa-box-open"></i>
        @endif
    </div>
    <div class="product-name">
        <a href="{{ route('product-details', ['id' => $product->id]) }}" style="text-decoration: none; color: inherit;">
            {{ $product->name }}
        </a>
    </div>
    <div class="product-category">
        <h3> <i class="fas fa-tag"></i> {{ $product->category }}</h3>
    </div>
    <div class="product-price">
        {{ number_format($product->price) }} <span class="price-currency">ل.س</span>
    </div>

    <!-- Rating Stars - Pure CSS/Livewire without JavaScript interference -->
    <div class="rating-stars-wrapper">
        <div class="rating-stars" data-product-id="{{ $product->id }}">
            @for ($i = 1; $i <= 5; $i++)
                @php
                    $ratingValue = $rating;
                    $starClass = $i <= $ratingValue ? 'active' : '';
                @endphp
                <i wire:click.prevent="rate({{ $i }})" class="fas fa-star star {{ $starClass }}"
                    data-value="{{ $i }}"></i>
            @endfor
        </div>

        <!-- Delete Rating Button - Only appears when there is a rating -->
        @if ($rating > 0)
            <button class="delete-rating-btn" wire:click.prevent="deleteRating" wire:loading.attr="disabled"
                wire:target="deleteRating" title="حذف التقييم">
                <i class="fas fa-trash-alt"></i>
                <span class="btn-text">حذف التقييم</span>
                <span class="loading-spinner" wire:loading wire:target="deleteRating">
                    <i class="fas fa-spinner fa-spin"></i>
                </span>
            </button>
        @endif
    </div>

    @if ($incart)
        <button class="buy-btn remove-from-cart-btn" wire:click.prevent="removeFromCart" wire:loading.attr="disabled"
            wire:target="removeFromCart">
            <i class="fas fa-trash-alt"></i>
            <span class="btn-text">إزالة من السلة</span>
            <span class="loading-spinner" wire:loading wire:target="removeFromCart">
                <i class="fas fa-spinner fa-spin"></i>
            </span>
        </button>
    @else
        <button class="buy-btn add-to-cart-btn" wire:click.prevent="addToCart" wire:loading.attr="disabled"
            wire:target="addToCart">
            <i class="fas fa-shopping-bag"></i>
            <span class="btn-text">إضافة للسلة</span>
            <span class="loading-spinner" wire:loading wire:target="addToCart">
                <i class="fas fa-spinner fa-spin"></i>
            </span>
        </button>
    @endif
</div>
