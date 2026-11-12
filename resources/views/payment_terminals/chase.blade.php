@extends('payment_terminals.layout.app')
@section('title', 'Chase')

@section('meta')
    <link href="{{ asset('css/merchant/normalize.css') }}">
    <link href="{{ asset('css/merchant/paymentInfo.css') }}">
@endsection

@section('css')
@endsection

@section('content')
    <div class="form-group" id="pay-now">
        <div class="form-row row">
            <div class="col-xs-12 form-group required"><label class="control-label">Name on Card</label> <input required
                    class="form-control" size="4" type="text" name="card_holder_name" /></div>
        </div>
        <div class="form-row row">
            <div class="col-xs-12 form-group required"><label class="control-label">Card Number</label> <input required
                    autocomplete="off" class="form-control card-number" name="card_number" size="20" type="text" />
            </div>
        </div>
        <div class="form-row row">
            <div class="col-xs-12 col-md-4 form-group cvc required"><label class="control-label">CVC</label> <input required
                    autocomplete="off" class="form-control card-cvc" name="cvv_number" placeholder="ex. 311" size="4"
                    type="text" /></div>
            <div class="col-xs-12 col-md-4 form-group expiration required">
                <label class="control-label">Expiration Month</label>

                <select class="form-control card-expiry-month" name="exp_month" required>
                    <option value="01">January</option>

                    <option value="02">February </option>

                    <option value="03">March</option>

                    <option value="04">April</option>

                    <option value="05">May</option>

                    <option value="06">June</option>

                    <option value="07">July</option>

                    <option value="08">August</option>

                    <option value="09">September</option>

                    <option value="10">October</option>

                    <option value="11">November</option>

                    <option value="12">December</option>
                </select>
                {{-- <input class="form-control card-expiry-month" placeholder="MM" size="2" type="text" /> --}}
            </div>

            <div class="col-xs-12 col-md-4 form-group expiration required">
                <label class="control-label">Expiration Year</label>
                {{-- <input class="form-control card-expiry-year" placeholder="YYYY" size="4" type="text" /> --}}
                <select class="form-control card-expiry-year" name="exp_year" required>
                    @php
                        $year = date('Y');
                        $limit = 10 + $year;
                    @endphp @for ($i = $year; $i < $limit; $i++)
                        <option value="{{ substr($i, -2) }}">{{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="form-row row">
            <button type="submit" class="btn btn-success themeButton mt-5" id="pay-chase">Pay with Chase</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
@endsection
