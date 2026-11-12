@extends('admin.layout.master')
@section('title', 'Users')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{isset($user->firstname) ? ucfirst($user->firstname) : 'User'}} {{isset($user->lastname) ? ucfirst($user->lastname) : ''}}</h3>
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item active">Users</li> --}}
@endsection
{{-- @dd($role) --}}
@section('content')
    <div class="row">
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">                               
                    <h4 class="card-title">Personel Details</h4> 
                </div>
                <div class="card-body">
                    <dl class="row mb-0 redial-line-height-2_5">
                        <dt class="col-sm-5">First Name:</dt>
                        <dd class="col-sm-7">{{ $user->firstname ?? '' }}</dd>

                        <dt class="col-sm-5">Last Name:</dt>
                        <dd class="col-sm-7">{{ $user->lastname ?? '' }}</dd>

                        <dt class="col-sm-5">Billing Address:</dt>
                        <dd class="col-sm-7">{{ $user->billing_address ?? '' }}</dd>

                        <dt class="col-sm-5">Country:</dt>
                        <dd class="col-sm-7">{{ $user->country ?? '' }}</dd>

                        <dt class="col-sm-5">State:</dt>
                        <dd class="col-sm-7">{{ $user->state ?? '' }}</dd>

                        <dt class="col-sm-5">City:</dt>
                        <dd class="col-sm-7">{{ $user->city ?? '' }}</dd>

                        <dt class="col-sm-5">Postal Code:</dt>
                        <dd class="col-sm-7">{{ $user->postalcode ?? '' }}</dd>

                        <dt class="col-sm-5">Billing Phone Number:</dt>
                        <dd class="col-sm-7">{{ $user->billing_phonenumber ?? '' }}</dd>

                        <dt class="col-sm-5">Role:</dt>
                        <dd class="col-sm-7"><span class="badge badge-primary text-white">{{ $role->role ?? '' }}</span></dd> 
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">                               
                    <h4 class="card-title">Card Details</h4> 
                </div>
                <div class="card-body">
                    <dl class="row mb-0 redial-line-height-2_5">
                        <dt class="col-sm-5">Owner :</dt>
                        <dd class="col-sm-7">{{$user_card->owner ?? ''}}</dd>
                        
                        <dt class="col-sm-5">Card Number :</dt>
                        <dd class="col-sm-7">{{$user_card->cardNumber ?? ''}}</dd>

                        <dt class="col-sm-5">CVV :</dt>
                        <dd class="col-sm-7">{{$user_card->cvv ?? ''}}</dd>

                        <dt class="col-sm-5">Expiration Month :</dt>
                        <dd class="col-sm-7">{{$user_card->expiration_month ?? ''}}</dd>

                        <dt class="col-sm-5">Expiration Year :</dt>
                        <dd class="col-sm-7">{{$user_card->expiration_year ?? ''}}</dd>

                        <dt class="col-sm-5">Email :</dt>
                        <dd class="col-sm-7">{{$user_card->customer_email ?? ''}}</dd>

                        <dt class="col-sm-5">Merchant :</dt>
                        <dd class="col-sm-7">{{$user_card->merchant ?? ''}}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection