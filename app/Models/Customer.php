<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;


    protected $fillable = ['user_id', 'phone', 'birth_date', 'address'];

    protected $casts = [
        'birth_date' => 'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function point()
    {
        return $this->hasOne(Point::class)->withDefault(['points' => 0]);
    }
}
