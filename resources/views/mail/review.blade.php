<span>Написан отзыв о товаре:</span><br>
<span>Фамилия: {{ $data['lastname'] }}</span><br>
<span>Имя: {{ $data['firstname'] }}</span><br>
<span>Телефон: {{ $data['phone'] }}</span><br>
<span>E-mail: {{ $data['email'] }}</span><br><br>
<div>
    <span>ИД товара: {{ $product->id }}</span><br>
    <span>Наименование: {{ $product->title }}</span><br>
    <span>Ссылка на страницу: {{ route('product', ['slug' => $product->slug]) }}</span><br>
</div><br>
<div>
    <span>Отзыв:</span><br>
    <span>{{ $data['comment'] }}</span>
</div>
