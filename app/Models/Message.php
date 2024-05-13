<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','customer_id', 'isAdmin', 'date', 'msg'
    ];

    public function user( )
    {
        return $this->belongsTo(User::class);
    }

    public function customer( )
    {
        return $this->belongsTo(Customer::class);
    }

}
