<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart_item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['cart_id', 'product_id'];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
        'id'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
