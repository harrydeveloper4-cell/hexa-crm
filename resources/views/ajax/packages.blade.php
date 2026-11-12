<div class="col-md-12">
    <h4>
        Select Package
    </h4>
</div>
@foreach ($packages as $package)
    <div class="col-md-4">
        <input type="checkbox" id="pack{{ $package->id }}" name="packages[]" value="{{ $package->id }}">
        <label for="pack{{ $package->id }}">{{ $package->package_name }}</label>
    </div>
@endforeach
