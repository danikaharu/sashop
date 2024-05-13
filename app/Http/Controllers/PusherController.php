<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PusherController extends Controller
{
    public function broadcast(Request $request)
    {
        return view('broadcast', ['message' => $request->get('message')]);
    }
}
