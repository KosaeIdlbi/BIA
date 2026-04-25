<div>
    <!-- suggestions -->
    <div class="section-header">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <h2 class="section-title">❤️ مقترحة لك</h2>

            <!-- زر تحديث المنتجات -->
            <button class="refresh-btn" wire:click.prevent='refreshSuggestions' title="تحديث المنتجات">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    @if ($suggestions->count() > 0)
        <div class="products-grid">
            @foreach ($suggestions as $product)
                @livewire('product', ['user_id' => $user ? $user->id : null, 'product' => $product], key($product->id))
            @endforeach
        </div>
        {{-- <div class="view-more-wrapper">
            <a href="{{ route('products') }}" class="view-more-btn">
                <span class="btn-text">عرض المزيد</span>
                <i class="fas fa-arrow-left"></i>
            </a>
        </div> --}}
    @else
        <div class="empty-message">
            <i class="fas fa-box-open fa-2x"></i>
            <p>لا توجد منتجات متاحة حالياً</p>
        </div>
    @endif
</div>
