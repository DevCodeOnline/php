@extends('layouts.layout')
@section('title', 'Категории интернет магазина')
@section('best')
    @include('layouts.best')
@endsection
@section('content')
    <div class="main-content">
        <h1>{{ is_a($category, 'Illuminate\Database\Eloquent\Collection') ? 'Все категории' : 'Категория «' . $category->title . '»' }}</h1>
        @if(!$products->isEmpty())
            <div class="product-sort">
                <div class="product-sort__select">
                    <form action="{{ route('categories') }}" method="POST">
                        @csrf
                        <label for="sort">Сортировать по:</label>
                        <select name="sort" id="sort" class="product-sort">
                            <option value="sort[asc]" selected>По умолчанию</option>
                            <option value="title[asc]">По наименованию (А-Я)</option>
                            <option value="title[desc]">По наименованию (Я-А)</option>
                            <option name="price" value="price[asc]">По цене (возрастание)</option>
                            <option name="price" value="price[desc]">По цене (убывание)</option>
                        </select>
                    </form>
                </div>
                <div class="product-sort__views">
                    <div class="btn-group">
                        <a href="#" class="btn-list active" data-value="grid"><i class="fa fa-th"></i></a>
                        <a href="#" class="btn-grid" data-value="list"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
            </div>
            <div class="product-listing">
                <x-categories/>
            </div>
        @else
            <div style="margin-top: 20px;width: 100%;height: 2px;background: #ddd"></div>
            <h3 style="margin-bottom: 20px">В категории нет товаров ...</h3>
        @endif
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
<script>
    $('.product-qnt').niceSelect();
</script>
{{--Показать количество--}}
<script>
    $(document).ready(function() {
        function triplets(str) {
            return str.toString().replace(/(\d)(?=(\d{3})+([^\d]|$))/g, "$1 ");
        }
        function priceUpdate() {
            $('.product-item__price-span').each(function () {
                var newBest = triplets($(this).text());
                $(this).html(newBest)
            })
        }
        var token = $('#show-product').attr("data-token");
        $('.product-listing').on('change', '.product-qnt', function (e) {
            e.preventDefault();

            const url = new URL(window.location);
            const optionSort = $('.product-sort ul').find("li.selected").attr('data-value');
            const optionShow = $('.product-qnt ul').find("li.selected").attr('data-value');
            const optionLayout = $.urlParam('layout');
            const optionPage = $.urlParam('page');

            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                url: '{{ route('categories', ['slug' => $slug])  }}',
                data: {
                    sort: optionSort,
                    show: optionShow,
                    layout: optionLayout,
                    page: optionPage
                },
                success: function (data) {
                    url.searchParams.set('show', optionShow);
                    history.pushState(null, null, url);

                    $('.product-listing').html(data);
                    $('.product-qnt').niceSelect();

                    if($.urlParam('show')) {
                        $('.product-qnt ul li').each(function (index, el) {
                            if($(this).attr('data-value') == $.urlParam('show')) {
                                $('.product-qnt .current').html($.urlParam('show'));
                                $(this).addClass('selected');
                            } else {
                                $(this).removeClass('selected');
                            }
                        });
                    }

                    if($.urlParam('sort')) {
                        $('.product-sort ul li').each(function (index, el) {
                            if($(this).attr('data-value') == $.urlParam('sort')) {
                                $('.product-sort .current').html($(this).text());
                                $(this).addClass('selected focus');
                            } else {
                                $(this).removeClass('selected');
                            }
                        });
                    }
                    layoutUpdate();
                    priceUpdate();
                    paginationUpdate();
                },
                error: function(result){
                    console.log(result);
                }
            });
        });
    });
</script>
{{--Сортировка--}}
<script>
    $(document).ready(function() {
        function triplets(str) {
            return str.toString().replace(/(\d)(?=(\d{3})+([^\d]|$))/g, "$1 ");
        }
        function priceUpdate() {
            $('.product-item__price-span').each(function () {
                var newBest = triplets($(this).text());
                $(this).html(newBest)
            })
        }
        priceUpdate();
        var token = $('#show-product').attr("data-token");
        $('#sort').on('change', function (e) {
            e.preventDefault();

            const url = new URL(window.location);
            const optionSort = $('.product-sort ul').find("li.selected").attr('data-value');
            const optionShow = $('.product-qnt ul').find("li.selected").attr('data-value');
            const optionLayout = $.urlParam('layout');
            const optionPage = $.urlParam('page');


            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                url: '{{ route('categories', ['slug' => $slug])  }}',
                data: {
                    sort: optionSort,
                    show: optionShow,
                    layout: optionLayout,
                    page: optionPage
                },
                success: function (data) {
                    url.searchParams.set('sort', optionSort);
                    history.pushState(null, null, url);

                    $('.product-listing').html(data);
                    $('.product-qnt').niceSelect();

                    if($.urlParam('show')) {
                        $('.product-qnt ul li').each(function (index, el) {
                            if($(this).attr('data-value') == $.urlParam('show')) {
                                $('.product-qnt .current').html($.urlParam('show'));
                                $(this).addClass('selected');
                            } else {
                                $(this).removeClass('selected');
                            }
                        });
                    }

                    if($.urlParam('sort')) {
                        $('.product-sort ul li').each(function (index, el) {
                            if($(this).attr('data-value') == $.urlParam('sort')) {
                                $('.product-sort .current').html($(this).text());
                                $(this).addClass('selected focus');
                            } else {
                                $(this).removeClass('selected');
                            }
                        });
                    }
                    layoutUpdate();
                    priceUpdate();
                    paginationUpdate();
                },
                error: function(result){
                    console.log(result);
                }
            });
        });
    });
</script>
{{--Проверка параметров--}}
<script>
    $(document).ready(function () {
        if($.urlParam('show')) {
            $('.product-qnt ul li').each(function (index, el) {
                if($(this).attr('data-value') == $.urlParam('show')) {
                    $('.product-qnt .current').html($.urlParam('show'));
                    $(this).addClass('selected');
                } else {
                    $(this).removeClass('selected');
                }
            });
        }

        if($.urlParam('sort')) {
            $('.product-sort ul li').each(function (index, el) {
                if($(this).attr('data-value') == $.urlParam('sort')) {
                    $('.product-sort .current').html($(this).text());
                    $(this).addClass('selected focus');
                } else {
                    $(this).removeClass('selected');
                }
            });
        }


    });
</script>
{{--Пагинация--}}
<script>
    function paginationUpdate() {
        $(function(){
            if ($(window).width() > 1400 ){
                var div = $('.link-page');
                var count = div.length;
                var dots = $('.link-dots').length;
                var ellement = 0;
                if(!div.eq(0).hasClass('active')) {
                    div.eq(0).css('display', 'none');
                    ellement++;
                }
                div.each(function () {
                    $(this).css('width', '40px');
                    $(this).find('span').css('width', '40px');
                    $(this).find('a').css('width', '40px');
                    $('.link-dots').css('width', '40px');
                    $('.link-dots').find('span').css('width', '40px');
                })

            }

            if ($(window).width() > 1200 && $(window).width() < 1400){
                var div = $('.link-page');
                var count = div.length;
                var dots = $('.link-dots').length;
                var ellement = 0;

                if(!div.eq(0).hasClass('active')) {
                    div.eq(0).css('display', 'none');
                    ellement++;
                }
                div.each(function () {
                    $(this).css('width', '35px');
                    $(this).find('span').css('width', '35px');
                    $(this).find('a').css('width', '35px');
                    $('.link-dots').css('width', '35px');
                    $('.link-dots').find('span').css('width', '35px');
                })
            }

            if ($(window).width() < 1200){
                var div = $('.link-page');
                var count = div.length;

                if(count > 5) {
                    var link_width = parseInt(60) / parseInt(count);

                    div.each(function () {
                        $(this).css('width', link_width + '%');
                    })
                } else if(count == 4) {
                    $('.product-navigation ul li.prev-link').css('width', '30%');
                    $('.product-navigation ul li.link-up').css('width', '30%');

                    var link_width = parseInt(40) / parseInt(count);

                    div.each(function () {
                        $(this).css('width', link_width + '%');
                    })
                } else if(count == 3) {
                    $('.product-navigation ul li.prev-link').css('width', '35%');
                    $('.product-navigation ul li.link-up').css('width', '35%');

                    var link_width = parseInt(30) / parseInt(count);

                    div.each(function () {
                        $(this).css('width', link_width + '%');
                    })
                } else if(count == 2){
                    $('.product-navigation ul li.prev-link').css('width', '40%');
                    $('.product-navigation ul li.link-up').css('width', '40%');

                    var link_width = parseInt(20) / parseInt(count);

                    div.each(function () {
                        $(this).css('width', link_width + '%');
                    })
                } else {
                    $('.product-navigation ul li.prev-link').css('width', '45%');
                    $('.product-navigation ul li.link-up').css('width', '45%');

                    var link_width = parseInt(10) / parseInt(count);

                    div.each(function () {
                        $(this).css('width', link_width + '%');
                    })
                }
            }

        });
    }
    paginationUpdate();
</script>
{{--Сетка--}}
<script>
    $(document).ready(function() {
        function triplets(str) {
            return str.toString().replace(/(\d)(?=(\d{3})+([^\d]|$))/g, "$1 ");
        }
        function priceUpdate() {
            $('.product-item__price-span').each(function () {
                var newBest = triplets($(this).text());
                $(this).html(newBest)
            })
        }
        priceUpdate();
        var token = $('#show-product').attr("data-token");

        $('.btn-group').on('click', 'a',  function (e) {
            e.preventDefault();
            console.log($(this).attr('data-value'));

            const url = new URL(window.location);
            const optionSort = $('.product-sort ul').find("li.selected").attr('data-value');
            const optionShow = $('.product-qnt ul').find("li.selected").attr('data-value');
            const optionLayout = $(this).attr('data-value');
            const optionPage = $.urlParam('page');


            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                url: '{{ route('categories', ['slug' => $slug])  }}',
                data: {
                    sort: optionSort,
                    show: optionShow,
                    layout: optionLayout,
                    page: optionPage
                },
                success: function (data) {
                    url.searchParams.set('layout', optionLayout);
                    history.pushState(null, null, url);

                    $('.product-listing').html(data);
                    $('.product-qnt').niceSelect();

                    if($.urlParam('show')) {
                        $('.product-qnt ul li').each(function (index, el) {
                            if($(this).attr('data-value') == $.urlParam('show')) {
                                $('.product-qnt .current').html($.urlParam('show'));
                                $(this).addClass('selected');
                            } else {
                                $(this).removeClass('selected');
                            }
                        });
                    }

                    if($.urlParam('sort')) {
                        $('.product-sort ul li').each(function (index, el) {
                            if($(this).attr('data-value') == $.urlParam('sort')) {
                                $('.product-sort .current').html($(this).text());
                                $(this).addClass('selected focus');
                            } else {
                                $(this).removeClass('selected');
                            }
                        });
                    }

                    layoutUpdate();
                    priceUpdate();
                    paginationUpdate();
                },
                error: function(result){
                    console.log(result);
                }
            });
        });
    });
</script>
<script>
    function layoutUpdate() {
        var layout = $.urlParam('layout');
        if(layout === null) {
            layout = 'grid';
        }

        if(layout === 'grid') {
            $('.btn-list').addClass('active');
            $('.btn-grid').removeClass('active');
        } else {
            $('.btn-list').removeClass('active');
            $('.btn-grid').addClass('active');
        }
    };

    $(document).ready(function() {
        var param = $.urlParam('layout');

        layoutUpdate($.urlParam(param));
    });


</script>
@endpush
