@extends('layouts.layout')
@section('title', 'Корзина интернет магазина')
@push('style')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/front/css/jquery.timepicker.css') }}">
@endpush
@section('best')
    @include('layouts.best')
@endsection
@section('content')
    <script src="https://api-maps.yandex.ru/2.1/?apikey={{ $code }}&lang=ru_RU" type="text/javascript"></script>
    <div class="main-content cart-content">
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
        <h2>Корзина</h2>
        @if($count)
            <div class="cart-products">
                <x-cart-list/>
            </div>
            <div class="cart-way">
                <h3>Выберите способ оплаты</h3>
                <div class="cart-choice payment-choice">
                    @foreach($payments as $key => $value)
                        <div class="cart-choice__option">
                            <input type="radio" name="payment" value="{{ $value->id }}" data-price="@if($calc && $value->value) {{ $value->value }} @elseif($calc && !$value->value) 0 @elseif(!$calc && $value->percent) {{ $value->percent }} @elseif(!$calc && !$value->percent) 0 @endif"  @if($key == 0 && $value->status) checked @endif @if(!$value->status) disabled="disabled" @endif>
                            <label for="cash-card">{{ $value->title }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="cart-way">
                <h3>Выберите способ отправки</h3>
                <p><small>(стоимость зависит от города)</small></p>
                <div class="cart-choice delivery-methods">
                    <x-delivery-methods/>
                </div>
            </div>
            <div class="maps-wrap">
                <x-cart-form/>
            </div>
            <div class="cart-prices">
                <ul class="cart-prices__one">
                    <li><span>Товары</span><span class="all-product">30 300 </span><span class="all-product-valet">₽</span></li>
                    <li><span>Комиссия банка</span><span class="all-payment">300 </span><span class="all-payment-valet">₽</span></li>
                    <li><span>Доставка</span><span class="all-delivery">300 </span><span class="all-delivery-valet">₽</span></li>
                </ul>
                <div class="cart-prices__all">
                    <div class="cart-prices__all-wrap">
                        <span>Итого</span><span class="all-price">30 900 ₽</span>
                    </div>
                </div>
            </div>
            <div class="cart-btn">
                <button id="cart-accept">Оформить заказ</button>
            </div>
        @else
            <h3>Корзина пустая ...</h3>
        @endif
    </div>
    <div class="cart-missing">
        <div class="cart-missing__head">
            <h3></h3>
            <span class="cart-missing__close"><img src="{{ asset('assets/front/img/close.png') }}" alt="Close"></span>
        </div>
        <div class="cart-missing__body">
        </div>
    </div>
    <div class="cart-delivery">
        <div class="cart-delivery__head">
            <h3></h3>
            <span class="cart-delivery__close"><img src="{{ asset('assets/front/img/close.png') }}" alt="Close"></span>
        </div>
        <div class="cart-delivery__body">
        </div>
        <div class="cart-delivery__down">
            <br><p>Полную информацию об регионах доставки и условиях смотрите в разделе "Оплата и доставка"</p>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    {{--Разряды цены--}}
    <script>
        jQuery(document).ready(function () {
            function triplets(str) {
                return str.toString().replace(/(\d)(?=(\d{3})+([^\d]|$))/g, "$1 ");
            }

            $('.cart-price').each(function () {
                var newBest = triplets($(this).text());
                $(this).html(newBest)
            })
        })
    </script>
    <script>
        $('.cart-maps').click(function () {
            //$('.cart-form__adress .adress').trigger("change");
        })
    </script>
    {{--Работа с адресом--}}
    <script>
        function updateeAdress(city) {
            if(!city) {
                city = null;
            }
            var city = city;

            let options = $('.delivery-methods .cart-choice__option');
            let delivery_id = null;

            options.each(function( index ) {
                if($(this).find('input').is(':checked')) {
                    delivery_id = $(this).find('input').val();
                }
            });

            $.ajax({
                url: '{{ route('cart.city.update')  }}',
                data: {
                    city: city,
                    delivery: delivery_id,
                },
                success: function (data) {
                    $('.cart-data').html(data);
                    updateCartData();
                    $('#cart-accept').attr('disabled', false);
                    allPrice();
                },
                error: function(result){
                    if(result.status == 421) {
                        var delivery = result.responseJSON.error;

                        var body = $('.cart-delivery__body');
                        var head = $('.cart-delivery__head h3');
                        body.empty();
                        head.empty();

                        head.append('По данному адресу доставка возможна только следующими способами:');

                        $.each(delivery, function( key, value ) {
                            body.append("<p>" + value + "</p>");
                        });

                        $('.cart-delivery').show();
                        $('.overlay').show();
                        $('#cart-accept').attr('disabled', true);
                    }

                    if(result.status == 422) {
                        var delivery = result.responseJSON.error;

                        var body = $('.cart-delivery__body');
                        var head = $('.cart-delivery__head h3');
                        body.empty();
                        head.empty();

                        head.append('По данному адрессу доставка отсутствует.');

                        $('.cart-delivery').show();
                        $('.overlay').show();
                        $('#cart-accept').attr('disabled', true);
                    }
                }
            });
        }
    </script>
    {{--Календарь--}}
    <script>
        /* Локализация datepicker */
        $.datepicker.regional['ru'] = {
            closeText: 'Закрыть',
            prevText: 'Предыдущий',
            nextText: 'Следующий',
            currentText: 'Сегодня',
            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
            dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
            dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
            dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
            weekHeader: 'Не',
            dateFormat: 'dd.mm.yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['ru']);
    </script>
    {{--Календарь минимальная дата--}}
    <script>
        {{--Обновить - Календарь минимальную дату--}}
        function updateData(days) {
            if (!days) {
                days = 1;
            }
            $( "#datepicker" ).datepicker("destroy");
            var date = new Date();

            date.setDate(date.getDate() + parseInt(days));

            $("#datepicker").datepicker({
                minDate: date
            });
        }
        updateData();
    </script>
    {{--Выбор времени--}}
    <script>
        function updateTime() {
            $("#timepicker").timepicker({
                timeFormat: 'HH:mm',
                interval: 60,
                minTime: '8:00',
                maxTime: '22:00',
                defaultTime: '19',
                startTime: '8:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
        }
        updateTime();
    </script>
    {{--Удалить товар из корзины--}}
    <script>
        $('.cart-products').on('click', '.cart-remove', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function(data) {
                    if(data) {
                        cartCount();
                        $('.cart-products').html(data);
                        delivery();
                        payment();
                        price();
                        allPrice();
                    } else {
                        location.reload();
                    }
                }
            });
            return false; //for good measure
        });
    </script>
    {{--Смена способа оплаты--}}
    <script>
        $('.payment-choice .cart-choice__option').on('change', 'input', function (e) {
            const ids = $(this).attr('value');
            $.ajax({
                url: '{{ route('delivery.update')  }}',
                data: {
                    id: ids,
                },
                success: function (data) {
                    $('.delivery-methods').html(data);
                    if ($('.cart-form__adress .adress').val().length !== 0) {
                        updateeAdress($('.cart-form__adress .adress').val());
                    }
                    delivery();
                    payment();
                    price();
                    allPrice();
                },
                error: function(result){
                    console.log(result);
                }
            });
        });
    </script>
    {{--Смена способа доставки--}}
    <script>
        $('.delivery-methods').on('change', '.cart-choice__option input', function (e) {
            if ($('.cart-form__adress .adress').val().length !== 0) {
                updateeAdress($('.cart-form__adress .adress').val());
            }

            delivery();
            payment();
            price();
            allPrice();
        });
    </script>
    {{--Работа со стоимостью--}}
    <script>
        $('.cart-products').on('change', 'input', function () {
            delivery();
            payment();
            price();
            allPrice();
        });

        function triplets(str) {
            return str.toString().replace(/(\d)(?=(\d{3})+([^\d]|$))/g, "$1 ");
        }

        function price() {
            var sum = 0;
            $('.cart-product').each(function () {
                sum += parseInt($(this).find('.cart-price').text().replace(/\s+/g, ''),10) * parseInt($(this).find('input').val());
            });

            $('.all-product').html(triplets(sum));
            $('.all-product-valet').html(' ₽');
        }

        function delivery(price) {
            if(!price) {
                price = 0;
            }

            var regionPrice;
            if (price === 0) {
                $('.delivery-methods .cart-choice__option input').each(function () {
                    if($(this).is(':checked')) {
                        regionPrice = $(this).attr('data-price');
                    }
                });
            } else {
                regionPrice = price;
            }

            if($('.cart-form__adress .adress').val().length !== 0) {

                @if($calcDelivery)
                $('.all-delivery').html(triplets(regionPrice));
                $('.all-delivery-valet').html(' ₽');
                @else
                $('.all-delivery').html(parseFloat(regionPrice));
                $('.all-delivery-valet').html(' %');
                @endif
            } else {
                @if($calcDelivery)
                $('.all-delivery').html('0');
                $('.all-delivery-valet').html(' ₽');
                @else
                $('.all-delivery').html('0');
                $('.all-delivery-valet').html(' %');
                @endif
            }

        }

        function payment() {
            var paymentPrice;
            $('.payment-choice .cart-choice__option input').each(function () {
                if($(this).is(':checked')) {
                    paymentPrice = $(this).attr('data-price');
                }
            });
            //parseInt($(this).find('.cart-price').text().replace(/\s+/g, ''),10)
            @if($calc)
            $('.all-payment').html(triplets(paymentPrice));
            $('.all-payment-valet').html(' ₽');
            @else
            $('.all-payment').html(paymentPrice);
            $('.all-payment-valet').html(' %');
            @endif
        }

        function allPrice() {
            //triplets
            var payment = parseFloat($('.all-payment').text().replace(/\s+/g, ''),10);
            var delivery = parseFloat($('.all-delivery').text().replace(/\s+/g, ''),10);
            var product = parseFloat($('.all-product').text().replace(/\s+/g, ''),10);

            @if($calc && $calcDelivery)
                var sum = payment + delivery + product;
                var allSum = triplets(sum);
                $('.all-price').html(allSum.replace(/(\..{2}).*/,'$1') + ' ₽');
                    @elseif(!$calc && !$calcDelivery)
                var sum = (product/100*delivery) + (product/100*payment) + product;
                var allSum = triplets(sum);
                $('.all-price').html(allSum.replace(/(\..{2}).*/,'$1') + ' ₽');
            @elseif(!$calc && $calcDelivery)
                var sum = (product/100*payment) + delivery + product;
                var allSum = triplets(sum);
                $('.all-price').html(allSum.replace(/(\..{2}).*/,'$1') + ' ₽');
            @elseif($calc && !$calcDelivery)
                var sum = payment + (product/100*delivery) + product;
                var allSum = triplets(sum);
                $('.all-price').html(allSum.replace(/(\..{2}).*/,'$1') + ' ₽');
            @endif
        }

    </script>
    {{--Оформление заказа--}}
    <script>
        $('#cart-accept').click(function () {
            var products = [];
            $('.cart-product').each(function () {
                products.push({
                    id: $(this).find('.id-input').val(),
                    title: $(this).find('.cart-product__text-title a').text(),
                    href: $(this).find('.product-href').attr('href'),
                    price: $(this).find('.cart-price').text(),
                    qnt: $(this).find('.qnt-input').val()
                })
            });

            var payment;
            var delivery;

            $('.delivery-methods .cart-choice__option').each(function( index ) {
                if($(this).find('input').is(':checked')) {
                    delivery = $(this).find('input').val();
                }
            });

            $('.payment-choice .cart-choice__option').each(function( index ) {
                if($(this).find('input').is(':checked')) {
                    payment = $(this).find('input').val();
                }
            });

            var region = $('.nice-select .current').text();
            var firstname = $('.firstname').val();
            var lastname = $('.lastname').val();
            var phone = $('.phone').val();
            var email = $('.email').val();
            var adress = $('.adress').val();
            var date = $('#datepicker').val();
            var time = $('#timepicker').val();

            var price_product = $('.all-product').text();
            var price_payment = $('.all-payment').text();
            var price_delivery = $('.all-delivery').text();
            var price_all = $('.all-price').text();

            var token = $('input[name="_token"]').val();

            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                url: '{{ route('order')  }}',
                data: {
                    products: products,
                    payment: payment,
                    delivery: delivery,
                    firstname: firstname,
                    lastname: lastname,
                    phone: phone,
                    email: email,
                    region: region,
                    adress: adress,
                    date: date,
                    time: time,
                    price_product: price_product,
                    price_payment: price_payment,
                    price_delivery: price_delivery,
                    price_all: price_all,
                },
                success: function (data) {
                    location.reload();
                },
                error: function(result){
                    // Проверка на наличие товара
                    if(result.status == 424) {
                        var products = result.responseJSON.errors;

                        var body = $('.cart-missing__body');
                        var head = $('.cart-missing__head h3');
                        body.empty();
                        head.empty();

                        head.append('К сожалению нижеуказанных товаров нет в наличии, удалите пожалуйста из корзины эти товары:');

                        $.each(products, function( key, value ) {
                            body.append("<div class='cart-missing__item'><div class='cart-missing__item-img'><img src='{{ asset('uploads/') }}/" + value.image + "' alt='Product'></div><div class='cart-missing__item-text'><div class='cart-missing__item-title'>" + value.title +"</div><div class='cart-missing__item-price'>" + value.price +" ₽</div></div></div>");
                        });

                        $('.cart-missing').show();
                        $('.overlay').show();
                    }

                    if(result.status == 423) {
                        var products = result.responseJSON.errors;
                        console.log(result);

                        var body = $('.cart-missing__body');
                        var head = $('.cart-missing__head h3');
                        body.empty();
                        head.empty();

                        head.append('К сожалению нижеуказанных товаров нет в таком количестве:');

                        $.each(products, function( key, value ) {
                            body.append("<div class='cart-missing__item'><div class='cart-missing__item-img'><img src='{{ asset('uploads/') }}/" + value.image + "' alt='Product'></div><div class='cart-missing__item-text'><div class='cart-missing__item-title'>" + value.title +" - <small> Всего: " + value.quantity + " шт.</small></div><div class='cart-missing__item-price'>" + value.price +" ₽</div></div></div>");
                        });

                        $('.cart-missing').show();
                        $('.overlay').show();
                    }

                    // Проверка на заполнения формы
                    if(result.status == 422) {
                        $('.nice-select .current').css('border-color', '#ddd');
                        $('.firstname').css('border-color', '#ddd');
                        $('.lastname').css('border-color', '#ddd');
                        $('.phone').css('border-color', '#ddd');
                        $('.email').css('border-color', '#ddd');
                        $('.adress').css('border-color', '#ddd');
                        $('#datepicker').css('border-color', '#ddd');
                        $('#timepicker').css('border-color', '#ddd');

                        var required = result.responseJSON.errors;
                        if(required) {
                            $.each(required, function( key, value ) {
                                $('.'+key).css('border-color', 'red');
                            });
                        }

                        var region = result.responseJSON.error;
                        if(region) {
                            $('.adress').css('border-color', 'red');
                            $('.form-error').show();
                            $('.form-error').text(region);
                        }
                    }
                }
            });
        });
    </script>
    <script>
        delivery();
        payment();
        price();
        allPrice();
    </script>
    @stack('maps')
@endpush
