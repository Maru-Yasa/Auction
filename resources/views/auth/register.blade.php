@extends('layouts.auth')

@section('title')
    Register
@endsection

@section('content')
    
<div class="row justify-content-center">
    <div class="row w-100 justify-content-center align-items-center" style="height: 100vh">
        <div class="col-md-5 col-11 card row shadow-5">
            <div class="card-header">
                <h1 class=""><i class="fa fa-user-plus"></i> Register</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3 form-group form-floating-label">
                        <input name="name" id="inputFloatingLabel" type="text" class="form-control input-border-bottom @error('name') is-invalid @enderror" required="" value="{{ old('name') }}">
                        <label for="inputFloatingLabel" class="placeholder">Name</label>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3 form-group form-floating-label">
                        <input name="phone_number" id="inputFloatingLabel" type="text" class="form-control input-border-bottom @error('phone_number') is-invalid @enderror" required="" value="{{ old('phone_number') }}">
                        <label for="inputFloatingLabel" class="placeholder">Phone Number</label>
                        @error('phone_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

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

                    <div class="mb-3 form-group form-floating-label">
                        <input name="confirm_password" id="inputFloatingLabel" type="password" class="form-control input-border-bottom @error('password') is-invalid @enderror" required="">
                        <label for="inputFloatingLabel" class="placeholder">Confirm Password</label>
                        @error('password_confirm')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <button class="btn btn-primary">Register</button>
                        <a href="{{ route('login') }}"  class="btn btn-primary btn-link">already have an account?</a>
                    </div>
    
                </form>
            </div>
        </div>
    </div>
</div>




@endsection