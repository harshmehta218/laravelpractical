<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = ['user_id'];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
        'id'
    ];

    public function CartItems()
    {
        return $this->hasMany(Cart_item::class);
    }
}
