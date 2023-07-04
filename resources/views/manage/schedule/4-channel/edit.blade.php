<div class="card">
        <div class="card-header pb-0 text-left">
          @if ($errors->any())
          <pt-3>
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $item)
                  <li>{{$item}}</li>
                @endforeach
              </ul>
            </div>
          </pt-3>

          @endif

          <div class="d-flex align-items-center">
            <p class="mb-0">Schedule Edit</p>
            {{-- <button class="btn btn-primary btn-sm ms-auto">Add</button> --}}
          </div>
        </div>
        
        <div class="card-body pb-3">
          <form id="editForm" action='{{url('manage-schedule/'. $edit_schedule->schedule_id)}}' method='post' role="form text-left">

            @csrf
            @method('PUT')
            
        
            <div class="row mt-1">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Schedule Name</label>
                  <input type="text" name="nama_schedule" class="form-control @if($errors->has('nama_schedule') || old('nama_schedule') === '') is-invalid @elseif($errors->any()) is-valid @endif" value="{{$edit_schedule->nama_schedule}}">

                  @error('nama_schedule')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
              </div>
            </div>
        
            {{-- <hr class="horizontal dark"> --}}
            {{-- <p class="text-uppercase text-sm">Contact Information</p> --}}
            
            <div class="row mt-2">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time</label>
                  <input step="1" type="time" name="time" class="form-control @if($errors->has('time') || old('time') === '') is-invalid @elseif($errors->any()) is-valid @endif" value="{{$time}}">

                  @error('time')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <label for="example-text-input" class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</label>
                <div class="toggle">
                  <input type="radio" id="status_hidup" name="status" value="1" <?php if ($edit_schedule->status == 1) echo 'checked'; ?>>
                  <label for="status_hidup">On</label>
                  <input type="radio" id="status_mati" name="status" value="0" <?php if ($edit_schedule->status == 0) echo 'checked'; ?>>
                  <label for="status_mati" class="red">Off</label>
                </div>
              </div>                
            </div>
            
            {{-- <hr class="horizontal dark"> --}}
        
            <div class="form-group mt-2">
              <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Option</label>
              <div class="toggle-container">
                <input type="radio" name="option" value="once" id="option_today" <?php if ($edit_schedule->schedule_condition == 'once') echo 'checked'; ?>>
                <label class="toggle-option" for="option_today">Once</label>
                <input type="radio" name="option" value="repeat" id="option_repeat" <?php if ($edit_schedule->schedule_condition == 'repeat') echo 'checked'; ?>>
                <label class="toggle-option" for="option_repeat">Repeat</label>
              </div>
            </div>
            
            <div class="form-groupaa mt-2" id="repeat_days" <?php if ($edit_schedule->schedule_condition != 'repeat') echo 'style="display: none;"'; ?>>
              <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Select Day</label>
              <div class="toggle-container">
                <?php
                use Carbon\Carbon;

                $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

                foreach ($days as $day) {
                    $isChecked = false;

                    foreach ($datetimeArray as $datetime) {
                        $tanggal = $datetime['tanggal'];
                        $dayOfWeek = Carbon::createFromFormat('Y-m-d', $tanggal)->locale('en')->dayName;

                        if ($dayOfWeek === $day) {
                            $isChecked = true;
                            break;
                        }
                    }

                    $shortDay = substr($day, 0, 1);
                    echo '<input type="checkbox" name="hari[]" value="' . strtolower($day) . '" id="' . strtolower($day) . '" ' . ($isChecked ? 'checked' : '') . ' />';
                    echo '<label class="toggle-option" for="' . strtolower($day) . '">' . $shortDay . '</label>';
                }
                ?>
              </div>
            </div>
            
            <div class="form-check mt-3 ms-2" id="repeat_weekly" <?php if ($edit_schedule->schedule_condition != 'repeat') echo 'style="display: none;"'; ?>>
              <label class="custom-control-label" for="repeat_weekly">Repeat Weekly</label>
              <input class="form-check-input" type="checkbox" name="repeat_weekly" id="repeat_weekly" <?php if ($edit_schedule->schedule_condition != 'once') echo 'checked'; ?>>
            </div>

            <div class="row">
              <div class="col-lg-6">
                  <div class="text-center">
                    <button type="button" class="btn btn-success btn-lg btn-rounded px-5 mt-4 mb-0 set-button">Set Now</button>
                  </div>
              </div>
              <div class="col-lg-6">
                  <div class="text-center">
                      <a href="{{url('manage-schedule/'.$device_id)}}" class="btn btn-danger btn-lg btn-rounded px-5 mt-4 mb-0">Cancel</a>
                  </div>
              </div>
          </div>
          </form>
        </div>
        
</div>


<script>
  document.addEventListener('DOMContentLoaded', function () {
  const editForm = document.getElementById('editForm');
  const setNowButton = document.querySelector('.set-button');

  editForm.addEventListener('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: 'Are you sure?',
      text: 'You are about to edit the schedule',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, edit it!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then(function (result) {
      if (result.isConfirmed) {
        editForm.submit();
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire('Cancelled', 'Schedule edit cancelled', 'info');
      }
    });
  });

  setNowButton.addEventListener('click', function (event) {
    event.preventDefault();

    Swal.fire({
      title: 'Are you sure?',
      text: 'You are about to set the schedule now',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, set it now!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then(function (result) {
      if (result.isConfirmed) {
        editForm.submit();
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire('Cancelled', 'Schedule set cancelled', 'info');
      }
    });
  });
});

</script>



