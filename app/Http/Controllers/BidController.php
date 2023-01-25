<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ItemNotFoundException;
use Intervention\Image\Exception\NotFoundException;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bids.list', [
            'data' => Bid::with(['user', 'auction'])->get(),
        ]);
    }

    public function detailItem($item_id)
    {
        try {            
            $data = Auction::with(['item', 'user'])->where('item_id', $item_id)->firstOrFail();
            $bids = Bid::with(['user'])->where('auction_id', $data->id)->orderBy('offer', 'DESC')->skip(0)->take(3)->get();
            return view('items.detail', [
                'data' => $data,
                'bids' => $bids
            ]);
        } catch (NotFoundException $th) {
            return redirect()->back();  
        }
    }

    public function detailItemAdmin($item_id)
    {
        try {            
            $data = Auction::with(['item', 'user'])->where('item_id', $item_id)->firstOrFail();
            $bids = Bid::with(['user'])->where('auction_id', $data->id)->orderBy('offer', 'DESC')->skip(0)->take(3)->get();
            return view('items.detail', [
                'data' => $data,
                'bids' => $bids
            ]);
        } catch (NotFoundException $th) {
            return redirect()->back();  
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'auction_id' => 'required',
                'offer' => 'required|numeric'
            ]);
    
            if ($validator->fails()) {
                return response([
                    'status' => false,
                    'message' => 'An error occured, please check again',
                    'messages' => $validator->errors(),
                    'data' => []
                ]);
            }
    
            if ($request->query('auction_id')) {
                $auction_id = $request->query('auction_id');
                try {
                    $auction = Auction::all()->where('id', $auction_id)->firstOrFail();
    
                    if ($auction->best_offer > $request->offer) {
                        return response([
                            'status' => false,
                            'message' => "Offer must higher than best offer",
                            'data' => []
                        ]);
                    }
    
                    $newBid = Bid::create([
                        'auction_id' => $auction_id,
                        'user_id' => auth()->user()->id,
                        'offer' => $request->offer
                    ]);

                    $auction->update([
                        'best_offer' => $newBid->offer,
                    ]);
    
                    return response([
                        'status' => true,
                        'message' => 'Success placing bid',
                        'data' => Auction::with(['item', 'user'])->where('id', $auction->id)->first()
                    ]);
    
                } catch (ItemNotFoundException $th) {
                    return response([
                        'status' => false,
                        'message' => $th->getMessage(),
                        'data' => []
                    ]);
                }
            }
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function show(Bid $bid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function edit(Bid $bid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bid $bid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bid $bid)
    {
        //
    }

    public function getBest(Request $request)
    {
        if ($request->ajax() && $request->query('auction_id')) {
            try {
                $bids = Bid::with(['user'])->where('auction_id', $request->query('auction_id'))->orderBy('offer', 'DESC')->skip(0)->take(3)->get();
                $auction = Auction::with(['item', 'user'])->where('id', $request->query('auction_id'))->firstOrFail();
                $offers = Bid::where('auction_id', $request->query('auction_id'))->orderBy('offer', 'ASC')->pluck('offer');
                return response([
                    'status' => true,
                    'data' => [
                        'bids' => $bids,
                        'auction' => $auction,
                        'offers' => $offers
                    ]
                ]);
            } catch (\Throwable $th) {
                return response([
                    'status' => false,
                    'message' => $th->getMessage()
                ]);
            }
        }
    }

}
