@foreach ($merchants as $merchant)
    <div class="form-group col-md-3">
        <input id="radio{{ $merchant->id }}" type="radio" name="payment_gateway" value="{{ $merchant->id }}"  {{ old('payment_gateway') == $merchant->id ? 'checked' : '' }} >
        @if ($merchant->id == 1)
            <label for="radio{{ $merchant->id }}"><img src="{{ asset('images/paypal.png') }}"></label>
        @elseif($merchant->id == 2)
            <label for="radio{{ $merchant->id }}"><img src="{{ asset('images/stripe.png') }}"></label>
        @elseif($merchant->id == 3)
            <label for="radio{{ $merchant->id }}"><img src="{{ asset('images/square1.png') }}"></label>
        @elseif($merchant->id == 4)
            <label for="radio{{ $merchant->id }}"><img src="{{ asset('images/authorize1.png') }}"></label>
        @elseif($merchant->id == 5)
            <label for="radio{{ $merchant->id }}"><img src="{{ asset('images/rapyd.png') }}"></label>
        @elseif($merchant->id == 6)
            <label for="radio{{ $merchant->id }}"><img src="{{ asset('images/chase.png') }}"></label>
        @endif
    </div>
@endforeach
