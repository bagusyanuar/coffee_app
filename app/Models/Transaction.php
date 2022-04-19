<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tanggal',
        'customer',
        'sub_total',
        'diskon',
        'total',
        'status'
    ];

    public function cart()
    {
        return $this->hasMany(Cart::class, 'transaction_id');
    }
}
