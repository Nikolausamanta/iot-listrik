@extends('layout.main')

@section('content')
<div class="container-fluid py-4">
    @if (Session::has('success'))
        <div class="pt-3">
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        </div>
    @endif
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="top-title">
                <h2 class="">All Devices</h2>
                <p>Have a nice day</p>
            </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-lg-4">
            <a href="/room" class="kanan btn btn-outline-primary me-2 mt-3 ">
                Rooms
            </a>
            <a href="/alldevice" class="kanan btn btn-outline-primary me-2 mt-3">
                All Devices
            </a>
            <a href="manage-device/create" class="kanan btn btn-primary me-2 mt-3">
                +
            </a>
        </div>
    </div>

    <hr class="line">

    <div class="row mt-5 mb-5" style="justify-content: center">
        @foreach ($data as $row)
        <div class="col-lg-5 me-5">
            <div class="container">
                <div class="card-device">
                    <h2>{{ $row->device_name }}</h2>
                    <p>{{ $row->mac_address }}</p>
                    <div class="pic"></div>
                    <a href="{{url('manage-status/'.$row->device_id)}}">
                        <button></button>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    
</div>
@endsection