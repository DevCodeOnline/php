@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Добавить способ оплаты</h1>
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
                            <h3 class="card-title">Добавления способа оплаты</h3>
                        </div>
                        <!-- /.card-header -->

                        <form role="form" method="post" action="{{ route('payments.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input type="text" name="title"
                                           class="form-control @error('title') is-invalid @enderror" id="title"
                                           placeholder="Название">
                                </div>
                                <div class="form-group">
                                    <label for="value">Стоимость в рублях</label>
                                    <input type="text" name="value"
                                           class="form-control @error('value') is-invalid @enderror" id="value"
                                           placeholder="Стоимость в рублях (руб.)">
                                </div>
                                <div class="form-group">
                                    <label for="percent">Стоимость в процентах <small>(через точку)</small></label>
                                    <input type="text" name="percent"
                                           class="form-control @error('percent') is-invalid @enderror" id="percent"
                                           placeholder="Стоимость в процентах (%)">
                                </div>
                                <div class="form-group">
                                    <label for="delivery">Доступные способы доставки</label>
                                    <select name="deliveries[]" id="delivery" class="select2" multiple="multiple" data-placeholder="Выбрать способ доставки" style="width: 100%;">
                                        @foreach($deliveries as $k => $v)
                                            <option value="{{ $k }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Статус</label>
                                    <select class="form-control" name="status" id="status" data-placeholder="Выберите статус" autocomplete="off">
                                        <option value="1" selected>Включен</option>
                                        <option value="0">Отключен</option>
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
