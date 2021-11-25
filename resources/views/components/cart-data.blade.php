<div class="cart-form__group cart-forms__data">
    <div class="cart-forms__data">
        <label for="data"><span>Дата</span> <span class="required">*</span></label>
        <input type="data" name="data" required="required" id="datepicker" autocomplete="off" class="date" data-days="{{ $days }}" data-price="{{ $price }}">
    </div>
    <div class="cart-forms__data">
        <label for="time"><span>Время</span></label>
        <input type="text" name="time" required="required" id="timepicker" autocomplete="off" class="time">
    </div>
</div>
<script>
    function updateCartData() {
        updateData({{ $days }});
        delivery({{ $price }});
        updateTime();
    }
</script>
