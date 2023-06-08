@extends('layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="top-title">
                <h2 class="">Add Device</h2>
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
        <p class="mb-0">Add Device</p>
        {{-- <button class="btn btn-primary btn-sm ms-auto">Add</button> --}}
      </div>
    </div>
    
    <div class="card-body col-lg-12">
        <div class="row mt-4">
        <div class="col-lg-7">  
        {{-- <p class="text-uppercase text-sm">User Information</p> --}}
            <form action='{{url('manage-device')}}' method='post' role="form text-left">
            @csrf
        
            <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Device Name</label>
                    <input type="text" class="form-control" name="device_name" value="{{ Session::get('device_name')}}" placeholder="Device Name" aria-label="Name" aria-describedby="name-addon">
                    {{-- <input class="form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)"> --}}
                </div>
                </div>
            </div>
        
            <hr class="horizontal dark">
            {{-- <p class="text-uppercase text-sm">Contact Information</p> --}}
            
            <div class="row">
                <div class="col-md-9">
                
                <h5>
                    Mac Address : <div id="dataContainer"></div>
                  </h5>

                  <button id="triggerButton">Tampilkan Data</button>
                    <script>
                    $('#triggerButton').click(function() {
                    // Kirim permintaan AJAX ke controller
                    $.ajax({
                        url: 'manage-device/show-mac', // Ganti dengan URL sebenarnya ke controller Anda
                        type: 'GET',
                        success: function(response) {
                        // Tampilkan data dari respons di dalam elemen HTML yang sesuai
                        var html = '';

                        // Buat tampilan data sesuai kebutuhan Anda
                        html += response.mac_address
                        // Tampilkan data dari respons di dalam elemen HTML yang sesuai
                        $('#dataContainer').html(html);
                        },
                        error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        }
                    });
                    });
                    </script>
            </div>
            
        
            <hr class="horizontal dark">
            {{-- <p class="text-uppercase text-sm">About me</p> --}}
        
            <div class="text-center">
                <button type="submit" name="submit" class="btn btn-success btn-lg btn-rounded w-100 mt-4 mb-0">Set Now</button>
            </div>
        </div>
        {{-- <div class="col-lg-5">
            <img class=" h-100 border-radius-lg shadow-sm" src="{{ asset('assets/img/carousel-1.jpg') }}" alt="tag">
        </div> --}}
        </div>
  </div>
</div>
@endsection
  