@extends('admin.layout.master')
@section('title', 'Users')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Edit') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('users') }}">{{ __('Users') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">User Edit</h6>
                    <a class = "btn btn-info float-right" href = "{{ route('users') }}">Back</a>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form action = "{{ route('users.update', ['id' => $user->id]) }}" method = "POST"
                                    id = "create_user">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                            <label>User Type</label>
                                            <select class="form-control rounded" name = "role_id">
                                                <option value = "">Select User Type</option>
                                                @foreach ($roles as $role)
                                                    <option value = "{{ $role->id }}"
                                                        {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->role }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>First Name</label>
                                            <input class="form-control rounded" type="text" name="firstname"
                                                value="{{ $user->firstname ?? '' }}" placeholder="Thomas D">
                                            @error('firstname')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>Last Name</label>
                                            <input class="form-control rounded" type="text" name="lastname"
                                                value="{{ $user->lastname ?? '' }}" placeholder="Hardison">
                                            @error('lastname')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>Email</label>
                                            <input class="form-control rounded" type="email" name="email"
                                                value="{{ $user->email ?? '' }}" placeholder="thomasdhardison@lorem.com">
                                            @error('email')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>Contact Number</label>
                                            <input class="form-control rounded" type="number" name="billing_phonenumber"
                                                value="{{ $user->billing_phonenumber ?? '' }}"
                                                placeholder="123-656-789 (0)">
                                            @error('billing_phonenumber')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                            <label>Address</label>
                                            <input class="form-control rounded" type="text" name="billing_address"
                                                value="{{ $user->billing_address ?? '' }}" placeholder="12345 Lane Street">
                                            @error('billing_address')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 col-lg-6 col-xl-6">
                                            <label>Country</label>
                                            <select id="country" name="country" class="form-control rounded">
                                                @foreach (get_countries() as $country)
                                                    <option value="{{ $country }}"
                                                        {{ $user->country == $country ? 'selected' : '' }}>{{ $country }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>State</label>
                                            <input class="form-control rounded" type="text" name="state"
                                                value="{{ $user->state ?? '' }}" placeholder="State">
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>City</label>
                                            <input class="form-control rounded" type="text" name="city"
                                                value="{{ $user->city ?? '' }}" placeholder="City">
                                        </div>

                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>Zip Code</label>
                                            <input class="form-control rounded" type="text" name="postalcode"
                                                value="{{ $user->postalcode ?? '' }}" placeholder="12345678">
                                        </div>

                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>Password</label>
                                            <input class="form-control rounded" type="password" name="password"
                                                id="password" value="" autocomplete="new-password"
                                                placeholder="Leave blank to keep current password">
                                            @error('password')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>Confirm Password</label>
                                            <input class="form-control rounded" type="password"
                                                name="password_confirmation" id="password_confirmation" value=""
                                                autocomplete="new-password" placeholder="Confirm new password">
                                        </div>

                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                            <!-- <span id = "card-details">
                                                <div class="row">
                                                    <div class="form-group owner col-md-12">
                                                        <label for="owner">Owner</label>
                                                        <input type="text" class="form-control" id="owner"
                                                            name="owner" value="{{ old('owner') }}" required>
                                                        <span id="owner-error" class="error text-red">Please enter owner
                                                            name</span>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="form-group col-md-8" id="card-number-field">
                                                        <label for="cardNumber">Card Number</label>
                                                        <input type="text" class="form-control" id="cardNumber"
                                                            data-card="{{ isset($user_card) ? $user_card->cardNumber : '' }}"
                                                            name="cardNumber" value="{{ old('cardNumber') }}" required>
                                                        <span id="show-cc-label"></span> <span id="card-error"
                                                            class="error text-red">Please enter valid card number</span>
                                                    </div>
                                                    <div class="form-group CVV col-md-4">
                                                        <label for="cvv">CVV</label>
                                                        <input type="text" class="form-control" id="cvv"
                                                            data-cvv="{{ isset($user_card) ? $user_card->cvv : '' }}"
                                                            name="cvv" value="{{ old('cvv') }}" required>
                                                        <span id="cvv-error" class="error text-red">Please enter
                                                            cvv</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6" id="expiration-date">
                                                        <label>Expiration Date</label><br />
                                                        <select class="form-control" id="expiration-month"
                                                            name="expiration-month"
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
                                                        <select class="form-control" id="expiration-year"
                                                            name="expiration-year" style="float: left; width: 100px;">
                                                            @for ($i = date('Y'); $i <= date('Y') + 15; $i++)
                                                                <option @if (isset($user_card) && $user_card != null && $user_card->expiration_month == $i) selected @endif
                                                                    value="{{ $i }}">{{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6" id="credit_cards"
                                                        style="margin-top: 22px;">
                                                        <img src="{{ asset('images/visa.png') }}" id="visa">
                                                        <img src="{{ asset('images/mastercard.png') }}" id="mastercard">
                                                        <img src="{{ asset('images/amex.jpg') }}" id="amex"
                                                            width="40" height="25">
                                                    </div>
                                                </div>
                                            </span> -->
                                            <span id = "user_brand">
                                                @if ($brands)
                                                    <div class = "row">
                                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                                            <label for="brand_id">User Brands</label>
                                                            <select id="brand_id" multiple name="brand_id[]"
                                                                class="form-control rounded">
                                                                @foreach ($brands as $brand)
                                                                    <option @if (in_array($brand->id, $user->brand->pluck('id')->toArray())) selected @endif
                                                                        value="{{ $brand->id }}">
                                                                        {{ $brand->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endif
                                            </span>
                                        </div>

                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                            <button class = "btn btn-primary" type="submit">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        $('#create_user').validate({
            rules: {
                role_id: 'required',
                firstname: 'required',
                lastname: 'required',
                email: 'required',
                billing_phonenumber: 'required',
                billing_address: 'required',
                state: 'required',
                city: 'required',
                postalcode: 'required',
                country: 'required',
                password: {
                    minlength: 8
                },
                password_confirmation: {
                    equalTo: '#password'
                }
            }
        });
    </script>
@endsection
