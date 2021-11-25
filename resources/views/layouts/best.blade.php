<div class="main-aside bb-2">
    <aside class="favorit">
        <h2 class="red">Лучшие товары</h2>
        <div class="favorit-list">
            @foreach($products as $product)
                <a href="{{ route('product', ['slug' => $product->slug]) }}" class="favorit-item">
                    <div class="favorit-item__up">
                        <div class="favorit-item__img">
                            <img src="{{ $product->getImage() }}" alt="{{ $product->title }}">
                        </div>
                        <div class="favorit-item__text">
                            <p>@if(mb_strlen($product->title) < 26){{ $product->title }}@else{{ mb_substr($product->title, 0, 26) . "..." }} @endif</p>
                        </div>
                    </div>
                    <div class="favorit-item__down">
                        <div class="favorit-item__price"><span class="favorit-item__price-span">{{ $product->price }} </span><span>₽</span></div>
                        <div class="favorit-item__btn"><span class="best-addCart" id="addCart" data-href="{{ route('cart.add', ['id' => $product->id]) }}">В корзину</span></div>
                    </div>
                </a>
            @endforeach
        </div>
    </aside>
</div>
