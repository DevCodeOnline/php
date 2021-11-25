@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Данные сайта</h1>
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
                        <form role="form" method="post" action="{{ route('informations.update', ['information' => 1]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="image">Favicon</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="favicon" type="file" class="custom-file-input" id="favicon">
                                            <label class="custom-file-label" for="favicon">Изменить изображение</label>
                                        </div>
                                    </div>
                                    <div ><img style="width: 25px;margin-top:10px;border: 1px solid #ddd;padding: 5px;" src="{{ asset("uploads/data/$favicon->image") }}" alt="Favicon"></div>
                                </div>
                                <div class="form-group">
                                    <label for="image">Логотип</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="logo" type="file" class="custom-file-input" id="logo">
                                            <label class="custom-file-label" for="logo">Изменить изображение</label>
                                        </div>
                                    </div>
                                    <div ><img style="width: 127px;margin-top:10px;border: 1px solid #ddd;padding: 5px;" src="{{ asset("uploads/data/$logo->image") }}" alt="Logotip"></div>
                                </div>
                                <div class="form-group">
                                    <label for="image">Изображение на странице «О нас»</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="about_image" type="file" class="custom-file-input" id="about_image">
                                            <label class="custom-file-label" for="about_image">Изменить изображение</label>
                                        </div>
                                    </div>
                                    <div ><img style="width: 127px;margin-top:10px;border: 1px solid #ddd;padding: 5px;" src="{{ asset("uploads/data/$about->image") }}" alt="О нас"></div>
                                </div>
                                <div class="form-group">
                                    <label for="about_content">Контент на странице «О нас»</label>
                                    <textarea type="text" name="about_content"
                                           class="form-control @error('about_content') is-invalid @enderror" id="about_content" rows="5">{{ $about->content }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="contact_content">Контент на странице «Контакты»</label>
                                    <textarea type="text" name="contact_content"
                                              class="form-control @error('contact_content') is-invalid @enderror" id="contact_content" rows="5">{{ $contact->content }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="payment_content">Контент на странице «Оплата и доставка»</label>
                                    <textarea type="text" name="payment_content"
                                              class="form-control @error('payment_content') is-invalid @enderror" id="payment_content" rows="5">{{ $payment->content }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="footer_content">Контент блока «Подвал»</label>
                                    <textarea type="text" name="footer_content"
                                              class="form-control @error('footer_content') is-invalid @enderror" id="footer_content" rows="5">{{ $footer->content }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="api_content">Ключ «API»</label>
                                    <input type="text" name="api_content"
                                              class="form-control @error('api_content') is-invalid @enderror" id="api_content" value="{{ $api->content }}">
                                </div>
                                <div class="form-group">
                                    <label for="email_login">Email-логин</label>
                                    <input type="text" name="email_login"
                                           class="form-control @error('email_login') is-invalid @enderror" id="email_login" value="{{ $login->content }}">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Сохранить данные</button>
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

