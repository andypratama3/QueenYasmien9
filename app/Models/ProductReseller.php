<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReseller extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'products_reseller';

    protected $fillable = [
        'product_id',
        'name',
        'price_reseller',
        'jumlah',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
