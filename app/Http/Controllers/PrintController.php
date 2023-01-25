<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function index()
    {
        return view('laporan', [
            'data' => Auction::with(['item', 'user', 'bids.user'])->get(),
        ]);
    }
}
