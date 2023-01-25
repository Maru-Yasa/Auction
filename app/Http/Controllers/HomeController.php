<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function index()
    {

        if (auth()->user()->role === 'admin' || auth()->user()->role === 'staff') {
            return view('index', [
                'users_count' => User::all()->count(),
                'items_count' => Item::all()->count(),
                'auctions_count' => Auction::all()->count(),
                'bids_count' => Bid::all()->count(),
            ]);
        }else {
            return view('profile', [
                'user' => auth()->user()
            ]);
        }

    }

}
