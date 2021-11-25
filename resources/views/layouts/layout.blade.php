<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    @stack('style')
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset("uploads/data/$favicon->image") }}" type="image/x-icon">
</head>

<body>
<header>
    <div class="h-grid">
        <div class="header-up">
            <div class="header-wrapper">
                <div class="header-burger">
						<span id="burger-menu">
							<img src="{{ asset('assets/front/img/menu.png') }}" alt="Burger">
						</span>
                </div>
                <div class="header-logo">
                    <a href="/">
                        <img src="{{ $logo->getImage() }}" alt="Logotip">
                    </a>
                </div>
                <div class="header-search">
                    <form action="{{ route('search') }}">
                        <input type="search" name="s" id="search" placeholder="Искать товар" required>
                        <button><img src="{{ asset('assets/front/img/search.svg') }}" alt="Search"></button>
                    </form>
                </div>
                <div class="header-cart">
                    <a href="{{ route('cart') }}">
                        <img src="{{ asset('assets/front/img/cart.svg') }}" alt="Cart">
                        <span class="cart-qnt">@if(session()->has('cart')){{ count(session()->get('cart')) }} @else 0 @endif</span>
                        <span class="cart-price">Корзина</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="header-down">
            <div class="header-menu">
                <nav>
                    <ul>
                        <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Каталог</a></li>
                        <li><a href="{{ route('about') }}" class="{{ request()->is('about*') ? 'active' : '' }}">О нас</a></li>
                        {{--<li><a href="{{ route('category') }}" class="{{ request()->is('category*') ? 'active' : '' }}">Каталог</a></li>--}}
                        <li><a href="{{ route('contact') }}" class="{{ request()->is('contact*') ? 'active' : '' }}">Контакты</a></li>
                        <li><a href="{{ route('payment') }}" class="{{ request()->is('payment*') ? 'active' : '' }}">Оплата и доставка</a></li>
                    </ul>
                </nav>
                <div class="header-menu__close">
						<span id="menu-close">
							<img src="{{ asset('assets/front/img/close.png') }}" alt="Close">
						</span>
                </div>
            </div>
        </div>
    </div>
</header>
<section id="main">
    <div class="m-grid">
        @yield('best')
        @yield('content')
        <div class="main-aside">
            <aside class="favorit">
                <h2>Новинки</h2>
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
    </div>
</section>
<footer>
    <div class="h-grid">
        <div class="footer">
            <div class="footer-block">
                <p>{!! $footer->content !!}</p>
            </div>
        </div>
    </div>
</footer>
<div class="add-block">
    <h3>Успешно добавлено</h3>
</div>
<div class="overlay"></div>
<script src="{{ asset('assets/front/js/scripts.js') }}"></script>
<script>
    function cartCount() {
        $.ajax({
            url: '{{ route('cart.count') }}',
            success: function(data) {
                $('.cart-qnt').html(data);
            }
        });
        return false;
    }
</script>
{{--Разряды цены--}}
<script>
    jQuery(document).ready(function () {
        function triplets(str) {
            return str.toString().replace(/(\d)(?=(\d{3})+([^\d]|$))/g, "$1 ");
        }

        $('.favorit-item__price-span').each(function () {
            var newBest = triplets($(this).text());
            $(this).html(newBest)
        })
    })
</script>
@stack('scripts')
</body>

</html>
