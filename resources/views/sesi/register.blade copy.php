@extends('layout.main')

@section('content')
  
    <div class="w-50 center border rounded px-3 py-3 mx-auto">
        @if (Session::has('success'))
        <div class="pt-3">
          <div class="alert alert-success">
            {{Session::get('success')}}
          </div>
        </div>
        @endif
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
        <h1>Register</h1>
        <form action="{{url('sesi/create')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ Session::get('name')}}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ Session::get('email')}}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" value="{{ Session::get('password')}}">
            </div>
            <div class="mb-3 d-grid">
                <button class="btn btn-primary" type="submit" name="submit">Register</button >
            </div>
        </form>
    </div>
@endsection