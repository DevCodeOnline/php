@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Способы оплаты</h1>
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
                            <h3 class="card-title">Способы оплаты</h3>
                        </div>
                        <form role="form" method="post" action="{{ route('admin.calc') }}">
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
                            <a href="{{ route('payments.create') }}" class="btn btn-primary mb-3">Добавить
                                способ оплаты</a>
                            @if (count($payments))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>Наименование</th>
                                            <th>Способы доставки</th>
                                            <th style="width: 150px">Статус</th>
                                            <th style="width: 120px">Действие</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($payments as $payment)
                                            <tr>
                                                <td>{{ $payment->title }}</td>
                                                <td>{{ $payment->delivery->pluck('title')->join(', ') }}</td>
                                                <td>{{ $payment->status ? 'Включен' : 'Отключен' }}</td>
                                                <td>
                                                    <a href="{{ route('payments.edit', ['payment' => $payment->id]) }}"
                                                       class="btn btn-info btn-sm float-left mr-1">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>

                                                    <form
                                                        action="{{ route('payments.destroy', ['payment' => $payment->id]) }}"
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
                                <p>Категорий пока нет...</p>
                            @endif
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $payments->links('pagination::bootstrap-4') }}
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

