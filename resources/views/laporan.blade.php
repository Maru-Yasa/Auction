@extends('layouts.blank')

@section('content')

    <div class="row w-100 justify-content-center ">

        <h1>Auction's Report</h1>

        <div class="table-responsive mx-5 px-3">
            <table class="table table table table-striped">
                <thead class="bg-dark text-light">
                    <tr>
                        <td>No</td>
                        <td>Item</td>
                        <td>Start Price</td>
                        <td>Best Offer</td>
                        <td>Bids Count</td>
                        <td>Best Bid by</td>
                        <td>Created by</td>
                        <td>Created at</td>
                        <td class="text-center">Status</td>
                    </tr>
                </thead>
                <tbody class="">
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
                            @if ($bestBid)
                                {{ $bestBid->count() }}
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
                @endforeach
                </tbody>
            </table>
        </div>
        

    </div>

@endsection