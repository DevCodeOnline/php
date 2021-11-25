@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Редактирование пользователя</h1>
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
                            <h3 class="card-title">Редактирование - {{ $user->name }}</h3>
                        </div>
                        <!-- /.card-header -->

                        <form role="form" method="post" action="{{ route('users.update', ['user' => $user->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Имя</label>
                                    <input type="text" name="name"
                                           class="form-control @error('title') is-invalid @enderror" id="title"
                                           placeholder="Имя" value="{{ $user->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input name="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" id="email" value="{{ $user->email }}">
                                </div>
                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror" id="password"
                                           placeholder="Введите новый пароль, иначе оставьте поле пустым">
                                </div>
                                <div class="form-group">
                                    <label>Роль</label>
                                    <select class="form-control" name="role" id="role" data-placeholder="Выберите роль" autocomplete="off">
                                        <option value="1" @if($user->role) selected @endif>Администратор</option>
                                        <option value="0" @if(!$user->role) selected @endif>Редактор</option>
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
