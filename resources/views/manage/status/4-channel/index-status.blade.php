@extends('layout.main')

@section('content')
<div class="container-fluid py-4">
    
    @include('partials.ssc')

    <div class="row mt-4">
        {{--? Start Toggle Switch (On/Off) --}}
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card card-on-off">
                <div class="row">
                    {{--? Start Switch 1  --}}
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <section class="toggle-switch">
                            <div class="power-switch">
                                <input type="checkbox" class="checkbox-on-off"/>
                                <div class="button-on-off">
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

                    {{--? Start Switch 2  --}}
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <section class="toggle-switch">
                            <div class="power-switch">
                                <input type="checkbox" class="checkbox-on-off"/>
                                <div class="button-on-off">
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
                    {{--? End Switch 2  --}}

                    {{--? Start Switch 3  --}}
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <section class="toggle-switch">
                            <div class="power-switch">
                                <input type="checkbox" class="checkbox-on-off"/>
                                <div class="button-on-off">
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
                    {{--? End Switch 3  --}}

                    {{--? Start Switch 4  --}}
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <section class="toggle-switch">
                            <div class="power-switch">
                                <input type="checkbox" class="checkbox-on-off"/>
                                <div class="button-on-off">
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
                </div>
                {{--? End Switch 4  --}}
            </div>
        </div>
        {{--? End Toggle Switch (On/Off) --}}

        {{--? Start  --}}

        <div class="col-lg-5">
            <div class="card">
                <div class="card-header pb-0 p-3">
                <h6 class="mb-0">Categories</h6>
                </div>
                <div class="card-body p-3">
                <ul class="list-group">
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                        <i class="ni ni-mobile-button text-white opacity-10"></i>
                        </div>
                        <div class="d-flex flex-column">
                        <h6 class="mb-1 text-dark text-sm">Devices</h6>
                        <span class="text-xs">250 in stock, <span class="font-weight-bold">346+ sold</span></span>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                    </div>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                        <i class="ni ni-tag text-white opacity-10"></i>
                        </div>
                        <div class="d-flex flex-column">
                        <h6 class="mb-1 text-dark text-sm">Tickets</h6>
                        <span class="text-xs">123 closed, <span class="font-weight-bold">15 open</span></span>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                    </div>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                        <i class="ni ni-box-2 text-white opacity-10"></i>
                        </div>
                        <div class="d-flex flex-column">
                        <h6 class="mb-1 text-dark text-sm">Error logs</h6>
                        <span class="text-xs">1 is active, <span class="font-weight-bold">40 closed</span></span>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                    </div>
                
                </ul>
                </div>
            </div>
            </div>

        {{--? End  --}}
    </div>
</div>
@endsection