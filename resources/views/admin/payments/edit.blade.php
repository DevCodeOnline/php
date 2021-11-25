@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Редактировать способ оплаты</h1>
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
                            <h3 class="card-title">Редактиование - {{ $payment->title }}</h3>
                        </div>
                        <!-- /.card-header -->

                        <form role="form" method="post" action="{{ route('payments.update', ['payment' => $payment->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input type="text" name="title"
                                           class="form-control @error('title') is-invalid @enderror" id="title"
                                           value="{{ $payment->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="value">Стоимость в рублях</label>
                                    <input type="text" name="value"
                                           class="form-control @error('value') is-invalid @enderror" id="value"
                                           value="{{ $payment->value }}">
                                </div>
                                <div class="form-group">
                                    <label for="percent">Стоимость в процентах <small>(через точку)</small></label>
                                    <input type="text" name="percent"
                                           class="form-control @error('percent') is-invalid @enderror" id="percent"
                                           value="{{ $payment->percent }}">
                                </div>
                                <div class="form-group">
                                    <label for="delivery">Доступные способы доставки</label>
                                    <select name="deliveries[]" id="delivery" class="select2" multiple="multiple" data-placeholder="Выбрать способ доставки" style="width: 100%;">
                                        @foreach($deliveries as $k => $v)
                                            <option value="{{ $k }}" @if($k == $payment->delivery->contains($k)) selected @endif>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Статус</label>
                                    <select class="form-control" name="status" id="status" data-placeholder="Выберите статус" autocomplete="off">
                                        <option value="1" @if($payment->status) selected @endif>Включен</option>
                                        <option value="0" @if(!$payment->status) selected @endif>Отключен</option>
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
