@extends('admin.layout.master')
@section('title', 'Contact Inquiry')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Detail') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="#">{{ __('Contact Inquiry') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Detail') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Contact Inquiry Detail</h6>
                    <a class = "btn btn-info btn-xs float-right" href = "{{ route('admin.contact.inquiry') }}">Back</a>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Name</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Name" value = "{{ $inquiry->inquiries_name ?? '--' }}"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Email</label>
                                            <input type="text" class="form-control rounded" id="inputEmail4"
                                                placeholder="Email" value = "{{ $inquiry->inquiries_email ?? '--' }}"
                                                readonly>
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail4">Message</label>
                                            <textarea class="form-control" readonly>{{ $inquiry->extra_content ?? '' }}</textarea>
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
