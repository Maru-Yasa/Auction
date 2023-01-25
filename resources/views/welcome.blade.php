@extends('layouts.blank')

@section('title')
    Items
@endsection

@section('content')
<style type="text/css">
    .limit{
        width: 300px;
        height: 500px;
        max-height: 500px;
        overflow: hidden;
     }
    .limit img{
       width: 100%;
       height: 100%;
     }
 </style>
    
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <a href="/" class="logo">
                    <img src="/assets/img/logo.png" alt="navbar brand" class="navbar-brand">
                </a>                
                <h5 class="text-white op-7 mb-2">Auction made easy</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-white btn-border btn-round mr-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-round">Register</a>
                @endguest
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="card p-3 d-flex flex-row justify-content-between">
        @auth
            <div class="avatar-sm float-left mr-5 d-flex align-items-center">
                <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" alt="..." class="avatar-img avatar-md rounded-circle mr-2">
                {{ Auth::user()->name }}
            </div>

            <div class="">
                <a href="{{ route('home') }}" class="btn btn-round btn-primary">Home</a>
            </div>
        @endauth
        @guest
            <div class="avatar-sm float-left mr-5 d-flex align-items-center">
                <img src="{{ Avatar::create("Guest")->toBase64() }}" alt="..." class="avatar-img avatar-md rounded-circle mr-2">
                Guest
            </div>
            <div class="">
                <a href="{{ route('register') }}" class="btn btn-round btn-primary">register</a>
            </div>
        @endguest
    </div>

    <div class="row px-3 justify-content-center">

        {{-- <img class="card-img-top" src="{{ url('img/items/'.$auction->item->image) }}" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title mb-2 fw-mediumbold">{{ $auction->item->name }}</h5>
            <p class="card-text">
                {{ $auction->item->description }}
                <br>
                <span class=""><i class="fas fa-money-bill-wave text-success"></i> Best offer @currency($auction->best_offer)</span>
            </p>
            <a href="#" class="btn btn-primary d-block">See details</a>
        </div> --}}
        @foreach ($data as $auction)
            <div class="col-md-4 col-12 px-md-4 px-3 pb-md-3">
                <div class="card row flex-row">
                    <div class="col-12 p-3 d-flex align-items-center justify-content-between">
                        <div class="avatar-sm float-left mr-5 d-flex align-items-center">
                            <img src="{{ Avatar::create($auction->user->name)->toBase64() }}" alt="..." class="avatar-img avatar-sm rounded-circle mr-2">
                            {{ $auction->user->name }}
                        </div>

                        <span>{{ Carbon\Carbon::parse($auction->created_at)->format('d-m-Y') }}</span>
                    </div>
                    <div class="col-12 p-0">
                        <img class="w-100 rounded img-fluid" src="{{ url('img/items/'.$auction->item->image) }}" style="object-fit: cover;max-height: 250px" alt="Card image cap">
                    </div>
                    <div class="col px-2 py-2 d-flex flex-column">
                        <h1 class="fw-bold">{{ $auction->item->name }}</h1>

                        <div class="row px-3">
                            <div class="d-flex flex-md-row flex-column col-12 justify-content-between p-0">
                                <div class="">
                                    <label for="">Start Price</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-money-bill-wave text-success"></i></span>
                                        </div>
                                        <input type="text" class="form-control" readonly value="@currency($auction->item->start_price)" aria-describedby="basic-addon1">
                                    </div>
                                </div>
    
                                <div class="">
                                    <label for="">Best Offer</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-money-bill-wave text-success"></i></span>
                                        </div>
                                        <input type="text" class="form-control" readonly value="@currency($auction->best_offer)" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <textarea name="" id="" cols="100" rows="5" class="form-control col-12" readonly>
{{ $auction->item->description }}
                                </textarea>
                            </div>
                        </div>
                        <a href="{!! route('item_detail', $auction->item_id) !!}" class="btn btn-primary mt-auto">See details</a>                        
                    </div>
                </div>
            </div>
        @endforeach

    </div>

</div>


@endsection