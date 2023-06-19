@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="top-title">
                <h2 class="">Edit Device</h2>
                <p>Have a nice day</p>
            </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-lg-4">
            <a href="/alldevice" class="kanan btn btn-primary mt-3">
                <i class="fa-solid fa-arrow-left"></i>&nbsp Back
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex align-items-center">
                <p class="mb-0">Edit Device</p>
            </div>
        </div>
        <div class="card-body col-lg-12">
            <div class="row mt-4">
                <div class="col-lg-7">
                    <form action='{{url('manage-device/'. $edit_device->device_id)}}' method='post' role="form text-left">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Device Name</label>
                                    <input type="text" name="device_name" class="form-control @if($errors->has('device_name') || old('device_name') === '') is-invalid @elseif($errors->any()) is-valid @endif" value="{{$edit_device->device_name}}" required>
                                    @if($errors->has('device_name') || old('device_name') === '')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('device_name') ?? 'The device name field is required.' }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="example-text-input" class="form-control-label">Mac Address</label>
                                    </div>
                                    <input type="text" name="mac_address" class="form-control @if($errors->has('mac_address') || old('mac_address') === '') is-invalid @elseif($errors->any()) is-valid @endif" value="{{$edit_device->mac_address}}" required>
                                    @if($errors->has('mac_address') || old('mac_address') === '')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mac_address') ?? 'The mac address field is required.' }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="d-flex justify-content-center btn btn-secondary btn-md btn-rounded mt-4 mb-0" id="triggerButton">
                                    Set
                                </a>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <div class="text-center">
                            <a href="#" class="d-flex justify-content-center btn btn-success btn-md btn-rounded mt-4 mb-0 edit-button" data-device-id="{{ $edit_device->device_id }}">
                                Set
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ url('\assets\js\main.js') }}"></script>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-button');
        editButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const deviceId = button.getAttribute('data-device-id');
                const editForm = document.querySelector('form[action="' + window.location.origin + '/manage-device/' + deviceId + '"]');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to edit the device',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, edit it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then(function (result) {
                    if (result.isConfirmed) {
                        editForm.submit();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire('Cancelled', 'Device edit cancelled', 'info');
                    }
                });
            });
        });
    });
</script>
