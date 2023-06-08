@extends('layout.main')

@section('content')
<div class="container-fluid py-4">

    <div class="row mt-3">
        <div class="col-md-4">
            <div class="top-title">
                <h2 class="">Rooms</h2>
                <p>Have a nice day</p>
            </div>
        </div>
        <div class="col-lg-8">
            <a href="/room" class="kanan btn btn-outline-primary me-2 mt-3 ">
                Rooms
            </a>
            <a href="/alldevice" class="kanan btn btn-outline-primary me-2 mt-3">
                All Devices
            </a>
        </div>
    </div>

    <hr class="line">

    <div class="row mt-5 mb-5" style="justify-content: center">
        <div class="col-lg-5 me-5">
            <div class="container">
                <div class="card-device">
                    <h2>Living Room</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>Hover hire</span>
                    <div class="pic"></div>
                    <a href="/manage-status">
                        <button></button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="container">
                <div class="card-device card2">
                        <h2>Bathroom</h2>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                        <span>Hover hire</span>
                    <div class="pic"></div>
                        <button></button>
                </div>
            </div>
        </div>  
    </div>

    <div class="row" style="justify-content: center">
        <div class="col-lg-5 me-5">
            <div class="container">
                <div class="card-device">
                    <h2>Terrace</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>Hover hire</span>
                    <div class="pic"></div>
                    <button></button>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="container">
                <div class="card-device card2">
                        <h2>Kitchen</h2>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                        <span>Hover hire</span>
                    <div class="pic"></div>
                        <button></button>
                </div>
            </div>
        </div>  
    </div>
</div>
@endsection