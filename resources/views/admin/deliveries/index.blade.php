@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Способы доставки</h1>
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
                            <h3 class="card-title">Способы доставки</h3>
                        </div>
                        <form role="form" method="post" action="{{ route('admin.calc.delivery') }}">
                            @csrf
                            <div class="card-body">
                                <label>Рассчет в рублях или процентах?</label>
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <select name="calc" id="calc" class="form-control">
                                                <option value="1" @if($calc == 1) selected @endif>Рубли</option>
                                                <option value="0" @if($calc == 0) selected @endif>Проценты</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button type="submit" class="btn btn-primary">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <a href="{{ route('deliveries.create') }}" class="btn btn-primary mb-3">Добавить
                                способ доставки</a>
                            @if (count($deliveries))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>Наименование</th>
                                            <th>Регионы</th>
                                            <th style="width: 150px">Статус</th>
                                            <th style="width: 120px">Действие</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($deliveries as $delivery)
                                            <tr>
                                                <td>{{ $delivery->title }}</td>
                                                <td>{{ $delivery->region->pluck('title')->join(', ') }}</td>
                                                <td>{{ $delivery->status ? 'Включен' : 'Отключен' }}</td>
                                                <td>
                                                    <a href="{{ route('deliveries.edit', ['delivery' => $delivery->id]) }}"
                                                       class="btn btn-info btn-sm float-left mr-1">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>

                                                    <form
                                                        action="{{ route('deliveries.destroy', ['delivery' => $delivery->id]) }}"
                                                        method="post" class="float-left">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Подтвердите удаление')">
                                                            <i
                                                                class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>Способов доставки пока нет...</p>
                            @endif
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $deliveries->links('pagination::bootstrap-4') }}
                        </div>
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

