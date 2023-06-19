@extends('layout.main')

@section('content')
<div class="container-fluid">
    @include('partials.ssc')


    <div class="row mt-4">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    Set Timer
                </div>
                <div class="card-body">
                    <form id="set-timer-form" action="{{ route('timers.store') }}" method="post" role="form text-left">
                        @csrf
                        <input type="hidden" name="device_id" value="{{ $device_id }}">

                        <div class="form-group">
                            <label for="duration_hour" class="form-control-label">Hours</label>
                            <input type="number" min="0" max="23" name="duration_hour" id="duration_hour" class="form-control @if($errors->has('duration_hour') || old('duration_hour') === '') is-invalid @elseif($errors->any()) is-valid @endif" value="{{ old('duration_hour') }}" placeholder="Hours">
                            @if($errors->has('duration_hour') || old('duration_hour') === '')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('duration_hour') ?? 'The mac address field is required.' }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="duration_minute" class="form-control-label">Minutes</label>
                            <input type="number" min="0" max="59" name="duration_minute" id="duration_minute" class="form-control @if($errors->has('duration_minute') || old('duration_minute') === '') is-invalid @elseif($errors->any()) is-valid @endif" value="{{ old('duration_minute') }}" placeholder="Minutes">
                            @if($errors->has('duration_minute') || old('duration_minute') === '')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('duration_minute') ?? 'The mac address field is required.' }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="duration_second" class="form-control-label">Seconds</label>
                            <input type="number" min="0" max="59" name="duration_second" id="duration_second" class="form-control @if($errors->has('duration_second') || old('duration_second') === '') is-invalid @elseif($errors->any()) is-valid @endif" value="{{ old('duration_second') }}" placeholder="Seconds">
                            @if($errors->has('duration_second') || old('duration_second') === '')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('duration_second') ?? 'The mac address field is required.' }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        {{-- Js buat input Max 23 buat Hour, 59 buat Minute, 59 buat Second --}}
                        <script>
                            const durationHourInput = document.getElementById('duration_hour');
                            const durationMinuteInput = document.getElementById('duration_minute');
                            const durationSecondInput = document.getElementById('duration_second');
                        
                            durationHourInput.addEventListener('input', enforceMaxValue.bind(null, durationHourInput, 23));
                            durationMinuteInput.addEventListener('input', enforceMaxValue.bind(null, durationMinuteInput, 59));
                            durationSecondInput.addEventListener('input', enforceMaxValue.bind(null, durationSecondInput, 59));
                        
                            function enforceMaxValue(input, maxValue) {
                                if (input.value > maxValue) {
                                    input.value = maxValue;
                                }
                            }
                        </script>
                        
                        
                        <div class="col-md-12">
                            <label for="example-text-input" class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</label>
                            <div class="toggle">
                              <input type="radio" id="status_hidup" name="status" value="1" checked>
                              <label for="status_hidup">On</label>
                              <input type="radio" id="status_mati" name="status" value="0">
                              <label for="status_mati" class="red">Off</label>
                            </div>
                          </div>
                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-success btn-lg btn-rounded w-100 mt-4 mb-0">Set Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if ($timers->isEmpty())
        <div class="col-lg-9">
            <p>No timers found.</p>
        </div>
        @else
        @foreach ($timers as $timer)
        <div class="col-lg-9">
            <div class="card" style="height: 28.5rem; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <div class="text-center">
                    <div class="clock">
                        <span class="clock-hour" id="clock-hour-{{ $timer->timer_id }}">{{ $timer->getRemainingHours() }}</span> &ensp; hours &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                        <span class="clock-minute" id="clock-minute-{{ $timer->timer_id }}">{{ $timer->getRemainingMinutes() }}</span> &ensp; minutes &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                        <span class="clock-second" id="clock-second-{{ $timer->timer_id }}">{{ $timer->getRemainingSeconds() }}</span> &ensp; seconds
                    </div>
                    <form action="{{ route('timers.cancel', $timer) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg btn-rounded w-100 mt-4 mb-0">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        @if ($timer->end_time && $timer->getRemainingTime() > 0)
        <script>
            var timer{{ $timer->timer_id }} = {
                hourElement: document.getElementById('clock-hour-{{ $timer->timer_id }}'),
                minuteElement: document.getElementById('clock-minute-{{ $timer->timer_id }}'),
                secondElement: document.getElementById('clock-second-{{ $timer->timer_id }}'),
                remainingTime: {
                    hours: {{ $timer->getRemainingHours() }},
                    minutes: {{ $timer->getRemainingMinutes() }},
                    seconds: {{ $timer->getRemainingSeconds() }}
                }
            };

            function countdown{{ $timer->timer_id }}() {
                var remainingTime = timer{{ $timer->timer_id }}.remainingTime;
                if (remainingTime.seconds > 0) {
                    remainingTime.seconds--;
                } else if (remainingTime.minutes > 0) {
                    remainingTime.minutes--;
                    remainingTime.seconds = 59;
                } else if (remainingTime.hours > 0) {
                    remainingTime.hours--;
                    remainingTime.minutes = 59;
                    remainingTime.seconds = 59;
                } else {
                    clearInterval(timerInterval{{ $timer->timer_id }});
                    showSuccessAlert(); //Show Sweetalert2
                    updateSwitch('{{ route('timers.updateSwitch', $timer) }}');
                    document.getElementById('timer-{{ $timer->timer_id }}').setAttribute('hidden', 'hidden');
                }

                timer{{ $timer->timer_id }}.hourElement.textContent = padZero(remainingTime.hours);
                timer{{ $timer->timer_id }}.minuteElement.textContent = padZero(remainingTime.minutes);
                timer{{ $timer->timer_id }}.secondElement.textContent = padZero(remainingTime.seconds);
            }

            function updateSwitch(url) {
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Switch updated successfully');
                        } else {
                            console.log('Failed to update switch');
                        }
                    })
                    .catch(error => {
                        console.log('An error occurred:', error);
                    });
            }

            function padZero(number) {
                return number.toString().padStart(2, '0');
            }

             // Sweetalert2
             function showSuccessAlert() {
                Swal.fire({
                    icon: 'success',
                    title: 'Timer Finished',
                    text: 'The timer has finished successfully.',
                    confirmButtonText: 'OK'
                });
            }

            var timerInterval{{ $timer->timer_id }} = setInterval(countdown{{ $timer->timer_id }}, 1000);
        </script>
        @endif
        @endforeach
        @endif
    </div>
</div>
@endsection
