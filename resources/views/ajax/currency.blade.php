@php
    $currencies = json_decode($brand->currency);
@endphp

@foreach ($currencies as $currency)
    <option value="{{ $currency }}"> {{ $currency }}</option>
@endforeach
