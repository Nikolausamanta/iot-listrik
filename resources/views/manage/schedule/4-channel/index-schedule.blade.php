@extends('layout.main')

@section('content')

<div class="container-fluid py-4">

     {{--? Start Judul Atas --}}
     <div class="row mt-3">
      <div class="col-lg-4">
          
          <div class="top-title">
              <h2 class="">Bathroom</h2>
              <p>Have a nice day</p>
          </div>
      </div>
      <div class="col-lg-8">
        <a href="/manage-countdown/{{$device_id}}">
            <button type="button" class="kanan btn btn-outline-info me-2">Countdown</button>
        </a>
        <a href="/manage-schedule/{{$device_id}}">
            <button type="button" class="kanan btn btn-outline-success me-2">Schedule</button>
        </a>
        <a href="/manage-status/{{$device_id}}">
            <button type="button" class="kanan btn btn-outline-primary me-2">Status</button>
        </a>
      </div>
    </div>
    {{--? End Judul Atas --}}

    @if (Session::has('success'))
        <div class="pt-3">
          <div class="alert alert-success">
            {{Session::get('success')}}
          </div>
        </div>
    @endif
    <div class="row mt-4">
        <div class="col-xl-12 mb-xl-0 mb-4">
          
            <h6>
              <div id="aaa"></div>
            </h6>

          <div class="row">
            <div class="col-lg-8 mb-lg-0 mb-4">
              {{--? Start Upcoming  --}}

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
                              {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Switch</th> --}}
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Schedule Name</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Form Time</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Until Time</th>
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
                                {{-- <td>
                                  <div class="d-flex px-2 ps-2">
                                    <div>
                                      <img src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/logos/small-logos/logo-spotify.svg" class="avatar avatar-sm rounded-circle me-2">
                                    </div>
                                    <div class="my-auto">
                                      <h6 class="mb-0 text-xs">Switch 1</h6>
                                    </div>
                                  </div>
                                </td> --}}
                                <td>
                                  <p class="text-xs font-weight-bold mb-0">{{$item->nama_schedule}}</p>
                                </td>
                                <td >
                                  <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::createFromTimestamp($item->waktu1, 'Asia/Singapore')->format('l, j F Y, H:i:s') }}</p>
                                </td>
                                <td >
                                  <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::createFromTimestamp($item->waktu2, 'Asia/Singapore')->format('l, j F Y, H:i:s') }}</p>
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

              <div class="row mt-4">
                <div class="col-md-12 mb-lg-0 mb-4">
                  <div class="card">
                    <div class="clock">
                      <div id="hour">00</div>
                      <span>:</span>
                      <div id="minute">00</div>
                      <span>:</span>
                      <div id="seconds">00</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mt-4">
                @if (empty($edit_schedule))
                @include('manage.schedule.4-channel.create')  
                @else
                @include('manage.schedule.4-channel.edit')  
                @endif
              </div>
            </div>
            {{--? End Input --}}  
        </div>
      </div>
    </div>
    <hr class="horizontal dark">


</div>
@endsection