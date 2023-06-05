@extends('layout.main')

@section('content')
<div class="container-fluid py-4">
    
    @include('partials.ssc')

    <div class="row mt-4">
        {{--? Start Toggle Switch (On/Off) --}}
        <div class="col-lg-3 mb-lg-0 mb-4">
            <div class="card card-on-off">
                
                    {{--? Start Switch 1  --}}
                    <div class="col-xl-12 col-sm-12 mb-xl-0">
                        <section class="toggle-switch">
                            <div class="power-switch">
                                <input type="checkbox" class="checkbox-on-off" onchange="ubahstatus3(this.checked)" />
                                {{-- <span id="status3">on</span> --}}

                                <div class="button-on-off" id="status3">
                                    <svg class="power-off">
                                        <use xlink:href="#line" class="line" />
                                        <use xlink:href="#circle" class="circle" />
                                    </svg>
                                    <svg class="power-on">
                                        <use xlink:href="#line" class="line" />
                                        <use xlink:href="#circle" class="circle" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 150" id="line">
                                <line x1="75" y1="34" x2="75" y2="58"/>
                                </symbol>
                                <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 150" id="circle">
                                <circle cx="75" cy="80" r="35"/>
                                </symbol>
                            </svg>
                        
                        </section>
                    </div>
                    {{--? End Switch 1  --}}
          
            </div>
        </div>
        {{--? End Toggle Switch (On/Off) --}}

        {{--? Start Chart Power Consumption  --}}
        <div class="col-lg-9 mb-lg-0 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Power Consumption</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="800" width="1115" style="display: block; box-sizing: border-box; height: 300px; width: 557.9px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        {{--? End Power Consumption --}}
    </div>

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
@endsection