@extends('layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    Set Timer
                </div>
                <div class="card-body">
                    <form action="{{ route('timers.store') }}" method="post" role="form text-left">
                        @csrf
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Device Id</label>
                            <input type="text" class="form-control" name="device_id" value="{{ $device_id }}" placeholder="Device Id" aria-label="Name" aria-describedby="name-addon">
                        </div>

                        <hr class="horizontal dark">

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
                @if ($timer->end_time && $timer->getRemainingTime() > 0)
                    <div class="col-lg-9 mt-4">
                        <div class="card py-4 px-8">
                            <div class="text-center">
                                <div id="timer-{{ $timer->timer_id }}">
                                    <div class="clock">
                                        <span class="clock-hour">{{ $timer->getRemainingHours() }}</span> hours
                                        <span class="clock-minute">{{ $timer->getRemainingMinutes() }}</span> minutes
                                        <span class="clock-second">{{ $timer->getRemainingSeconds() }}</span> seconds remaining
                                    </div>
                                    <form action="{{ route('timers.cancel', $timer) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-lg btn-rounded w-100 mt-4 mb-0">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        // JavaScript code for countdown and switch update
                        var timerElement{{ $timer->timer_id }} = document.getElementById('timer-{{ $timer->timer_id }}');
                        var clockHour{{ $timer->timer_id }} = timerElement{{ $timer->timer_id }}.querySelector('.clock-hour');
                        var clockMinute{{ $timer->timer_id }} = timerElement{{ $timer->timer_id }}.querySelector('.clock-minute');
                        var clockSecond{{ $timer->timer_id }} = timerElement{{ $timer->timer_id }}.querySelector('.clock-second');
                        var remainingTime{{ $timer->timer_id }} = {
                            hours: {{ $timer->getRemainingHours() }},
                            minutes: {{ $timer->getRemainingMinutes() }},
                            seconds: {{ $timer->getRemainingSeconds() }} 
                        };

                        function countdown{{ $timer->timer_id }}() {
                            if (remainingTime{{ $timer->timer_id }}.seconds > 0) {
                                remainingTime{{ $timer->timer_id }}.seconds--;
                            } else {
                                if (remainingTime{{ $timer->timer_id }}.minutes > 0) {
                                    remainingTime{{ $timer->timer_id }}.minutes--;
                                    remainingTime{{ $timer->timer_id }}.seconds = 59;
                                } else {
                                    if (remainingTime{{ $timer->timer_id }}.hours > 0) {
                                        remainingTime{{ $timer->timer_id }}.hours--;
                                        remainingTime{{ $timer->timer_id }}.minutes = 59;
                                        remainingTime{{ $timer->timer_id }}.seconds = 59;
                                    } else {
                                        clearInterval(timerInterval{{ $timer->timer_id }});
                                        updateSwitch('{{ route('timers.updateSwitch', $timer) }}');
                                        timerElement{{ $timer->timer_id }}.parentNode.removeChild(timerElement{{ $timer->timer_id }});
                                    }
                                }
                            }

                            clockHour{{ $timer->timer_id }}.textContent = remainingTime{{ $timer->timer_id }}.hours;
                            clockMinute{{ $timer->timer_id }}.textContent = remainingTime{{ $timer->timer_id }}.minutes;
                            clockSecond{{ $timer->timer_id }}.textContent = remainingTime{{ $timer->timer_id }}.seconds;
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

                        var timerInterval{{ $timer->timer_id }} = setInterval(countdown{{ $timer->timer_id }}, 1000);
                    </script>
                @endif
            @endforeach
        @endif
    </div>
</div>



@endsection
