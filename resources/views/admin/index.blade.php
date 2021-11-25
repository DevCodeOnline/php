@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Главная</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Панель управления</h3>
                <a href="{{ route('admin.refresh') }}" class="btn btn-primary d-block ml-auto" style="width: 150px">Обновить ({{ $count }})</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        {{--Загрузка вспомогательных изображений--}}
                        <div class="form-group d-flex" style="width: 100%;justify-content: space-between; align-items: center">
                            {{--Загрузка вспомогательных изображений -  изображения--}}
                            <form class="d-flex" role="form" method="post" action="{{ route('other.import') }}" enctype="multipart/form-data" style="width: 100%;justify-content: space-between; align-items: center">
                                @csrf
                                <span style="width: 300px;">Загрузить вспомогательные изображения</span>
                                <div>
                                    <div class="form-group" style="display: flex;align-items: center;">
                                        <div class="custom-file" style="width: 300px">
                                            <input type="file" name="zip_other" class="custom-file-input" id="zip_other" style="width: 0">
                                            <label class="custom-file-label" for="zip_other">Архив изображений</label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group" style="display: flex;align-items: center;">
                                        <div class="custom-file" style="width: 300px">
                                            <input type="file" name="image_other_import" class="custom-file-input" id="image_other_import" style="width: 0">
                                            <label class="custom-file-label" for="image_other_import">Эксель файл</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary ml-5">Загрузить</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <hr>
                        {{--Выгрузка вспомогательных изображений--}}
                        <div class="form-group d-flex" style="width: 100%;justify-content: space-between; align-items: center">
                            <span style="display: block;height: 100%">Выгрузить вспомогательные изображения</span>
                            <a href="{{ route('other.export') }}" class="btn btn-primary">Выгрузить</a>
                        </div>
                        <hr>

                        {{--Загрузка структуры--}}
                        <div class="form-group d-flex" style="width: 100%;justify-content: space-between; align-items: center">
                            <form class="d-flex" role="form" method="post" action="{{ route('category.import') }}" enctype="multipart/form-data" style="width: 100%;justify-content: space-between; align-items: center">
                                @csrf
                                <span style="width: 300px;">Загрузить структуру</span>
                                <div>
                                    <div class="form-group" style="display: flex;align-items: center;">
                                        <div class="custom-file" style="width: 300px">
                                            <input type="file" name="zip_category" class="custom-file-input" id="zip_category" style="width: 0">
                                            <label class="custom-file-label" for="zip_category">Архив изображений</label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group" style="display: flex;align-items: center;">
                                        <div class="custom-file" style="width: 300px">
                                            <input type="file" name="categories_import" class="custom-file-input" id="categories_import" style="width: 0">
                                            <label class="custom-file-label" for="categories_import">Эксель файл</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary ml-5">Загрузить</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr>
                        {{--Загрузка товаров--}}
                        {{--                            <div class="form-group d-flex" style="width: 800px;justify-content: space-between; align-items: center" >--}}
                        {{--                                <form class="d-flex" role="form" method="post" action="{{ route('product.import') }}" enctype="multipart/form-data" style="width: 800px;justify-content: space-between; align-items: center">--}}
                        {{--                                    @csrf--}}
                        {{--                                    <div>--}}
                        {{--                                        <span class="d-block mb-2">Загрузить изображения (архив)</span>--}}
                        {{--                                        <div class="form-group" style="display: flex;align-items: center;">--}}
                        {{--                                            <div class="custom-file" style="width: 300px">--}}
                        {{--                                                <input type="file" name="zip_product" class="custom-file-input" id="zip_product" style="width: 0">--}}
                        {{--                                                <label class="custom-file-label" for="zip_product">Choose file</label>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div>--}}
                        {{--                                        <span class="d-block mb-2">Загрузить товары (Excel)</span>--}}
                        {{--                                        <div class="form-group" style="display: flex;align-items: center;">--}}
                        {{--                                            <div class="custom-file" style="width: 300px">--}}
                        {{--                                                <input type="file" name="products_import" class="custom-file-input" id="products_import" style="width: 0">--}}
                        {{--                                                <label class="custom-file-label" for="products_import">Choose file</label>--}}
                        {{--                                            </div>--}}
                        {{--                                            <button type="submit" class="btn btn-primary ml-5">Загрузить</button>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                </form>--}}
                        {{--                            </div>--}}
                        {{--                            <hr>--}}
                        {{--Загрузка регионов доставки--}}
                        <div class="form-group" style="width: 100%;">
                            <form class="d-flex" style="justify-content: space-between; align-items: center" role="form" method="post" action="{{ route('delivery.import') }}" enctype="multipart/form-data">
                                @csrf
                                <span class="d-block">Загрузить регионы доставки</span>
                                <div style="display: flex;align-items: center;">
                                    <div class="custom-file" style="width: 300px">
                                        <input type="file" name="deliveries_import" class="custom-file-input" id="deliveries_import" style="width: 0">
                                        <label class="custom-file-label" for="deliveries_import">Эксель файл</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-5">Загрузить</button>
                                </div>
                            </form>
                        </div>
                        <hr>
                        {{--Загрузка регионов не доставки--}}
                        <div class="form-group" style="width: 100%;">
                            <form class="d-flex" style="justify-content: space-between; align-items: center" role="form" method="post" action="{{ route('not.delivery.import') }}" enctype="multipart/form-data">
                                @csrf
                                <span class="d-block">Загрузить регионы не доставки</span>
                                <div style="display: flex;align-items: center;">
                                    <div class="custom-file" style="width: 300px">
                                        <input type="file" name="not_deliveries_import" class="custom-file-input" id="not_deliveries_import" style="width: 0">
                                        <label class="custom-file-label" for="not_deliveries_import">Эксель файл</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-5">Загрузить</button>
                                </div>

                            </form>
                        </div>
                        <hr>
                        {{--Обновить товары--}}
                        <div class="form-group d-flex" style="width: 100%;justify-content: space-between; align-items: center" >
                            <form class="d-flex" role="form" method="post" action="{{ route('product.update') }}" enctype="multipart/form-data" style="width: 100%;justify-content: space-between; align-items: center">
                                @csrf
                                <span style="width: 300px">Обновить товары (Excel)</span>
                                <div>
                                    <div class="form-group" style="display: flex;align-items: center;">
                                        <div class="custom-file" style="width: 300px">
                                            <input type="file" name="zip_update_product" class="custom-file-input" id="zip_update_product" style="width: 0">
                                            <label class="custom-file-label" for="zip_update_product">Архив изображений</label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group" style="display: flex;align-items: center;">
                                        <div class="custom-file" style="width: 300px">
                                            <input type="file" name="products_update" class="custom-file-input" id="products_update" style="width: 0">
                                            <label class="custom-file-label" for="products_update">Эксель файл</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary ml-5">Обновить</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr>
                        {{--Обновить название товаров--}}
                        <div class="form-group" style="width: 100%;">
                            <form class="d-flex" style="justify-content: space-between; align-items: center" role="form" method="post" action="{{ route('product.title.update') }}" enctype="multipart/form-data">
                                @csrf
                                <span class="d-block">Обновить названия товаров</span>
                                <div style="display: flex;align-items: center;">
                                    <div class="custom-file" style="width: 300px">
                                        <input type="file" name="product_title_update" class="custom-file-input" id="product_title_update" style="width: 0">
                                        <label class="custom-file-label" for="product_title_update">Эксель файл</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-5">Обновить</button>
                                </div>

                            </form>
                        </div>
                        <hr>
                        {{--Обновить изображения товаров--}}
                        <div class="form-group d-flex" style="width: 100%;justify-content: space-between; align-items: center" >
                            <form class="d-flex" role="form" method="post" action="{{ route('product.image.update') }}" enctype="multipart/form-data"style="width: 100%;justify-content: space-between; align-items: center">
                                @csrf
                                <span style="width: 300px">Обновить изображения товаров (Excel)</span>
                                <div>
                                    <div class="form-group" style="display: flex;align-items: center;">
                                        <div class="custom-file" style="width: 300px">
                                            <input type="file" name="zip_update_product_image" class="custom-file-input" id="zip_update_product_image" style="width: 0">
                                            <label class="custom-file-label" for="zip_update_product_image">Архив изображений</label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group" style="display: flex;align-items: center;">
                                        <div class="custom-file" style="width: 300px">
                                            <input type="file" name="product_image_update" class="custom-file-input" id="product_image_update" style="width: 0">
                                            <label class="custom-file-label" for="product_image_update">Эксель файл</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary ml-5">Обновить</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <hr>
                        {{--Обновить расположение товаров (+)--}}
                        <div class="form-group" style="width: 100%;">
                            <form class="d-flex" style="justify-content: space-between; align-items: center" role="form" method="post" action="{{ route('product.category.update') }}" enctype="multipart/form-data">
                                @csrf
                                <span class="d-block">Обновить расположение товаров</span>
                                <div style="display: flex;align-items: center;">
                                    <div class="custom-file" style="width: 300px">
                                        <input type="file" name="product_category_update" class="custom-file-input" id="product_category_update" style="width: 0">
                                        <label class="custom-file-label" for="product_category_update">Эксель файл</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-5">Обновить</button>
                                </div>

                            </form>
                        </div>
                        <hr>
                        {{--Обновить лучшие товары--}}
                        <div class="form-group" style="width: 100%;">
                            <form class="d-flex" style="justify-content: space-between; align-items: center" role="form" method="post" action="{{ route('product.best.update') }}" enctype="multipart/form-data">
                                @csrf
                                <span class="d-block">Обновить лучшие товары</span>
                                <div style="display: flex;align-items: center;">
                                    <div class="custom-file" style="width: 300px">
                                        <input type="file" name="product_best_update" class="custom-file-input" id="product_best_update" style="width: 0">
                                        <label class="custom-file-label" for="product_best_update">Эксель файл</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-5">Обновить</button>
                                </div>

                            </form>
                        </div>
                        <hr>
                        {{--Обновить отзывы товаров--}}
                        <div class="form-group" style="width: 100%;">
                            <form class="d-flex" style="justify-content: space-between; align-items: center" role="form" method="post" action="{{ route('product.comment.update') }}" enctype="multipart/form-data">
                                @csrf
                                <span class="d-block">Обновить отзывы товаров</span>
                                <div style="display: flex;align-items: center;">
                                    <div class="custom-file" style="width: 300px">
                                        <input type="file" name="product_comment_update" class="custom-file-input" id="product_comment_update" style="width: 0">
                                        <label class="custom-file-label" for="product_comment_update">Эксель файл</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-5">Обновить</button>
                                </div>

                            </form>
                        </div>
                        <hr>
                        {{--Обновить описание товаров--}}
                        <div class="form-group" style="width: 100%;">
                            <form class="d-flex" style="justify-content: space-between; align-items: center" role="form" method="post" action="{{ route('product.description.update') }}" enctype="multipart/form-data">
                                @csrf
                                <span class="d-block">Обновить описание товаров</span>
                                <div style="display: flex;align-items: center;">
                                    <div class="custom-file" style="width: 300px">
                                        <input type="file" name="product_description_update" class="custom-file-input" id="product_description_update" style="width: 0">
                                        <label class="custom-file-label" for="product_description_update">Эксель файл</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-5">Обновить</button>
                                </div>

                            </form>
                        </div>
                        <hr>
                        {{--Обновить количество товаров--}}
                        <div class="form-group" style="width: 100%;">
                            <form class="d-flex" style="justify-content: space-between; align-items: center" role="form" method="post" action="{{ route('product.quantity.update') }}" enctype="multipart/form-data">
                                @csrf
                                <span class="d-block">Обновить количество товаров</span>
                                <div style="display: flex;align-items: center;">
                                    <div class="custom-file" style="width: 300px">
                                        <input type="file" name="product_quantity_update" class="custom-file-input" id="product_quantity_update" style="width: 0">
                                        <label class="custom-file-label" for="product_quantity_update">Эксель файл</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-5">Обновить</button>
                                </div>

                            </form>
                        </div>
                        <hr>
                        {{--Обновить стоимость товаров--}}
                        <div class="form-group" style="width: 100%;">
                            <form class="d-flex" style="justify-content: space-between; align-items: center" role="form" method="post" action="{{ route('product.price.update') }}" enctype="multipart/form-data">
                                @csrf
                                <span class="d-block">Обновить стоимость товаров</span>
                                <div style="display: flex;align-items: center;">
                                    <div class="custom-file" style="width: 300px">
                                        <input type="file" name="product_price_update" class="custom-file-input" id="product_price_update" style="width: 0">
                                        <label class="custom-file-label" for="product_price_update">Эксель файл</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-5">Обновить</button>
                                </div>

                            </form>
                        </div>
                        <hr>
                        {{--Загрузка главной странице(+-)--}}
                        <div class="form-group" style="width: 100%;">
                            <form class="d-flex" style="justify-content: space-between; align-items: center" role="form" method="post" action="{{ route('main.page.import') }}" enctype="multipart/form-data">
                                @csrf
                                <span class="d-block">Загрузить главную страницу</span>
                                <div style="display: flex;align-items: center;">
                                    <div class="custom-file" style="width: 300px">
                                        <input type="file" name="main_page_import" class="custom-file-input" id="main_page_import" style="width: 0">
                                        <label class="custom-file-label" for="main_page_import">Эксель файл</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-5">Загрузить</button>
                                </div>

                            </form>
                        </div>
                        <hr>
                        {{--Удаление товаров--}}
                        <div class="form-group" style="width: 100%;">
                            <form class="d-flex" style="justify-content: space-between; align-items: center" role="form" method="post" action="{{ route('product.delete') }}" enctype="multipart/form-data">
                                @csrf
                                <span class="d-block">Удалить товары</span>
                                <div style="display: flex;align-items: center;">
                                    <div class="custom-file" style="width: 300px">
                                        <input type="file" name="products_delete" class="custom-file-input" id="products_delete" style="width: 0">
                                        <label class="custom-file-label" for="products_delete">Эксель файл</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-5" style="width: 97.13px;">Удалить</button>
                                </div>
                            </form>
                        </div>
                        <hr>
                        {{--Выгрузить товары--}}
                        <div class="form-group d-flex" style="width: 100%;justify-content: space-between; align-items: center">
                            <span style="display: block;height: 100%">Выгрузить товары</span>
                            <a href="{{ route('product.export') }}" class="btn btn-primary">Выгрузить</a>
                        </div>
                        <hr>
                        {{--Выгрузить количество товаров--}}
                        <div class="form-group d-flex" style="width: 100%;justify-content: space-between; align-items: center">
                            <span style="display: block;height: 100%">Выгрузить количество товаров</span>
                            <a href="{{ route('quantity.export') }}" class="btn btn-primary">Выгрузить</a>
                        </div>
                        <hr>
                        {{--Выгрузить стоимость товаров--}}
                        <div class="form-group d-flex" style="width: 100%;justify-content: space-between; align-items: center">
                            <span style="display: block;height: 100%">Выгрузить стоимость товаров</span>
                            <a href="{{ route('price.export') }}" class="btn btn-primary">Выгрузить</a>
                        </div>
                        <hr>
                        {{--Выгрузить структуры--}}
                        <div class="form-group d-flex" style="width: 100%;justify-content: space-between; align-items: center">
                            <span style="display: block;height: 100%">Выгрузить структуру</span>
                            <a href="{{ route('category.export') }}" class="btn btn-primary">Выгрузить</a>
                        </div>
                        <hr>
                        {{--Выгрузить главную сайта--}}
                        <div class="form-group d-flex" style="width: 100%;justify-content: space-between; align-items: center">
                            <span style="display: block;height: 100%">Выгрузить главную сайта</span>
                            <a href="{{ route('main.export') }}" class="btn btn-primary">Выгрузить</a>
                        </div>
                        <hr>
                        {{--Выгрузить регионы доставки--}}
                        <div class="form-group d-flex" style="width: 100%;justify-content: space-between; align-items: center">
                            <span style="display: block;height: 100%">Выгрузить регионы доставки</span>
                            <a href="{{ route('delivery.export') }}" class="btn btn-primary">Выгрузить</a>
                        </div>
                        <hr>
                        {{--Выгрузить регионы не доставки--}}
                        <div class="form-group d-flex" style="width: 100%;justify-content: space-between; align-items: center">
                            <span style="display: block;height: 100%">Выгрузить регионы не доставки</span>
                            <a href="{{ route('delivery.not.export') }}" class="btn btn-primary">Выгрузить</a>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer"></div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
@endsection
