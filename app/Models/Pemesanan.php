<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pemesanan extends Model
{
    use HasUuids;

    protected $table = 'pemesanans';

    protected $fillable = [
        'pengiriman',
        'gross_amount',
        'status_pembayaran',
        'status_pemesanan',
        'user_id',
        'products_reseller_id',
        'alamat',
        'snap_token',
        'order_id',
        'slug',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products_reseller()
    {
        return $this->belongsTo(ProductReseller::class, 'products_reseller_id');
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_checkout', 'pemesanan_id', 'product_id')->withPivot('qty');
    }

}
