@extends('layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row mt-3">
        <div class="col-lg-7">
            <div class="top-title">
                <h2 class="">{{$device_name}}</h2>
                <p>Have a nice day</p>
            </div>
        </div>
        <div class="col-lg-5">
            <a href="/timers/{{$device_id}}" class="kanan btn btn-outline-info me-2">Countdown</a>
            <a href="/manage-schedule/{{$device_id}}" class="kanan btn btn-outline-success me-2">Schedule</a>
            <a href="/manage-status/{{$device_id}}" class="kanan btn btn-outline-primary me-2">Status</a>
        </div>
    </div>

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
                            <input min="0" type="text" class="form-control" name="duration_hour" value="0" placeholder="Hours">
                        </div>
                        <div class="form-group">
                            <label for="duration_minute" class="form-control-label">Minutes</label>
                            <input min="0" type="text" class="form-control" name="duration_minute" value="0" placeholder="Minutes">
                        </div>
                        <div class="form-group">
                            <label for="duration_second" class="form-control-label">Seconds</label>
                            <input min="0" type="text" class="form-control" name="duration_second" value="5" placeholder="Seconds">
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

            var timerInterval{{ $timer->timer_id }} = setInterval(countdown{{ $timer->timer_id }}, 1000);
        </script>
        @endif
        @endforeach
        @endif
    </div>
</div>
@endsection
