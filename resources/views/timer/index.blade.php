@extends('layout.main')

@section('content')
<div class="container-fluid py-4">
    
    <div class="col-lg-3">
    <div class="card">
    <div class="card-header">
        Set Timer
    </div>
    <div class="card-body">

    <form action='{{route('timers.store')}}' method='post' role="form text-left">
        @csrf
        <div class="row" hidden>
          <div class="col-md-12">
            <div class="form-group">
              <label for="example-text-input" class="form-control-label">Relay Id:</label>
              <input type="text" class="form-control" name="relay_id" value="1" placeholder="Relay Id" aria-label="Name" aria-describedby="name-addon">
              {{-- <input class="form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)"> --}}
            </div>
          </div>
        </div>
    
        <hr class="horizontal dark">
        {{-- <p class="text-uppercase text-sm">Contact Information</p> --}}
        
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="duration_hour" class="form-control-label">Hours</label>
              <input min="0" type="text" class="form-control" name="duration_hour" value="0" placeholder="Hours">
              {{-- <input class="form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)"> --}}
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                  <label for="duration_minute" class="form-control-label">Minutes</label>
                  <input min="0" type="text" class="form-control" name="duration_minute" value="0" placeholder="Minutes">
                  {{-- <input class="form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)"> --}}
                </div>
              </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                  <label for="duration_second" class="form-control-label">Seconds</label>
                  <input min="0" type="text" class="form-control" name="duration_second" value="5" placeholder="Seconds">
                  {{-- <input class="form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)"> --}}
                </div>
              </div>
        </div>
        
    
        <div class="text-center">
          <button type="submit" name="submit" class="btn btn-success btn-lg btn-rounded w-100 mt-4 mb-0">Set Now</button>
        </div>
    </div>
</div>
</div>

    @if ($timers->isEmpty())
        <p>No timers found.</p>
    @else
        <ul>
            @foreach ($timers as $timer)
                @if ($timer->end_time && $timer->getRemainingTime() > 0)
                <div class="col-lg-8 mt-4">    
                    <div class="card py-4 px-8">
                <li id="timer-{{ $timer->timer_id }}">
                        <div class="clock">
                            <span class="clock-hour">{{ $timer->getRemainingHours() }}</span> hours
                            <span class="clock-minute">{{ $timer->getRemainingMinutes() }}</span> minutes
                            <span class="clock-second">{{ $timer->getRemainingSeconds() }}</span> seconds remaining
                        </div>
                        <form action="{{ route('timers.cancel', $timer) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-lg btn-rounded w-100 mt-4 mb-0">Cancel</button>
                        </form>
                    </li>
                </div>
                </div>
                    <script>
                        var timerElement = document.getElementById('timer-{{ $timer->timer_id }}');
                        var clockHour = timerElement.querySelector('.clock-hour');
                        var clockMinute = timerElement.querySelector('.clock-minute');
                        var clockSecond = timerElement.querySelector('.clock-second');
                        var remainingTime = {
                            hours: {{ $timer->getRemainingHours() }},
                            minutes: {{ $timer->getRemainingMinutes() }},
                            seconds: {{ $timer->getRemainingSeconds() }} 
                        };

                        function countdown() {
                            if (remainingTime.seconds > 0) {
                                remainingTime.seconds--;
                            } else {
                                if (remainingTime.minutes > 0) {
                                    remainingTime.minutes--;
                                    remainingTime.seconds = 59;
                                } else {
                                    if (remainingTime.hours > 0) {
                                        remainingTime.hours--;
                                        remainingTime.minutes = 59;
                                        remainingTime.seconds = 59;
                                    } else {
                                        clearInterval(timerInterval);
                                        updateSwitch('{{ route('timers.updateSwitch', $timer) }}');
                                        timerElement.parentNode.removeChild(timerElement);
                                    }
                                }
                            }

                            clockHour.textContent = remainingTime.hours;
                            clockMinute.textContent = remainingTime.minutes;
                            clockSecond.textContent = remainingTime.seconds;
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

                        var timerInterval = setInterval(countdown, 1000);
                    </script>
                @endif
            @endforeach
        </ul>
    @endif
</div>
</div>
@endsection
