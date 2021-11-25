@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Создание пользователя</h1>
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
                            <h3 class="card-title">Создание пользователя</h3>
                        </div>
                        <!-- /.card-header -->

                        <form role="form" method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Имя</label>
                                    <input type="text" name="name"
                                           class="form-control @error('title') is-invalid @enderror" id="title"
                                           placeholder="Имя">
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input name="email" class="form-control @error('email') is-invalid @enderror" rows="3" placeholder="E-mail" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input type="text" name="password"
                                           class="form-control @error('password') is-invalid @enderror" id="password"
                                           placeholder="Пароль">
                                </div>
                                <div class="form-group">
                                    <label>Роль</label>
                                    <select class="form-control" name="role" id="role" data-placeholder="Выберите роль" autocomplete="off">
                                        <option value="1">Администратор</option>
                                        <option value="0" selected>Редактор</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Добавить пользователя</button>
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
