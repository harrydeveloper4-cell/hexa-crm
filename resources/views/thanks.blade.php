@extends('master')
@section('css')
<style>
  .bg-light {
    background-color: #f8f9fa !important;
  }

  .shadow-lg {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .btn-primary {
    background-color: #007bff;
    border: none;
  }

  .btn-primary:hover {
    background-color: #0056b3;
  }

  .bi-check-circle {
    color: #28a745;
  }
</style>
@endsection
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center bg-light p-5 rounded shadow-lg">
                <div class="mb-4">
                    <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h1 class="display-4 text-primary mb-3">Thank You!</h1>
                <p class="lead mb-4">Your order with ID <strong>#{{ $oi ?? '' }}</strong> has been successfully placed.</p>
                <p class="lead mb-4">Please check your email for further instructions on how to process your order.</p>
                {{-- <hr class="my-4">
                <a class="btn btn-primary btn-lg" href="{{ url('/') }}" role="button">
                    <i class="bi bi-house-door"></i> Back to Home
                </a> --}}
            </div>
        </div>
    </div>
</div>
@endsection