@extends('admin.layout.master')
@section('title', 'Users')

@section('css')
<style>
    #create_user .error{
        color: red;
    }
</style>
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Create') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('users') }}">{{ __('Users') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">User Create</h6>
                    <a class = "btn btn-info float-right" href = "{{ route('users') }}">Back</a>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form action = "{{ route('users.store') }}" method = "POST" id = "create_user">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                            <label>User Type</label>
                                            <select class="form-control rounded" id = "role_id" name = "role_id">
                                                <option value = "">Select User Type</option>
                                                @foreach ($roles as $role)
                                                    <option value = "{{ $role->id }}">{{ $role->role }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>First Name</label>
                                            <input class="form-control rounded" type="text" name="firstname"
                                                value="{{ old('firstname') }}" placeholder="Thomas D">
                                            @error('firstname')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>Last Name</label>
                                            <input class="form-control rounded" type="text" name="lastname"
                                                value="{{ old('lastname') }}" placeholder="Hardison">
                                            @error('lastname')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>Email</label>
                                            <input class="form-control rounded" type="email" name="email"
                                                value="{{ old('email') }}" placeholder="thomasdhardison@lorem.com">
                                            @error('email')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>Contact Number</label>
                                            <input class="form-control rounded" type="number" name="billing_phonenumber"
                                                value="{{ old('billing_phonenumber') }}" placeholder="123-656-789 (0)">
                                            @error('billing_phonenumber')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                            <label>Address</label>
                                            <input class="form-control rounded" type="text" name="billing_address"
                                                value="{{ old('billing_address') }}" placeholder="12345 Lane Street">
                                            @error('billing_address')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 col-lg-6 col-xl-6">
                                            <label>Country</label>
                                            <select id="country" name="country" class="form-control rounded">
                                                @foreach (get_countries() as $country)
                                                    <option value="{{ $country }}">{{ $country }}
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
                                                value="{{ old('state') }}" placeholder="State">
                                            @error('state')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>City</label>
                                            <input class="form-control rounded" type="text" name="city"
                                                value="{{ old('city') }}" placeholder="City">
                                            @error('city')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <label>Zip Code</label>
                                            <input class="form-control rounded" type="text" name="postalcode"
                                                value="{{ old('postalcode') }}" placeholder="12345678">
                                            @error('postalcode')
                                                <span class = "error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <span id = "card-details"></span>
                                    <span id = "user_brand">
                                        @if ($brands)
                                            <div class = "row">
                                                <div class="col-md-12 col-lg-12 col-xl-12">
                                                    <label for="brand_id">User Brands</label>
                                                    <select id="brand_id" multiple name="brand_id[]"
                                                        class="form-control rounded">
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}">
                                                                {{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                        @endif
                                    </span>
                                    <div class = "row">
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

    @php
        $fields = view('admin.users.card-details')->render();
    @endphp
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#user_brand").hide()
        })

        let fields = {!! json_encode($fields) !!};
        $(document).ready(function(){
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
                },
                messages:{
                    firstname : {
                        required: "This Feild is Required"
                    }
                },
                errorPlacement: function(error, element){
                    error.addClass('error');
                    error.insertAfter(element);
                }
            });
        });

        $(document).on('change', '#role_id', function () {
            // if ($(this).val() == {{ client_role_id() }}) {
            //     $('#card-details').html(fields)
            //     $('#user_brand').hide()

            //     // Wait for the DOM to update
            //     setTimeout(() => {
            //         let ccNumberInput = document.querySelector('#cardNumber');
            //         if (!ccNumberInput) return;

            //         let ccNumberPattern = /^\d{0,16}$/g,
            //             ccNumberSeparator = " ",
            //             ccNumberInputOldValue,
            //             ccNumberInputOldCursor,

            //             ccCVCInput = document.querySelector('#cvv'),
            //             ccCVCPattern = /^\d{0,3}$/g,

            //             mask = (value, limit, separator) => {
            //                 var output = [];
            //                 for (let i = 0; i < value.length; i++) {
            //                     if (i !== 0 && i % limit === 0) {
            //                         output.push(separator);
            //                     }
            //                     output.push(value[i]);
            //                 }
            //                 return output.join("");
            //             },
            //             unmask = (value) => value.replace(/[^\d]/g, ''),
            //             checkSeparator = (position, interval) => Math.floor(position / (interval + 1)),
            //             ccNumberInputKeyDownHandler = (e) => {
            //                 let el = e.target;
            //                 ccNumberInputOldValue = el.value;
            //                 ccNumberInputOldCursor = el.selectionEnd;
            //             },
            //             ccNumberInputInputHandler = (e) => {
            //                 let el = e.target,
            //                     newValue = unmask(el.value),
            //                     newCursorPosition;

            //                 if (newValue.match(ccNumberPattern)) {
            //                     newValue = mask(newValue, 4, ccNumberSeparator);

            //                     newCursorPosition =
            //                         ccNumberInputOldCursor - checkSeparator(ccNumberInputOldCursor, 4) +
            //                         checkSeparator(ccNumberInputOldCursor + (newValue.length - ccNumberInputOldValue.length), 4) +
            //                         (unmask(newValue).length - unmask(ccNumberInputOldValue).length);

            //                     el.value = (newValue !== "") ? newValue : "";
            //                 } else {
            //                     el.value = ccNumberInputOldValue;
            //                     newCursorPosition = ccNumberInputOldCursor;
            //                 }

            //                 el.setSelectionRange(newCursorPosition, newCursorPosition);
            //                 highlightCC(el.value);
            //             },
            //             highlightCC = (ccValue) => {
            //                 let ccCardType = '',
            //                     ccCardTypePatterns = {
            //                         amex: /^3/,
            //                         visa: /^4/,
            //                         mastercard: /^5/,
            //                         disc: /^6/,
            //                         genric: /(^1|^2|^7|^8|^9|^0)/,
            //                     };

            //                 for (const cardType in ccCardTypePatterns) {
            //                     if (ccCardTypePatterns[cardType].test(ccValue)) {
            //                         ccCardType = cardType;
            //                         break;
            //                     }
            //                 }

            //                 let activeCC = document.querySelector('.cc-types__img--active'),
            //                     newActiveCC = document.querySelector(`.cc-types__img--${ccCardType}`);

            //                 if (activeCC) activeCC.classList.remove('cc-types__img--active');
            //                 if (newActiveCC) newActiveCC.classList.add('cc-types__img--active');
            //             }

            //         // Attach events safely
            //         ccNumberInput.addEventListener('keydown', ccNumberInputKeyDownHandler);
            //         ccNumberInput.addEventListener('input', ccNumberInputInputHandler);
            //     }, 100); // delay for DOM update
            // } else {
                // $('#card-details').html('')
                $('#user_brand').show()
            // }
        });
    </script>
@endsection
