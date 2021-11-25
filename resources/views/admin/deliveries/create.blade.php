@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Добавить способ доставки</h1>
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
                            <h3 class="card-title">Добавления способа доставки</h3>
                        </div>
                        <!-- /.card-header -->

                        <form role="form" method="post" action="{{ route('deliveries.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input type="text" name="title"
                                           class="form-control @error('title') is-invalid @enderror" id="title"
                                           placeholder="Название">
                                </div>
                                <div class="form-group">
                                    <label for="title">Регионы доставки</label>
                                    <hr>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-3">
                                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                            @foreach($regions as $k => $v)
                                                <a class="nav-link @if($k === 1) active @endif" id="vert-{{ $k }}" data-toggle="pill" href="#tabs-{{ $k }}" role="tab" aria-controls="vert-{{ $k }}" aria-selected="false">{{ $v }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-7 col-sm-9">
                                        <div class="tab-content" id="vert-tabs-tabContent">
                                            @foreach($regions as $k => $v)
                                            <div class="tab-pane fade @if($k === 1) active show @endif" id="tabs-{{ $k }}" role="tabpanel">
                                                <div class="form-group">
                                                    <label>Добавить регоин? <small>- {{ $v }}</small></label>
                                                    <select name="regions[{{ $k }}][add]" id="delivery_{{ $k }}" class="form-control" data-placeholder="Добавить регион?">
                                                        <option value="1">Да</option>
                                                        <option value="0" selected>Нет</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="days">Дней</label>
                                                    <input type="text" name="regions[{{$k}}][days]"
                                                           class="form-control @error('title') is-invalid @enderror"
                                                           placeholder="Дней">
                                                </div>
                                                <div class="form-group">
                                                    <label for="days">Стоимость в рублях</label>
                                                    <input type="text" name="regions[{{$k}}][value]"
                                                           class="form-control @error('title') is-invalid @enderror"
                                                           placeholder="Стоимость в руб.">
                                                </div>
                                                <div class="form-group">
                                                    <label for="days">Стоимость в процентах <small>(через точку)</small></label>
                                                    <input type="text" name="regions[{{$k}}][percent]"
                                                           class="form-control @error('title') is-invalid @enderror"
                                                           placeholder="Стоимость в процентах">
                                                </div>
                                                <input type="hidden" name="regions[{{$k}}][status]" value="1">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="title">Регионы не доставки <small>- через точку с запятой</small></label>
                                    <textarea type="text" name="not_regions"
                                           class="form-control" id="not_regions"
                                              placeholder="Пример: п-ов Камчатка;Ленинградская область, Тосно" rows="5"></textarea>
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
