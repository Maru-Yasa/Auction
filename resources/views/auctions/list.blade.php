@extends('layouts.admin')

@section('content')
    
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-auctions-left align-auctions-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Auctions</h2>
                        <h5 class="text-white op-7 mb-2">Manage data auctions</h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <button id="print" class="btn btn-primary btn-round"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            @if (Session::has('success'))
                <div class="alert alert-success mb-3" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger mb-3" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif
            <div class="table-responsive card p-3">
                <table id="data_table" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <td>No</td>
                            <td>Item</td>
                            <td>Start Price</td>
                            <td>Best Offer</td>
                            <td>Bids Count</td>
                            <td>Best Bid by</td>
                            <td>Created by</td>
                            <td>Created at</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
    
                        @foreach ($data as $auction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $auction->item->name }}</td>
                                <td class="text-start">@currency($auction->item->start_price)</td>
                                @php
                                   $bestBid =  $auction->bids->where('offer', $auction->best_offer)->first();
                                @endphp
                                <td class="text-start">
                                    @currency($auction->best_offer) 
                                </td>
                                <td class="text-center">
                                    @if ($auction->bids)
                                        {{ $auction->bids->count() }}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="">
                                    <div class="d-flex align-items-center">
                                        @if ($bestBid)
                                            <div class="avatar-sm mr-2">
                                                <img src="{{ Avatar::create($bestBid->user->name)->toBase64() }}" alt="..." class="avatar-img rounded-circle">
                                            </div> 
                                            {{ $bestBid->user->name }} 
                                        @else
                                            -
                                        @endif
                                    </div>
                                </td>
                                <td class="d-flex align-items-center">
                                    <div class="avatar-sm mr-2">
                                        <img src="{{ Avatar::create($auction->user->name)->toBase64() }}" alt="..." class="avatar-img rounded-circle">
                                    </div> 
                                    {{ $auction->user->username }}
                                </td>
                                <td>{{ $auction->created_at }}</td>
                                <td class="text-center">
                                    @if ($auction->status === 'close')
                                        <i class="fa fa-circle text-danger"></i>
                                    @else
                                        <i class="fa fa-circle text-success"></i>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-primary btn-round mr-2"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('item_detail_admin', $auction->item->id) }}" class="btn btn-success btn-round mr-2"><i class="fas fa-eye"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
    
                    </tbody>
                </table>
            </div>
            
        </div>


        <iframe hidden id="iframe" src="{{ route('print_auction') }}" name="iframe" frameborder="0" class="col-12"></iframe>


    @section('js')

        <script>
            $('#data_table').DataTable()

            
            $("#print").off().on('click', (e) => {
                e.preventDefault()
                window.frames["iframe"].focus();
                window.frames["iframe"].print();
                console.log(e);
            })


        </script>

    @endsection


@endsection