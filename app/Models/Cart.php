<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'barang_id',
        'qty',
        'harga',
        'total',
        'deskripsi',
        'transaction_id'
    ];

    public function menu()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
