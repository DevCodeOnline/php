<div class="product-list">
    @foreach($products as $product)
        <a href="{{ route('product', ['slug' => $product->slug]) }}" class="product-item @if($layout == 'list') product-grid @endif">
            <div class="product-item__img">
                <img src="{{ $product->getImage() }}" alt="{{ $product->title }}">
            </div>
            <div class="product-item__text">
                <div class="product-item__title">
                    <span>{{ $product->title }}</span>
                </div>
                <div class="product-item__price">
                    <span class="product-item__price-span">{{ $product->price }} </span>
                    <span>₽</span>
                </div>
            </div>
        </a>
    @endforeach
</div>
{{ $products->appends(['layout' => $layout, 'show' => request()->show, 'sort' => request()->sort])->links('vendor.pagination.pagination-categories') }}
