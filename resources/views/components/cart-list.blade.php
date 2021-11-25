@if(session()->has('cart'))
@foreach($products as $product)
    <div class="cart-product">
        <div class="cart-product__img">
            <img src="{{ $product['img'] }}" alt="Product">
        </div>
        <div class="cart-product__text">
            <div class="cart-product__text-title"><a href="{{ route('product', ['slug' => $product['slug']]) }}" class="product-href">{{ $product['title'] }}</a></div>
            <div class="cart-product__text-price"><span class="cart-price">{{ $product['price'] }}</span> ₽</div>
        </div>
        <div class="cart-product__qnt">
            <input type="number" value="{{ $product['qnt'] }}" class="qnt-input">
            <input type="hidden" value="{{ $product['id'] }}" class="id-input">
        </div>
        <div class="cart-product__remove">
            <a href="{{ route('cart.destroy', ['id' => $product['id']]) }}" class="cart-remove">Удалить</a>
        </div>
    </div>
@endforeach
@endif
