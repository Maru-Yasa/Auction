@extends('layouts.blank')

@section('title')
    Item
@endsection

@section('content')

<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold"> <a href="javascript:history.back()"><i class="fas fa-arrow-left"></i></a> Item's Detail</h2>
                <h5 class="text-white op-7 mb-2">item's detail and place bid</h5>
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

    <div class="row">

        <div class="col-md-8 col-12 px-2">
            <div class="card p-3">
                <img class="w-100 rounded" src="{{ url('img/items/'.$data->item->image) }}" style="object-fit: cover" alt="Card image cap">
            </div>
        </div>

        <div class="col p-0">
            <div class="col-12 px-2">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="h1 fw-bold float-right text-warning" id="percent">+0%</div>
                        <h2 class="mb-2" id="bids_count">0</h2>
                        <p class="text-muted">Bids</p>
                        <div class="pull-in sparkline-fix">
                            <div id="lineChart"></div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="col-12 px-2">
                <div class="card">
                    <ul class="list-group" id="best_user_offer">
                    </ul>
                </div>
            </div>

            <div class="col-12 px-2">
                <div class="card p-3">
                    <div class="mb-3">
                        <h1>{{ $data->item->name }} <i class="fas fa-refresh"></i></h1>
                         <span class="text-muted" style="">{{ Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}</span>
                    </div>
                    <div class="d-flex flex-md-row flex-column col-12 justify-content-between p-0">
                        <div class="col-md-6 p-0 px-1">
                            <label for="">Start Price</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-money-bill-wave text-success"></i></span>
                                </div>
                                <input type="text" id="start_price" class="form-control" readonly value="@currency($data->item->start_price)" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        
                        <div class="col-md-6 p-0 px-1">
                            <label for="">Best Offer</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-money-bill-wave text-success"></i></span>
                                </div>
                                <input type="text" id="best_offer" class="form-control" readonly value="@currency($data->best_offer)" aria-describedby="basic-addon1">
                            </div>
                        </div>    
                    </div>  
                    <div class="col-12 p-0">
                        <div class="mb-3">
                            <textarea name="" id="" cols="100" rows="3" class="form-control col-12" readonly>{{ $data->item->description }}
                            </textarea>
                        </div>
                    </div>
                    
                    <form action="" id="place_bid_form">
                        <div class="form-group px-0">
                            <label for="">New bid</label>
                            <input type="text" id="auction_id" hidden value="{{ $data->id }}">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-money-bill-wave text-success"></i></span>
                                </div>
                                <input type="number" name="offer" placeholder="place bid here" class="form-control" value="@currency($data->best_offer)" aria-describedby="basic-addon1">
                            </div>  
                        </div>
                        <button type="submit" @if(Auth::user()->role != 'client') disabled @endif class="btn btn-primary mt-auto">Place bid</button>                        
                    </form>
                </div>
            </div>

        </div>

    </div>
    
</div>

@section('js')
    <script>
        var auction_id = $('#auction_id').val()

        const rupiah = (number)=>{
            return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
            }).format(number);
        }


        function getData() {
            $.ajax({
                'url': `{{ route('best_bid') }}?auction_id=${auction_id}`,
                'method': 'GET',
                success: (res) => {   
                    console.log('data fatched');
                    $('#best_offer').val(rupiah(res.data.auction.best_offer))
                    $("#best_user_offer").html("")
                    res.data.bids.forEach( bid => {
                        $("#best_user_offer").append(`
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <span>${bid.user.name}<span>    
                            </div>
                            <div>
                                <span>${rupiah(bid.offer)}<span>    
                            </div>
                        </li>
                        `)
                    })
                    $("#bids_count").html(res.data.offers.length)

                    if (res.data.offers.length > 1) {
                        let offerBest = res.data.offers[res.data.offers.length -1]
                        let offerSecondBest =  res.data.offers[res.data.offers.length -2]
                        let percent = ((offerBest - offerSecondBest) / offerSecondBest) * 100
                        $("#percent").html(`+${Math.floor(percent)}%`)
                    }


                    $('#lineChart').sparkline(res.data.offers, {
                        type: 'line',
                        height: '70',
                        width: '100%',
                        lineWidth: '2',
                        lineColor: '#ffa534',
                        fillColor: 'rgba(255, 165, 52, .14)'
                    });
                }
            });
        }


        getData()
        setInterval(() => {
            getData()
        }, 3000);






        $('#place_bid_form').off().on('submit', (e) => {
            e.preventDefault()
            console.log($(e.target)[0]);
            var formData = new FormData($(e.target)[0])
            var route = "{{ route('place_bid') }}"

            $("#place_bid_form button[type=submit]").prop('disabled', true)

            $.ajax({
                'method': 'POST',
                'url': `${route}?auction_id=${auction_id}`,
                'data': formData,   
                processData: false,
                contentType: false,
                cache: false,
                success: (res) => {
                    console.log(res);
                    if (res.status == false) {
                        $.notify({
                            // options
                            message: res.message,
                            icon: 'fas fa-exclamation-triangle'
                        },{
                            // settings
                            type: 'danger'
                        });
                    }else{
                        $('#best_offer').val(rupiah(res.data.best_offer))
                        $.notify({
                            // options
                            message: res.message,
                            icon: 'fas fa-money-check'
                        },{
                            // settings
                            type: 'success'
                        });
                    }
                },
                complete: () => {
                    $("#place_bid_form button[type=submit]").prop('disabled', false)
                }
            })

        })

    </script>
@endsection

@endsection