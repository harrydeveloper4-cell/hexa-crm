@extends('admin.layout.master')
@section('title', 'Assignments')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Detail') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="#">{{ __('Assignments') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Detail') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Assignment Inquiry Detail</h6>
                    <a class = "btn btn-info btn-xs float-right" href = "{{ route('assignment_inquiry') }}">Back</a>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail4">Name</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Name" value = "{{ $assignment->name ?? '--' }}" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Email</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Email" value = "{{ $assignment->email ?? '--' }}" readonly>
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Phone Number</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Phone" value = "{{ $assignment->phonenumber ?? '--' }}"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Vin NUmber</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Vin Number" value = "{{ $assignment->vin_number ?? '--' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Package</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Phone" value = "{{ $package->name ?? '--' }}" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Payment Method</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Vin Number" value = "{{ $assignment->payment_method ?? '--' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Amount</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Phone" value = "{{ $assignment->amount ?? '--' }}"readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Paid Amount</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Vin Number" value = "{{ $assignment->paid_amount ?? '--' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Payment ID</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Phone" value = "{{ $assignment->payment_id ?? '--' }}"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Payer ID</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Vin Number" value = "{{ $assignment->payer_id ?? '--' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Payment Status</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Phone"
                                                value = "{{ $assignment->status == 'None' ? 'Unpaid' : 'Paid' }}" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Delivery Status</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Vin Number"
                                                value = "{{ $assignment->delivery_status ?? '--' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail4">Inquiry Date</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Inquiry Date"
                                                value = "{{ $assignment->updated_at ?? '--' }}" readonly>
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
@endsection
