@extends('layout.main')

@section('content')

<div class="container-fluid py-4">

    @include('partials.ssc')

    @if (Session::has('success'))
        <div class="pt-3">
          <div class="alert alert-success">
            {{Session::get('success')}}
          </div>
        </div>
    @endif
    <div class="row mt-4">
        <div class="col-xl-12 mb-xl-0 mb-4">
          {{-- <button type="button" class="btn bg-gradient-primary btn-block" data-bs-toggle="modal" data-bs-target="#create-schedule">
              <span class="btn-inner--icon"><i class="fas fa-plus"></i>&nbsp;&nbsp;</span>
              <span class="btn-inner--text">Add New Schedule</span>
          </button> --}}

          <div class="row">
            <div class="col-lg-8 mb-lg-0 mb-4">
              {{--? Start Upcoming  --}}
              <div class="row">
                <div class="col-md-12 mb-lg-0 mb-4">
                  <div class="card">
                    <div class="card-header">
                      <h6>Jam Sekarang : </h6>
                    </div>
                    <div class="card-body">
                      <h6>
                        <div id="datajam"></div>
                      </h6>
                      <h6>
                        <div id="aaa"></div>
                      </h6>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-md-12 mb-lg-0 mb-4">
                  <div class="card">
                      <div class="card-header pb-0 p-3">
                          <div class="row">
                              <div class="col-6 d-flex align-items-center">
                                  <h6 class="mb-0">Upcoming</h6>
                              </div>
                              {{-- <div class="col-6 text-end">
                                  <a class="btn bg-gradient-dark mb-0" href="javascript:;"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add New Card</a>
                              </div> --}}
                          </div>
                      </div>
                      <div class="card-body p-3">
                          @foreach ($upcoming as $item)  
                              <div class="row">
                                  {{--? Start 1 --}}
                                  <div class="col-lg-4 mb-lg-0 mb-4">
                                      <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                          <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                              <div class="d-flex align-items-center text-sm">
                                                  <button class="btn btn-link text-dark text-sm mb-0 px-0">
                                                    <i class="me-4 ni ni-tv-2 text-primary opacity-10" style="font-size: 15px"></i>
                                                  </button>
                                              </div>
                                              <div class="d-flex flex-column">
                                                <span class="text-sm">Schedule Name</span>
                                                <h5 class="text-dark font-weight-bold">{{$item->nama_schedule}}</h5>
                                                  {{-- <h5 class="text-dark font-weight-bold">{{$item->voltage}} kWh</h5> --}}
                                              </div>
                                          </li>
                                      </div>
                                  </div>
                                  {{--? End 1 --}}

                                  {{--? Start 2 --}}
                                  <div class="col-lg-4 mb-lg-0 mb-4">
                                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                            <div class="d-flex align-items-center text-sm">
                                                <button class="btn btn-link text-dark text-sm mb-0 px-0">
                                                  <i class="me-4 ni ni-tv-2 text-primary opacity-10" style="font-size: 15px"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex flex-column">
                                              <span class="text-sm">Time</span>
                                              <h5 class="text-dark font-weight-bold">{{$item->waktu1}}</h5>
                                                {{-- <h5 class="text-dark font-weight-bold">{{$item->voltage}} kWh</h5> --}}
                                            </div>
                                        </li>
                                    </div>
                                  </div>
                                  {{--? End 2 --}}
                                  
                                  {{--? Start 3 --}}
                                  <div class="col-lg-4 mb-lg-0 mb-4">
                                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                            <div class="d-flex align-items-center text-sm">
                                                <button class="btn btn-link text-dark text-sm mb-0 px-0">
                                                  <i class="me-4 ni ni-tv-2 text-primary opacity-10" style="font-size: 15px"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex flex-column">
                                              <span class="text-sm">Schedule Name</span>
                                              <h5 class="text-dark font-weight-bold">{{$item->tanggal1}}</h5>
                                                {{-- <h5 class="text-dark font-weight-bold">{{$item->voltage}} kWh</h5> --}}
                                            </div>
                                        </li>
                                    </div>
                                  </div>
                                  {{--? End 3 --}}
                                  
                                  
                              </div>
                          @endforeach
                      </div>
                  </div>
                </div>
              </div>
              {{--? End Upcoming  --}}
              
              <div class="row mt-4">
                {{--? Start Tables --}}
                <div class="col-md-12 mb-lg-0 mb-4">
                  <div class="card">
                    <div class="card-header pb-0 p-3">
                      <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Event Schedule</h6>
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
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Switch</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Schedule Name</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Time</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Time 2</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date 2</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $i = $data_manage_schedule->firstItem() ?>
                            @foreach ($data_manage_schedule as $item)  
                              <tr>
                                <td class="ps-4">
                                  <p class="text-xs font-weight-bold mb-0">{{$i}}</p>
                                </td>
                                <td>
                                  <div class="d-flex px-2 ps-2">
                                    <div>
                                      <img src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/logos/small-logos/logo-spotify.svg" class="avatar avatar-sm rounded-circle me-2">
                                    </div>
                                    <div class="my-auto">
                                      <h6 class="mb-0 text-xs">Switch 1</h6>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <p class="text-xs font-weight-bold mb-0">{{$item->nama_schedule}}</p>
                                </td>
                                <td >
                                  <p class="text-xs font-weight-bold mb-0">{{$item->waktu1}}</p>
                                </td>
                                <td >
                                  <p class="text-xs font-weight-bold mb-0">{{$item->waktu2}}</p>
                                </td>
                                <td>
                                  <p class="text-xs font-weight-bold mb-0">{{$item->tanggal1}}</p>
                                </td>
                                <td>
                                  <p class="text-xs font-weight-bold mb-0">{{$item->tanggal2}}</p>
                                </td>
                                <td class="align-middle">
                                  <a href="{{url('manage-schedule/'.$item->schedule_id.'/edit')}}"  class="btn btn-primary font-weight-bold text-xs">
                                    Edit
                                  </a>
                                  <form onsubmit="return confrim('apa yakin mau hapus')" class="d-inline" action="{{url('manage-schedule/'.$item->schedule_id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                      <button type="submit" name="submit" class="btn btn-primary font-weight-bold text-xs">del</button>
                                  </form>
                                  
  
                                </td>
                              </tr>
  
                            <?php $i++ ?>
                            @endforeach
  
                          </tbody>
                        </table>
                        <div class="px-4 ">  
                          {{$data_manage_schedule->links()}}
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
                {{--? End Tables --}}
              </div>
              
              
            </div>

            {{--? Start Input --}}
            <div class="col-lg-4">
              @if (empty($edit_schedule))
                @include('manage.schedule.4-channel.create')  
              @else
                @include('manage.schedule.4-channel.edit')  
              @endif
            </div>
            {{--? End Input --}}  
        </div>
      </div>
    </div>
    <hr class="horizontal dark">


</div>
@endsection