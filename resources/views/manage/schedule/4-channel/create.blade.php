<div class="card">
  <div class="card-header pb-0">
    {{-- @if ($errors->any())
    <pt-3>
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $item)
            <li>{{$item}}</li>
          @endforeach
        </ul>
      </div>
    </pt-3>
    @endif --}}
    <div class="d-flex align-items-center">
      <h6 class="mb-0">Add Schedule</h6>
      {{-- <button class="btn btn-primary btn-sm ms-auto">Add</button> --}}
    </div>
  </div>
  
  <div class="card-body">

  {{-- <p class="text-uppercase text-sm">User Information</p> --}}
  <form action='{{url('manage-schedule')}}' method='post' role="form text-left">
    @csrf

    <div class="row mt-1">
      <div class="col-md-12">
        <div class="form-group">
          <label for="example-text-input" class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Schedule Name</label>
          <input type="text" name="nama_schedule" class="form-control @if($errors->has('nama_schedule') || old('nama_schedule') === '') is-invalid @elseif($errors->any()) is-valid @endif" value="{{ old('nama_schedule') }}">

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
          <input step="1" type="time" name="time" class="form-control @if($errors->has('time') || old('time') === '') is-invalid @elseif($errors->any()) is-valid @endif" value="{{ old('time') }}">

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
          <input type="radio" id="status_hidup" name="status" value="1" checked>
          <label for="status_hidup">On</label>
          <input type="radio" id="status_mati" name="status" value="0">
          <label for="status_mati" class="red">Off</label>
        </div>
      </div>
    </div>
    
    {{-- <hr class="horizontal dark"> --}}

    <div class="form-group mt-2">
      <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Option</label>
      <div class="toggle-container">
        <input type="radio" name="option" value="once" id="option_today" required checked>
        <label class="toggle-option" for="option_today">Once</label>
        <input type="radio" name="option" value="repeat" id="option_repeat" required>
        <label class="toggle-option" for="option_repeat">Repeat</label>
      </div>
    </div>

    <div class="form-groupaa" id="repeat_days" style="display: none;">
      <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Select Day</label>
      <div class="toggle-container">
        <input type="checkbox" name="hari[]" value="sunday" id="sunday" />
        <label class="toggle-option" for="sunday">S</label>
        <input type="checkbox" name="hari[]" value="monday" id="monday" />
        <label class="toggle-option" for="monday">M</label>
        <input type="checkbox" name="hari[]" value="tuesday" id="tuesday" />
        <label class="toggle-option" for="tuesday">T</label>
        <input type="checkbox" name="hari[]" value="wednesday" id="wednesday" />
        <label class="toggle-option" for="wednesday">W</label>
        <input type="checkbox" name="hari[]" value="thursday" id="thursday" />
        <label class="toggle-option" for="thursday">T</label>
        <input type="checkbox" name="hari[]" value="friday" id="friday" />
        <label class="toggle-option" for="friday">F</label>
        <input type="checkbox" name="hari[]" value="saturday" id="saturday" />
        <label class="toggle-option" for="saturday">S</label>
      </div>
    </div>

    <div class="form-check mt-3 ms-2" id="repeat_weekly" style="display: none;">
      <label class="custom-control-label" for="repeat_weekly">Repeat Weekly</label>
      <input class="form-check-input" type="checkbox" name="repeat_weekly" id="repeat_weekly" checked>
    </div>

    <div class="text-center">
      <button type="submit" name="submit" class="btn btn-success btn-lg btn-rounded w-100 mt-3 mb-1">Set Now</button>
    </div>
</div>
