<div class="card">
  <div class="card-header pb-0">
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
      <p class="mb-0">Add Schedule</p>
      {{-- <button class="btn btn-primary btn-sm ms-auto">Add</button> --}}
    </div>
  </div>
  
  <div class="card-body">

  {{-- <p class="text-uppercase text-sm">User Information</p> --}}
  <form action='{{url('manage-schedule')}}' method='post' role="form text-left">
    @csrf

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="example-text-input" class="form-control-label">Schedule Name</label>
          <input type="text" class="form-control" name="nama_schedule" value="{{ Session::get('nama_schedule')}}" placeholder="Schedule Name" aria-label="Name" aria-describedby="name-addon">
          {{-- <input class="form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)"> --}}
        </div>
      </div>
    </div>

    <hr class="horizontal dark">
    {{-- <p class="text-uppercase text-sm">Contact Information</p> --}}
    
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="example-text-input" class="form-control-label">Time</label>
          <input step="1" type="time" class="form-control" name="waktu1" value="{{ Session::get('waktu1')}}" placeholder="Time">
          {{-- <input class="form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)"> --}}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="example-text-input" class="form-control-label">Time 2</label>
          <input step="1" type="time" class="form-control" name="waktu2" value="{{ Session::get('waktu2')}}" placeholder="Time 2">
          {{-- <input class="form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)"> --}}
        </div>
      </div>
    </div>
    

    <hr class="horizontal dark">
    {{-- <p class="text-uppercase text-sm">About me</p> --}}
    
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="example-text-input" class="form-control-label">Date</label>
          <input type="date" class="form-control" name="tanggal1" value="{{ Session::get('tanggal1')}}" placeholder="Date">
          {{-- <input class="form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)"> --}}
        </div>
      </div>
      <div class="col-md-12" hidden>
        <div class="form-group">
          <label for="example-text-input" class="form-control-label">Relay Id</label>
          <input type="text" class="form-control" name="relay_id" value="1" placeholder="Date">
          {{-- <input class="form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)"> --}}
        </div>
      </div>
    </div>

    <div class="text-center">
      <button type="submit" name="submit" class="btn btn-success btn-lg btn-rounded w-100 mt-4 mb-0">Set Now</button>
    </div>
</div>
