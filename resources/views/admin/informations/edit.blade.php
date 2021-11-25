@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Редактирование товара</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Редактирование - {{ $product->title }}</h3>
                        </div>
                        <!-- /.card-header -->

                        <form role="form" method="post" action="{{ route('products.update', ['product' => $product->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input type="text" name="title"
                                           class="form-control @error('title') is-invalid @enderror" id="title"
                                           value="{{ $product->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Описание</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Тескт ..." id="description">{{ $product->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Количество</label>
                                    <input type="text" name="quantity"
                                           class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                           value="{{ $product->quantity }}">
                                </div>
                                <div class="form-group">
                                    <label for="price">Цена</label>
                                    <input type="text" name="price"
                                           class="form-control @error('price') is-invalid @enderror" id="price"
                                           value="{{ $product->price }}">
                                </div>
                                <div class="form-group">
                                    <label for="image">Основное изображение</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="image" type="file" class="custom-file-input" id="image">
                                            <label class="custom-file-label" for="image">Добавить изображение</label>
                                        </div>
                                    </div>
                                    <div>{{ $product->image }}</div>
                                </div>
                                <div class="form-group">
                                    <label for="image">Дополнительные изображения</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="images[]" type="file" class="custom-file-input" id="images" multiple>
                                            <label class="custom-file-label" for="images">Добавить изображения</label>
                                        </div>
                                    </div>
                                    @foreach($product->images as $image)
                                    <div>{{ $image->image }}</div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="category">Категория</label>
                                    <select name="categories[]" id="category" class="select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                        @foreach($categories as $k => $v)
                                            <option value="{{ $k }}" @if($k == $product->categories->contains($k)) selected @endif>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>

                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
