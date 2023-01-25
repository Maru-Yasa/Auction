@extends('layouts.admin')

@section('content')
    

<div class="m-5">
    <div class="mb-3">
        <h1>Edit auction</h1>
    </div>
    <div class="card p-2">

        <form action="{{ route('auctions.update', $data->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
 
            <div class="form-group">
                <label for="">Status :</label>
                <select name="status" id="select_rolw" class="form-control">
                    <option value="" disabled selected>-- Select Role --</option>
                    @foreach (['close' => 'Close', 'open' => 'Open'] as $key => $value)
                        <option value="{{ $key }}"
                        @if ($key == $data->status)
                            selected="selected"
                        @endif
                        >{{ $value }}</option>
                    @endforeach
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}</span>                    
                @enderror
            </div>

            <div class="form-group">
                <button class="btn btn-primary">Submit</button>
                <a href="{{ route('auctions.index') }}" class="btn btn-primary btn-link">Back</a>
            </div>



        </form>

    </div>
</div>

@endsection
