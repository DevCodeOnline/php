@foreach($deliveries as $key => $value)
    <div class="cart-choice__option">
        @foreach($value->region as $k => $v)
            @if($k == 0)
                <input type="radio" data-price="@if($calcDelivery && $v->pivot->value) {{$v->pivot->value}} @elseif($calcDelivery && !$v->pivot->value) 0 @elseif(!$calcDelivery && $v->pivot->percent) {{$v->pivot->percent}} @elseif(!$calcDelivery && !$v->pivot->percent) 0 @endif" name="delivery" id="pick-up" value="{{ $value->id }}"  @if($key == 0 && $value->status) checked @endif @if(!$value->status) disabled="disabled" @endif>
            @endif
        @endforeach
        <label for="pick-up">{{ $value->title }}</label>
    </div>
@endforeach

