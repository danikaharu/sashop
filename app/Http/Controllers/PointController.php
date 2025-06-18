<?php

namespace App\Http\Controllers;

use App\Models\Poin;
use App\Models\Point;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index()
    {
        $daftarPoint = Transaction::where('customer_id', auth()->user()->customer->id)->where('total_payment', '!=', 0)->get();

        $point = Point::where('customer_id', auth()->user()->customer_id)->first();

        return view('home.list_point', compact('point', 'daftarPoint'));
    }
}
