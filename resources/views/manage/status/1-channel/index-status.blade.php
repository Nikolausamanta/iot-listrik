@extends('layout.main')

@section('content')
<div class="container-fluid py-4">
    {{--? Start 3 Card (Status, Schedule, Countdown) --}}
    <div class="row">
        {{--? Start Status Card --}}
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                    <div class="numbers">
                        <h5 class="font-weight-bolder">Status</h5>
                    </div>
                    </div>
                    <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                        <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
         {{--? End Status Card --}}

        {{--? Start Schedule Card --}}
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                    <div class="numbers">
                        <h5 class="font-weight-bolder">Schedule</h5>
                    </div>
                    </div>
                    <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                        <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        {{--? End Schedule Card --}}

        {{--? Start Countdown Card --}}
        <div class="col-xl-4 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                    <div class="numbers">
                        <h5 class="font-weight-bolder">Countdown</h5>
                    </div>
                    </div>
                    <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                        <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        {{--? End Countdown Card --}}
    </div>
    {{--? End 3 Card (Status, Schedule, Countdown) --}}

    <div class="row">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            {{--? Start Toggle Switch (On/Off) --}}
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
            {{--? End Toggle Switch (On/Off) --}}
        </div>
    </div>

</div>
@endsection