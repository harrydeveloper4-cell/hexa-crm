<div class="row">
    <div class="form-group owner col-md-12">
        <label for="owner">Owner</label>
        <input type="text" class="form-control" id="owner" name="owner" value="{{ old('owner') }}" required>
        <span id="owner-error" class="error text-red">Please enter owner name</span>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-8" id="card-number-field">
        <label for="cardNumber">Card Number</label>
        <input type="text" class="form-control" id="cardNumber" name="cardNumber" value="{{ old('cardNumber') }}"
            required>
        <span id="show-cc-label"></span>
        <span id="card-error" class="error text-red">Please enter valid card number</span>
    </div>
    <div class="form-group CVV col-md-4">
        <label for="cvv">CVV</label>
        <input type="text" class="form-control" id="cvv" name="cvv" value="{{ old('cvv') }}" required>
        <span id="cvv-error" class="error text-red">Please enter cvv</span>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6" id="expiration-date">
        <label>Expiration Date</label><br />
        <select class="form-control" id="expiration-month" name="expiration-month"
            style="float: left; width: 100px; margin-right: 10px;">
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
        <select class="form-control" id="expiration-year" name="expiration-year" style="float: left; width: 100px;">
            @for ($i = date('Y'); $i <= date('Y') + 15; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>
    <div class="form-group col-md-6" id="credit_cards" style="margin-top: 22px;">
        <img src="{{ asset('images/visa.png') }}" id="visa">
        <img src="{{ asset('images/mastercard.png') }}" id="mastercard">
        <img src="{{ asset('images/amex.jpg') }}" id="amex" width="40" height="25">
    </div>
</div>
