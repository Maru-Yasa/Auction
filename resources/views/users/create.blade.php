@extends('layouts.admin')

@section('content')
    
    <div class="m-5">
        <div class="mb-3">
            <h1>Create new user</h1>
        </div>
        <div class="card p-2">
    
            <form action="{{ route('users.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Name :</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>                    
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="">Username :</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" required value="{{ old('username') }}">
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>                    
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Role :</label>
                    <select name="role" id="select_rolw" class="form-control">
                        <option value="" disabled selected>-- Select Role --</option>
                        @foreach (['admin' => 'Admin', 'staff' => 'Staff', 'client' => 'Client'] as $key => $value)
                            <option value="{{ $key }}"
                            @if ($key == old('role'))
                                selected="selected"
                            @endif
                            >{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>                    
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="">Password :</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required value="{{ old('password') }}">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>                    
                    @enderror
                </div>
    
                <div class="form-group">
                    <button class="btn btn-primary">Submit</button>
                    <a href="{{ route('users.index') }}" class="btn btn-primary btn-link">Back</a>
                </div>
    
    
            </form>
    
        </div>
    </div>



@endsection
