<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'invoice_id',
        'buyer_id',
        'status',
        'total_amount',
        'paid_amount',
        'has_coupon',
        'coupon_code',
        'coupon_amount',
        'transaction_id',
        'payment_method',
        'company',
        'address',
        'phone'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
