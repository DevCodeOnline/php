<span>{{ $subject }}:</span><br>
<span>Фамилия: {{ $data['lastname'] }}</span><br>
<span>Имя: {{ $data['firstname'] }}</span><br>
<span>Телефон: {{ $data['phone'] }}</span><br>
<span>E-mail: {{ $data['email'] }}</span><br><br>
@foreach($data['products'] as $product)
<div>
    <span>ИД товара: {{ $product['id'] }}</span><br>
    <span>Наименование: {{ $product['title'] }}</span><br>
    <span>Цена: {{ $product['price'] }} ₽</span><br>
    <span>Кол-во: {{ $product['qnt'] }}</span><br>
    <span>Ссылка на страницу: {{ $product['href'] }}</span><br>
</div><br>
@endforeach
<div>
    <span>Способ оплаты: {{ $payment->title }}</span><br>
    <span>Наценка: {{ $data['price_payment'] }}</span><br>
</div><br>
<div>
    <span>Способ доставки: {{ $delivery->title }}</span><br>
    <span>Наценка: {{ $data['price_delivery'] }}</span><br>
</div><br>
<div>
    <span>Товары: {{ $data['price_product'] }}</span><br>
    <span>Комиссия банка: {{ $data['price_payment'] }}</span><br>
    <span>Доставка: {{ $data['price_delivery'] }}</span><br>
    <span>Итого: {{ $data['price_all'] }}</span><br>
</div><br>
<div>
    <span>Адрес: {{ $data['adress'] }}</span><br>
    <span>Дата: {{ $data['date'] }}</span><br>
    <span>Время: {{ $data['time'] }}</span><br>
</div>
