@extends('master')
@section('css')
@endsection
{{-- @dd($order) --}}
@section('content')
    <div class="container">
        <div class="row vh-100 justify-content-between align-items-center">
            <div class="col-12">
                <div class="lockscreen mt-5 mb-5">
                    <div class="jumbotron mb-0 text-center theme-background rounded">
                        <h1 class="display-3 font-weight-bold">500</h1>
                        <h5><i class="ion ion-alert pr-2"></i>Oops! Something went wrong</h5>
                        <p>{{$message ?? ''}}</p>
                        {{-- <h5><i class="ion ion-alert pr-2"></i>Oops! Link Expired</h5> --}}
                        {{-- <p>The link you used is no longer valid. If you believe this is an error, please contact support.</p> --}}
                        <a href="#" class="btn btn-primary">Contact Support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
