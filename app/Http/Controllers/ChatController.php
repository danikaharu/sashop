<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class ChatController extends Controller
{
    public function chat()
    {
        $user = Auth::user();
        $messages = Message::where('user_id', $user->id)
            ->orWhere('customer_id', $user->customer->id)
            ->orderBy('date', 'asc') // Mengurutkan berdasarkan tanggal, secara descending (dari yang paling terlama)
            ->get();


        $data = [
            'msg' => $messages
        ];
        return view('home.chat', $data);
    }

    public function getConversation($userId)
    {
        $user = User::find($userId);
        $messages = Message::where('user_id', $user->id)
            ->orWhere('customer_id', $user->customer->id)
            ->orderBy('date', 'asc') // Mengurutkan berdasarkan tanggal, secara descending (dari yang paling terlama)
            ->get();

        $data = [
            'user' => $user,
            'msg' => $messages,
            'users' => Customer::all(),
        ];
        return view('admin.usersCustomer.chat_detail', $data);

    }

    public function index()
    {
        $messages = Message::where('isAdmin', false)
            ->orderBy('date', 'desc')
            ->get()
            ->unique('user_id'); // Menghapus duplikat berdasarkan user_id


        $data = [
            'msg' => $messages,
            'users' => Customer::all(),
        ];
        return view('admin.usersCustomer.chat', $data);
    }

    public function submit(Request $request, $id)
    {
        $request->validate([
            'msg' => 'required' // 'msg' adalah nama field untuk pesan dalam permintaan
        ]);

        $user = Auth::user();
        $send = User::find($id);

        Message::create([
            'user_id' => $user->id,
            'customer_id' => $send->customer->id,
            'isAdmin' => $user->isAdmin,
            'msg' => $request->msg,
            'date' => Carbon::now('Asia/Makassar')
        ]);


        return redirect()->back();
    }

}
