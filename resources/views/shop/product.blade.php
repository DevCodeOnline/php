@extends('layouts.layout')
@section('title', 'Купить ' . $product->title . ' в интернет-магазине')
@section('best')
    <div class="main-aside bb-2">
        <aside class="favorit">
            <h2 class="red">Лучшие товары</h2>
            <div class="favorit-list">
                @foreach($bests as $best)
                    <a href="{{ route('product', ['slug' => $best->slug]) }}" class="favorit-item">
                        <div class="favorit-item__up">
                            <div class="favorit-item__img">
                                <img src="{{ $best->getImage() }}" alt="{{ $best->title }}">
                            </div>
                            <div class="favorit-item__text">
                                <p>{{ $best->title }}</p>
                            </div>
                        </div>
                        <div class="favorit-item__down">
                            <div class="favorit-item__price"><span class="favorit-item__price-span">{{ $best->price }} </span><span>₽</span></div>
                            <div class="favorit-item__btn"><span class="best-addCart" id="addCart" data-href="{{ route('cart.add', ['id' => $best->id]) }}">В корзину</span></div>
                        </div>
                    </a>
                @endforeach
            </div>
        </aside>
    </div>
@endsection
@section('content')
    <div class="main-content">
        <div class="content-header">
            @if ($errors->any())
                <div class="alert alert-danger mt-2 mb-2">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session()->has('success'))
                <div class="alert alert-success mt-2 mb-2">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <div class="product">
            <h1>{{ $product->title }}</h1>
            <span class="product-id" style="display: none">{{ $product->id }}</span>
            <div class="product-images">
                <div class="product-images__main" id="product-image">
                    <img src="{{ $product->getImage() }}" alt="Product">
                </div>
                <div class="product-images__thumbs">
                    <img src="{{ $product->getImage() }}" alt="Product">
                    @foreach($product->images as $image)
                        <img src="{{ asset("uploads/{$image->image}") }}" data-src="img/noytbook.jpg" alt="Product">
                    @endforeach
                </div>
                <span id="slick-prev"><img src="{{ asset("assets/front/img/up.svg") }}" alt="Up"></span>
                <span id="slick-next"><img src="{{ asset("assets/front/img/down.svg") }}" alt="Down"></span>
            </div>
            <div class="product-buttons">
                <span class="price"><span>{{ $product->price }}</span> ₽</span>
                <a class="btn-buy" href="{{ route('cart.add', ['id' => $product->id]) }}">В корзину</a>
            </div>
            <div class="product-tabs">
                <div id="tabs">
                    <ul class="tabs-nav">
                        <li><a href="#tab-1">Описание</a></li>
                        <li><a href="#tab-2">Отзывы</a></li>
                    </ul>
                    <div class="tabs-items">
                        <div class="tabs-item" id="tab-1">
                            <p>{!! $product->description !!}</p>
                        </div>
                        <div class="tabs-item" id="tab-2">
                            <button id="add-review">Написать отзыв</button>
                            <div class="review-list">
                                @foreach($product->comments as $comment)
                                    <div class="review-item">
                                        {!!  $comment->content !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="revies-form">
        <div class="revies-form__head">
            <h3>Написать отзыв</h3>
            <span class="revies-form__close"><img src="{{ asset("assets/front/img/close.png") }}" alt="Close"></span>
        </div>
        <div class="revies-form__body">
            <form action="{{ route('product.review') }}" method="POST">
                @csrf
                <input type="hidden" name="product" value="{{$product->id}}">
                <div class="form-group">
                    <label for="lastname"><span>Фамилия</span> <span class="required">*</span></label>
                    <input type="text" name="lastname" required="required">
                </div>
                <div class="form-group">
                    <label for="firstname"><span>Имя</span> <span class="required">*</span></label>
                    <input type="text" name="firstname" required="required">
                </div>
                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input type="tel" name="phone">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email">
                </div>
                <div class="form-group">
                    <label for="comment">Комментарий</label>
                    <textarea name="comment" id="comment"></textarea>
                </div>
                <input type="submit" value="Оставить отзыв">
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        jQuery(document).ready(function ($) {
            if ($('.product-images__thumbs img').length < 4) {
                var count = parseInt(4) - (parseInt(4) - parseInt($('.product-images__thumbs img').length));

                while (count < 4) { // выводит 0, затем 1, затем 2
                    $('.product-images__thumbs').append("<div class='add-image'></div>");
                    console.log(count);
                    count++;
                }
            }

        });
    </script>
    <script>
        jQuery(document).ready(function ($) {
            // Thumb-slider
            $('.product-images__thumbs').slick({
                vertical: true,
                infinite: false,
                verticalSwiping: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                focusOnSelect: true,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 4,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 4,
                            vertical: false,
                            verticalSwiping: false,
                        }
                    }
                ]
            });

            $('span#slick-next').click(function () {
                var count = parseInt($('.slick-track img').length - 1);
                $('.slick-track img').each(function () {
                    if ($(this).hasClass('slick-current')) {
                        if ($(this).attr('data-slick-index') < count) {
                            $(this).removeClass('slick-current');
                            $(this).next().addClass('slick-current');

                            var src = $(this).next().attr('src');
                            $('.product-images__main img').attr('src', src);
                            $('.product-images__thumbs').slick('slickNext');
                        } else {
                            if ($(window).width() > 576){
                                $('.slick-track').css('bottom', '20px');
                                $('.slick-track').css('top', '-20px');
                                setTimeout(function() {
                                    $('.slick-track').css('bottom', '0');
                                    $('.slick-track').css('top', '0');
                                }, 500);
                            }
                            else{
                                $('.slick-track').css('right', '20px');
                                $('.slick-track').css('left', '-20px');
                                setTimeout(function() {
                                    $('.slick-track').css('left', '0');
                                    $('.slick-track').css('right', '0');
                                }, 500);
                            }


                        }
                        return false;
                    }

                })
            });

            $('.product-images__thumbs img').click(function () {
                $('.slick-track img').removeClass('slick-current');
                $(this).addClass('slick-current');

                var src = $(this).attr('src');
                $('.product-images__main img').attr('src', src);
            });

            $('span#slick-prev').click(function () {

                $('.slick-track img').each(function () {
                    if ($(this).hasClass('slick-current')) {
                        if ($(this).attr('data-slick-index') > 0) {
                            $('.product-images__thumbs').slick('slickPrev');
                            $('.slick-track img').removeClass('slick-current');
                            $(this).prev().addClass('slick-current');

                            var src = $(this).prev().attr('src');
                            $('.product-images__main img').attr('src', src);

                        } else {
                            if ($(window).width() > 576){
                                $('.slick-track').css('top', '20px');
                                $('.slick-track').css('bottom', '-20px');
                                setTimeout(function() {
                                    $('.slick-track').css('top', '0');
                                    $('.slick-track').css('bottom', '0');
                                }, 500);
                            }
                            else{
                                $('.slick-track').css('right', '-20px');
                                $('.slick-track').css('left', '20px');
                                setTimeout(function() {
                                    $('.slick-track').css('left', '0');
                                    $('.slick-track').css('right', '0');
                                }, 500);
                            }
                        }
                        return false;
                    }

                })
            });


            // Замена главного изображения

            $('.product-images__thumbs').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
                var src = $('.slick-slide[data-slick-index=' + nextSlide + ']').attr("src");
                $('.product-images__main img').attr('src', src);
            });

            // Увелечение изображения

            $('.product-images__main').zoom({
                magnify: 2,
            });

            $('.btn-buy').click(function (event){
                event.preventDefault();
                $.ajax({
                    url: $(this).attr('href'),
                    success: function(data) {
                        cartCount();
                        $('.add-block').show();
                        $('.overlay').show();
                        setTimeout(function () {
                            $('.add-block').hide();
                            $('.overlay').hide();
                        }, 1250);
                    }
                });
                return false; //for good measure
            });
        })
    </script>
    {{--Разряды цены--}}
    <script>
        jQuery(document).ready(function () {
            function triplets(str) {
                return str.toString().replace(/(\d)(?=(\d{3})+([^\d]|$))/g, "$1 ");
            }

            var newPrice = triplets($('.price span').text());
            $('.price span').html(newPrice);

        })
    </script>
@endpush
