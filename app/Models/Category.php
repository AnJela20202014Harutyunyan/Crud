<?php

namespace App\Models;

use App\Models\Category\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected $casts = [
        'created_at' => 'date:m-d-Y'
    ];


}
