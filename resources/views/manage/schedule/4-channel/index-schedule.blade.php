@extends('layout.main')

@section('content')

<div class="container-fluid">
  <div id="schedule-refresh"></div>
    @include('partials.ssc')

    <div class="row">
        <div class="col-xl-12 mb-xl-0 mb-4">
          
            <h6>
              <div id="aaa"></div>
            </h6>

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
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Time</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Option</th>
                              <th></th>
                            </tr>
                            
                          </thead>
                          <tbody>
                            <?php $i = 1; ?>
                            @foreach ($groupedSchedules as $scheduleGroup => $schedules)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$i}}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $schedules[0]['nama_schedule'] }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ Carbon\Carbon::parse($schedules[0]['time'])->format('H:i:s') }}</p>
                                        <p class="text-xs text-secondary mb-0">
                                            @foreach ($schedules as $index => $schedule)
                                                {{ substr(Carbon\Carbon::parse($schedule['time'])->isoFormat('ddd'), 0, 3) }}
                                                @if ($index < count($schedules) - 1)
                                                    ,
                                                @endif
                                            @endforeach
                                        </p>
                                    </td>
                                    <td>
                                        <span class="badge {{$schedules[0]['status'] == '1' ? 'bg-success' : 'bg-danger'}}" style="width: 45px">
                                            {{$schedules[0]['status'] == 1 ? 'On' : 'Off'}}
                                        </span>
                                    </td>
                                    <td>
                                      <p class="text-xs font-weight-bold mb-0">{{ $schedules[0]['schedule_condition'] == 'once' ? 'Only Once' : 'Repeat'}}</p>
                                    </td>
                                    <td class="align-middle">
                                      <a href="#" class="btn btn-link mt-3" data-bs-toggle="dropdown" id="aaa">
                                          <i class="fa fa-ellipsis-v text-sm" aria-hidden="true"></i>
                                      </a>
                                      <div class="dropdown-menu border" aria-labelledby="aaa">
                                          <a href="{{url('manage-schedule/'.$scheduleGroup.'/edit')}}" class="dropdown-item pe-2 mb-2">
                                              Edit
                                          </a>
                                          <form class="d-inline delete-form" action="{{ url('manage-schedule/'.$scheduleGroup) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item pe-3 delete-button">Del</button>
                                        </form>
                                        
                                      </div>
                                  </td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                        </tbody>
                        
                        </table>
                        {{-- <div class="px-4 ">  
                          {{$data_manage_schedule->links()}}
                        </div> --}}
                      </div>
                    </div>
                    
                  </div>
                </div>
                {{--? End Tables --}}
              </div>
            </div>

            {{--? Start Input --}}
            <div class="col-lg-4">
              <div class="row mt-3">
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
</div>
@endsection



<script>
  document.addEventListener('DOMContentLoaded', function () {
      const deleteForms = document.querySelectorAll('.delete-form');
      deleteForms.forEach(function (form) {
          const deleteButton = form.querySelector('.delete-button');
          deleteButton.addEventListener('click', function (event) {
              event.preventDefault(); // Menghentikan pengiriman form secara langsung

              Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Yes, delete it!',
                  cancelButtonText: 'No, cancel!',
                  reverseButtons: true
              }).then(function (result) {
                  if (result.isConfirmed) {
                      form.submit();
                  } else if (result.dismiss === Swal.DismissReason.cancel) {
                      Swal.fire('Cancelled', 'Your data is safe :)', 'info');
                  }
              });
          });
      });
      
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(function (form) {
            const deleteButton = form.querySelector('.delete-button');
            deleteButton.addEventListener('click', function (event) {
                event.preventDefault(); // Menghentikan pengiriman form secara langsung

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire('Cancelled', 'Your data is safe :)', 'info');
                    }
                });
            });
        });

    });
</script>

@if (Session::has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                // title: 'Success',
                text: '{{ Session::get('success') }}',
                icon: 'success',
                timer: 4000, // Timeout dalam milidetik (3 detik)
                timerProgressBar: true,
                toast: true,
                position: 'top-end',
                showConfirmButton: false
            });
        });
    </script>
@endif
