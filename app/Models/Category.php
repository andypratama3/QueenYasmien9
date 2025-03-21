<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];



    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

}
