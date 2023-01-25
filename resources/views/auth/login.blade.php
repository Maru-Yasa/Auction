@extends('layouts.auth')

@section('title')
    Login
@endsection

@section('content')
    
<div class="row justify-content-center">
    <div class="row w-100 justify-content-center align-items-center" style="height: 100vh">
        <div class="col-md-5 col-11 card row shadow-5">
            <div class="card-header">
                <h1 class=""><i class="fa fa-user"></i> Login</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('login') }}" method="POST" action="">
                    @csrf
                    <div class="mb-3 form-group form-floating-label">
                        <input name="username" id="inputFloatingLabel" type="text" class="form-control input-border-bottom @error('username') is-invalid @enderror" required="" value="{{ old('username') }}">
                        <label for="inputFloatingLabel" class="placeholder">Username</label>
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
    
                    <div class="mb-3 form-group form-floating-label">
                        <input name="password" id="inputFloatingLabel" type="password" class="form-control input-border-bottom @error('password') is-invalid @enderror" required="">
                        <label for="inputFloatingLabel" class="placeholder">Password</label>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <button class="btn btn-primary">Login</button>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-border">Register</a>
                    </div>
    
                </form>
            </div>
        </div>
    </div>
</div>




@endsection