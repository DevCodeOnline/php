<div class="cart-way">
    <h3>Укажите реквизиты</h3>
    <div class="cart-choice">
        <div class="cart-form">
            <form action="{{ route('order') }}" method="POST">
            @csrf
            <div class="cart-form__group">
                <label for="lastname"><span>Фамилия</span> <span class="required">*</span></label>
                <input type="text" name="lastname" required="required" class="lastname">
            </div>
            <div class="cart-form__group">
                <label for="firstname"><span>Имя</span> <span class="required">*</span></label>
                <input type="text" name="firstname" required="required" class="firstname">
            </div>
            <div class="cart-form__group">
                <label for="phone"><span>Телефон</span> <span class="required">*</span></label>
                <input type="tel" name="phone" required="required" class="phone">
            </div>
            <div class="cart-form__group">
                <label for="email"><span>E-mail</span></label>
                <input type="email" name="email" class="email">
            </div>
            <div class="cart-form__group cart-form__adress ymaps-2-1-78-searchbox-input">
                <label for="address"><span>Адрес</span> <span class="required">*</span><span class="form-error"></span></label>
                <textarea type="text" name="address" id="address" required="required" class="adress" autocomplete="off"></textarea>
            </div>
                <div class="cart-data">
                    <x-cart-data/>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="cart-maps">
    <div id="map" style="width: 100%; height: 400px"></div>
</div>

{{--Работа с api yandex map--}}
<script type="text/javascript">

    var myMap;
    var placemarkCollections = {};
    var placemarkList = {};

    ymaps.ready(init);
    function init() {
        var myPlacemark;
        // Создание карты.
        myMap = new ymaps.Map("map", {
            center: [59.93, 30.31],
            zoom: 11,
            controls: []
        }, {
            // Будет производиться поиск по топонимам и организациям.
            searchControlProvider: 'yandex#map',
            noPlacemark: true,
        });

        const objectManager = new ymaps.ObjectManager({
            clusterize: true
        });

        // Слушаем клик на карте.
        myMap.events.add('click', function (e) {
            var coords = e.get('coords');

            // Если метка уже создана – просто передвигаем ее.
            if (myPlacemark) {
                myPlacemark.geometry.setCoordinates(coords);
            }

            // Если нет – создаем.
            else {
                myPlacemark = createPlacemark(coords);
                myMap.geoObjects.add(myPlacemark);
                // Слушаем событие окончания перетаскивания на метке.
                myPlacemark.events.add('dragend', function () {
                    getAddress(myPlacemark.geometry.getCoordinates());
                });
            }
            getAddress(coords);
        });

        var selectValue;

        var suggestView = new ymaps.SuggestView(
            'address', // ID input'а
            {
                offset: [-2, 3], // Отступы панели подсказок от её положения по умолчанию. Задаётся в виде смещений по горизонтали и вертикали относительно левого нижнего угла элемента input.
                results: 5, // Максимальное количество показываемых подсказок.
            });

        suggestView.events.add("select", function(e){
            selectValue = e.get('item').value;
            $('.cart-form__adress .adress').val(selectValue);
            updateeAdress(e.get('item').value);
            searchControl.search(e.get('item').value);
        });



        $('.cart-form__adress').on('change', '.adress', function (e) {
            var _this = $(this);

            setTimeout(function(){
                var value = _this.val();

                if (value !== selectValue)
                    updateeAdress(value);
            }, 1000);

        });

        // Создание метки.
        function createPlacemark(coords) {
            return new ymaps.Placemark(coords, {
                iconCaption: 'поиск...',
            }, {
                preset: 'islands#violetDotIconWithCaption',
                draggable: true,
            });
        }



        // Определяем адрес по координатам (обратное геокодирование).
        function getAddress(coords) {
            myPlacemark.properties.set('iconCaption', 'поиск...');
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);

                myPlacemark.properties
                    .set({
                        // Формируем строку с данными об объекте.
                        iconCaption: [
                            // Название населенного пункта или вышестоящее административно-территориальное образование.
                            firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                            // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                            firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                        ],
                    });
                // Добавляем адрес в поле по клику на карту
                $('.cart-form__adress textarea').val('');
                $('.cart-form__adress textarea').val(firstGeoObject.getAddressLine());
                $('.cart-form__adress .adress').trigger("change");
            });
        }

        var searchControl = new ymaps.control.SearchControl({
            options: {
                // Будет производиться поиск и по топонимам, и по организациям.
                provider: 'yandex#search',
                noPlacemark: true,
            }
        });


        // Переключение города
        $('.adress').change(function () {
            myMap.controls.add(searchControl);
            searchControl.search($('.adress').val());
        });
    }
</script>
