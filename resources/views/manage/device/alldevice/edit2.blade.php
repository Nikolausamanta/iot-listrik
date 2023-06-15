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

            <form action='{{url('manage-device/'. $edit_device->device_id)}}' method='post' role="form text-left">
              @csrf
              @method('PUT')
              
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Schedule Name</label>
                    <input type="text" class="form-control" name="nama_schedule" value="{{$edit_device->nama_schedule}}" placeholder="Schedule Name" aria-label="Name" aria-describedby="name-addon">
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
                    <input step="1" type="time" class="form-control" name="waktu1" value="{{$edit_device->nama_schedule}}" placeholder="Time">
                    {{-- <input class="form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)"> --}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Time 2</label>
                    <input step="1" type="time" class="form-control" name="waktu2" value="{{$edit_device->nama_schedule}}}" placeholder="Time">
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
                    <input type="date" class="form-control" name="tanggal1" value="{{$tanggal1}}" placeholder="Date">
                    {{-- <input class="form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)"> --}}
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-lg-6">
                    <div class="text-center">
                      <button type="submit" name="submit" class="btn btn-success btn-lg btn-rounded px-5 mt-4 mb-0">Set</button>
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