@extends('layouts.admin')

@section('content')
    
    <div class="m-5">
        <div class="mb-3">
            <h1>Create new item</h1>
        </div>
        <div class="card p-2">
    
            <form action="{{ route('items.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="">Name :</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>                    
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Start price :</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                        </div>
                        <input type="number" name="start_price" class="form-control @error('start_price') is-invalid @enderror" aria-describedby="basic-addon1">
                    </div>
                    @error('start_price')
                        <span class="text-danger">{{ $message }}</span>                    
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Image :</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" required">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>                    
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="">Description :</label>
                    <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>                    
                    @enderror
                </div>
    
                <div class="form-group">
                    <button class="btn btn-primary">Submit</button>
                    <a href="{{ route('items.index') }}" class="btn btn-primary btn-link">Back</a>
                </div>
    
    
            </form>
    
        </div>
    </div>



@endsection
