<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'price', 'image'];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
        'id'
    ];

    public function getImageAttribute($value)
    {
        return url('storage/product/image/'.$value);
    }
}
