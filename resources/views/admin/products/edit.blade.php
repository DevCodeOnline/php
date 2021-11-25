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
                                    <label for="id">ID</label>
                                    <input type="text" name="id"
                                           class="form-control @error('id') is-invalid @enderror" id="id"
                                           value="{{ $product->id }}">
                                </div>
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
                                    <label for="image">Изображения</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="images[]" type="file" class="custom-file-input" id="images" multiple>
                                            <label class="custom-file-label" for="images">Добавить изображения</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex mt-3" style="align-items: center;justify-content: space-between">
                                        @if($product->image)
                                        <p class="mb-0">
                                            <img style="width:50px;margin-right:10px;border: 2px solid #ddd;padding:2px;" src="{{ str_replace('\\', '/', asset(trim("uploads/$product->image"))) }}" alt="{{$product->title}}">
                                            <span>{{ str_replace('\\', '/', asset(trim("uploads/$product->image"))) }}</span>
                                        </p>
                                        <a class="btn btn-danger btn-sm" href="{{ route('products.destroy.image', ['id' => $product->id]) }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @else
                                            <p class="mb-0">Основное изображение - не заполнено</p>
                                        @endif
                                    </div>
                                    <hr>
                                    @foreach($product->images as $image)
                                    <div class="d-flex" style="align-items: center;justify-content: space-between">
                                        <p class="mb-0">
                                            <img style="width:50px;margin-right:10px;border: 2px solid #ddd;padding:2px;" src="{{ str_replace('\\', '/', asset(trim("uploads/$image->image"))) }}" alt="{{$product->title}}">
                                            <span>{{ str_replace('\\', '/', asset(trim("uploads/$image->image"))) }}</span>
                                        </p>
                                        <a class="btn btn-danger btn-sm" href="{{ route('products.destroy.images', ['id' => $image->id]) }}">
                                                <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                    <hr>
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
