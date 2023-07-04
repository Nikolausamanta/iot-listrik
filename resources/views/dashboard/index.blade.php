@extends('layout.main')

@section('content')
  
{{--? Start Card Content  --}}
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-2">
            <div class="top-title">
                <h2 class="">Dashboard</h2>
                <p>Have a nice day</p>
            </div>
        </div>
    </div>

    {{-- <hr class="line">    --}}

    <div class="row">
        <div class="col-xl-12 mb-xl-0 mb-4">
            <div class="row">
                <div class="col-lg-8 mb-lg-0 mb-4">
                  {{--? Start Upcoming  --}}
    
                  <div class="row mt-3">
                    <div class="col-md-12 mb-lg-0 mb-4">
                      <div class="card">
                          <div class="card-header pb-0 p-3">
                              <div class="row">
                                  <div class="col-6 d-flex align-items-center">
                                      <h6 class="mb-0">Upcoming</h6>
                                  </div>
                              </div>
                          </div>
                          <div class="card-body p-3">
                              @if($upcoming)
                                  <div class="row ">
                                      {{--? Start 1 --}}
                                      <div class="col-lg-4 mb-lg-0 mb-4 col-6">
                                        <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                {{-- <div class="d-flex align-items-center text-sm">
                                                    <button class="btn btn-link text-dark text-sm mb-0 px-0">
                                                      <i class="me-4 ni ni-tv-2 text-primary opacity-10" style="font-size: 15px"></i>
                                                    </button>
                                                </div> --}}
                                                <div class="d-flex flex-column">
                                                  <span class="text-sm">Schedule Name</span>
                                                  <p class="text-md text-dark font-weight-bold mb-0">{{$upcoming->nama_schedule}}</p>

                                                </div>
                                            </li>
                                        </div>
                                      </div>
                                      {{--? End 1 --}}
    
                                      {{--? Start 2 --}}
                                      <div class="col-lg-4 mb-lg-0 mb-4 col-6">
                                        <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                {{-- <div class="d-flex align-items-center text-sm">
                                                    <button class="btn btn-link text-dark text-sm mb-0 px-0">
                                                      <i class="me-4 ni ni-tv-2 text-primary opacity-10" style="font-size: 15px"></i>
                                                    </button>
                                                </div> --}}
                                                <div class="d-flex flex-column">
                                                  <span class="text-sm">Time</span>
                                                  <p class="text-md text-dark font-weight-bold mb-0">{{ \Carbon\Carbon::createFromTimestamp($upcoming->time, 'Asia/Singapore')->format('l, H:i:s') }}</p>
                                                </div>
                                            </li>
                                        </div>
                                      </div>
                                      {{--? End 2 --}}
                                      
                                      {{--? Start 3 --}}
                                      <div class="col-lg-2 mb-lg-0 mb-4 col-6">
                                        <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                {{-- <div class="d-flex align-items-center text-sm">
                                                    <button class="btn btn-link text-dark text-sm mb-0 px-0">
                                                      <i class="me-4 ni ni-tv-2 text-primary opacity-10" style="font-size: 15px"></i>
                                                    </button>
                                                </div> --}}
                                                <div class="d-flex flex-column">
                                                  <span class="text-sm">Status</span>
                                                  <p class="text-md text-dark font-weight-bold mb-0">{{$upcoming->status == 1 ? 'On' : 'Off'}}</p>
                                                </div>
                                            </li>
                                        </div>
                                      </div>
                                      {{--? End 3 --}}

                                      {{--? Start 4 --}}
                                      <div class="col-lg-2 mb-lg-0 mb-4 col-6">
                                        <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row" id="card4">
                                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                {{-- <div class="d-flex align-items-center text-sm">
                                                    <button class="btn btn-link text-dark text-sm mb-0 px-0">
                                                      <i class="me-4 ni ni-tv-2 text-primary opacity-10" style="font-size: 15px"></i>
                                                    </button>
                                                </div> --}}
                                                <div class="d-flex flex-column">
                                                  <span class="text-sm">Condition</span>
                                                  <p class="text-md text-dark font-weight-bold mb-0">{{$upcoming->schedule_condition == 'Once' ? 'Only' : 'Repeat'}}</p>
                                                </div>
                                            </li>
                                        </div>
                                      </div>
                                      {{--? End 4--}}
                                      <script>
                                        window.addEventListener('DOMContentLoaded', () => {
                                          const card1 = document.getElementById('card1');
                                          const card2 = document.getElementById('card2');
                                          const card3 = document.getElementById('card3');
                                    
                                          card1.style.height = '120px'; // Set tinggi card pertama
                                          card2.style.height = `${card1.offsetHeight}px`; // Set tinggi card kedua mengikuti tinggi card pertama
                                          card3.style.height = `${card1.offsetHeight}px`; // Set tinggi card ketiga mengikuti tinggi card pertama
                                        });
                                      </script>
                                      
                                  </div>
                                @else
                                    <p>No upcoming schedule found.</p>
                                @endif
                          </div>
                      </div>
                    </div>
                  </div>
                  {{--? End Upcoming  --}}
                  
                  <div class="row mt-4">
                    {{--? Start Tables --}}
                    <div class="col-md-12 mb-lg-0">
                      <div class="card">
                        <div class="card-header pb-0 p-3">
                          <div class="row">
                            <div class="col-6 d-flex align-items-center">
                                <h6 class="mb-0">Device</h6>
                            </div>
                            {{-- <div class="col-6 text-end">
                                <a class="btn bg-gradient-dark mb-0" href="javascript:;"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add New Card</a>
                            </div> --}}
                          </div>
                        </div>
                        <div class="card-body p-3">
                          <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                              <thead>
                                <tr>
                                  <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">No</th>
                                  <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-4">Device Name</th>
                                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-4">Status</th>
                                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-4">Remaining Schedule</th>
                                </tr>
                                
                              </thead>
                              <tbody>
                                <?php $i = 1; ?>
                                @foreach ($device as $device)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="font-weight-bold mb-2 mt-2" style="font-size: 14px">{{$i}}</p>
                                        </td>
                                        <td class="ps-4">
                                            <p class="font-weight-bold mb-2 mt-2" style="font-size: 14px">{{ $device->device_name }}</p>
                                        </td>
                                        <td class="ps-2 text-center ">
                                            <span class="badge {{$device->switch == '1' ? 'bg-success' : 'bg-danger'}} mb-2 mt-2" style="width: 45px">
                                                {{$device->switch == 1 ? 'On' : 'Off'}}
                                            </span>
                                        </td>
                                        <td class="ps-4 text-center">
                                            <p class="font-weight-bold mb-2 mt-2" style="font-size: 14px">{{ $device->total_schedule }}</p>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </tbody>
                            
                            </table>
                          </div>
                        </div>
                        
                      </div>
                    </div>
                    {{--? End Tables --}}
                  </div>
                </div>
    
                {{--? Start Input --}}
                <div class="col-lg-4">
                  <div class="row mt-3 d-none d-lg-block">
                    <div class="col-md-12 mb-lg-0">
                        <div class="card">
                            <div class="card-body py-4">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Device</p>
                                            <h4 class="font-weight-bolder mb-0">{{$totalDevices}}</h4>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                            <i class="ni ni-ungroup text-lg opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-none d-lg-block">
                    <div class="col-xl-12 mb-xl-0 mb-4">
                        <div class="card bg-transparent shadow-xl">
                            <div class="overflow-hidden position-relative border-radius-xl" style="height: 390px; background-image: url('assets/img/card-visa.jpg');"></div>
                        </div>
                    </div>
                </div>
                {{--? End Input --}}  
            </div>
        </div>
    </div>
    {{--? End Card Content  --}}
@endsection

@if (Session::has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                // title: 'Success',
                text: '{{ Session::get('success') }}',
                icon: 'success',
                timer: 3000, // Timeout dalam milidetik (3 detik)
                timerProgressBar: true,
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false
            });
        });
    </script>
@endif