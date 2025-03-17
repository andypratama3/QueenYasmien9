<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasUuids;
    protected $table = 'products';

    protected $fillable = [
        'name',
        'category_id',
        'stock',
        'sell_count',
        'desc',
        'foto',
        'price',
        'price_reseller',
        'slug',
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product_reseller(): HasMany
    {
        return $this->hasMany(ProductReseller::class, 'product_id', 'id');
    }

    public function pemesanan(): BelongsToMany
    {
        return $this->belongsToMany(Pemesanan::class, 'product_checkout');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
