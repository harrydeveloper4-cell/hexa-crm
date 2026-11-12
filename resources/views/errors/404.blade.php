@extends('master')
@section('css')
@endsection
@section('content')
    <div class="container">
        <div class="row vh-100 justify-content-between align-items-center">
            <div class="col-12">
                <div class="lockscreen  mt-5 mb-5">
                    <div class="jumbotron mb-0 text-center theme-background rounded">
                        <h1 class="display-3 font-weight-bold"> 404</h1>
                        <h5><i class="ion ion-alert pr-2"></i>Oops! Something went wrong</h5>
                        <p>{{$message ?? ''}}</p>
                        {{-- <p>The page you are looking for is not found</p> --}}
                        <a href="#" class="btn btn-primary">Contact Support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
