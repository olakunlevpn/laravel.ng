<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvatoPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain', 'verified_at', 'amount', 'sold_at', 'license',
        'support_amount', 'supported_until', 'item_id', 'item_name',
        'item_updated_at', 'item_site', 'price_cents', 'buyer','purchase_code'
    ];


}
