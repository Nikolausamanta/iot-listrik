@extends('layout.main')

@section('content')
  
<div class="container-fluid py-4">
    
    {{--? Start Card Content 1 Column  --}}
    {{--? Start Judul Atas  --}}
    <div class="row mt-3">
        <div class="col-md-2">
            <div class="top-title">
                <h2 class="">Analyze</h2>
                <p>Have a nice day</p>
            </div>
        </div>
        <div class="col-lg-10 mb-lg-0 mb-4">
        
        @foreach ($data as $row)
            <a href="{{url('analyze/'.$row->device_id)}}" class="kanan btn btn-outline-primary me-2 mt-3 ">
                {{ $row->device_name }}
            </a>
        @endforeach
        <a href="analyze/" class="kanan btn btn-outline-primary me-2 mt-3 ">
            All Device
        </a>
        </div>
    </div>
    {{--? End Judul Atas  --}}

    {{--? Start Chart Coast --}}
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Coast: This Month</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="800" width="1115" style="display: block; box-sizing: border-box; height: 300px; width: 557.9px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--? End Chart Coast--}}

    {{--? End Card Content 1 Column  --}}
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Electricity Cost</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="bar-chart-horizontal" class="chart-canvas" height="337" width="662" style="display: block; box-sizing: border-box; height: 300px; width: 588.8px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Power Consumption</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="" class="chart-canvas" height="337" width="662" style="display: block; box-sizing: border-box; height: 300px; width: 588.8px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    
    
    {{--? Start Content 2 Column   --}}
    <div class="row ">
    {{--? Start Sensor  --}}
    <div class="col-md-12 mb-lg-0 mb-4">
        <div class="card mt-4">
            {{-- <div class="card-header pb-0 p-3">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <h6 class="mb-0">Payment Method</h6>
                    </div>
                    <div class="col-6 text-end">
                        <a class="btn bg-gradient-dark mb-0" href="javascript:;"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add New Card</a>
                    </div>
                </div>
            </div> --}}
            <div class="card-body p-3">
                @foreach ($data as $item)  
                    <div class="row">
                        {{--? Start 1 --}}
                        <div class="col-lg-2 mb-lg-0 mb-4">
                            <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center text-sm">
                                        <button class="btn btn-link text-dark text-sm mb-0 px-0"><i class="me-4 ni ni-tv-2 text-primary opacity-10" style="font-size: 15px"></i></button>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-sm">Voltage</span>
                                        <h5 class="text-dark font-weight-bold">{{$item->voltage}} kWh</h5>
                                    </div>
                                </li>
                            </div>
                        </div>
                        {{--? End 1 --}}

                        {{--? Start 2 --}}
                        <div class="col-lg-2 mb-lg-0 mb-4">
                            <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center text-sm">
                                        <button class="btn btn-link text-dark text-sm mb-0 px-0"><i class="me-4 ni ni-tv-2 text-primary opacity-10" style="font-size: 15px"></i></button>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-sm">Current</span>
                                        <h5 class="text-dark font-weight-bold">{{$item->current}} kWh</h5>
                                    </div>
                                </li>
                            </div>
                        </div>
                        {{--? End 2 --}}

                        {{--? Start 3 --}}
                        <div class="col-lg-2 mb-lg-0 mb-4">
                            <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center text-sm">
                                        <button class="btn btn-link text-dark text-sm mb-0 px-0"><i class="me-4 ni ni-tv-2 text-primary opacity-10" style="font-size: 15px"></i></button>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-sm">Power</span>
                                        <h5 class="text-dark font-weight-bold">{{$item->power}} kWh</h5>
                                    </div>
                                </li>
                            </div>
                        </div>
                        {{--? End 3 --}}

                        {{--? Start 4 --}}
                        <div class="col-lg-2 mb-lg-0 mb-4">
                            <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center text-sm">
                                        <button class="btn btn-link text-dark text-sm mb-0 px-0"><i class="me-4 ni ni-tv-2 text-primary opacity-10" style="font-size: 15px"></i></button>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-sm">Energy</span>
                                        <h5 class="text-dark font-weight-bold">{{$item->energy}} kWh</h5>
                                    </div>
                                </li>
                            </div>
                        </div>
                        {{--? End 4 --}}

                        {{--? Start 5 --}}
                        <div class="col-lg-2 mb-lg-0 mb-4">
                            <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center text-sm">
                                        <button class="btn btn-link text-dark text-sm mb-0 px-0"><i class="me-4 ni ni-tv-2 text-primary opacity-10" style="font-size: 15px"></i></button>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-sm">Frequency</span>
                                        <h5 class="text-dark font-weight-bold">{{$item->frequency}} kWh</h5>
                                    </div>
                                </li>
                            </div>
                        </div>
                        {{--? End 5 --}}

                        {{--? Start 6 --}}
                        <div class="col-lg-2 mb-lg-0 mb-4">
                            <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center text-sm">
                                        <button class="btn btn-link text-dark text-sm mb-0 px-0"><i class="me-4 ni ni-tv-2 text-primary opacity-10" style="font-size: 15px"></i></button>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-sm">Power Factor</span>
                                        <h5 class="text-dark font-weight-bold">{{$item->powerfactor}} kWh</h5>
                                    </div>
                                </li>
                            </div>
                        </div>
                        {{--? End 6 --}}
                        
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{--? End Sensor  --}}
    </div>
    {{--? End Content 2 Column   --}}

@endsection