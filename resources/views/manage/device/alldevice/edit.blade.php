@extends('layout.main')

@section('content')
<div class="container-fluid py-4">
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
            @if ($errors->any())
            <pt-3>
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $item)
                    <li>{{$item}}</li>
                @endforeach
                </ul>
            </div>
            </pt-3>
            @endif
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
                                    <input type="text" class="form-control" name="device_name" value="{{$edit_device->device_name}}" placeholder="Device Name" aria-label="Name" aria-describedby="name-addon">
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
                                    <input id="macAddressInput" type="text" class="form-control" name="mac_address" value="{{$edit_device->mac_address}}" placeholder="Mac Address" readonly>
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
                            <button type="submit" name="submit" class="btn btn-success btn-lg btn-rounded w-100 mt-4 mb-0">Set Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ url('\assets\js\main.js') }}"></script>
@endsection