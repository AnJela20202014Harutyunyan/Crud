<?php

namespace App\Models\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'price',
        'status',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected $casts = [
        'created_at' => 'date:m-d-Y'
    ];


}


