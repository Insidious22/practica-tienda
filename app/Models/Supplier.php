<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'tax_id',
        'business_name',
        'trade_name',
        'contact_name',
        'email',
        'phone',
        'phone_secondary',
        'address',
        'city',
        'payment_terms',
        'notes',
        'status',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'supplier_products')
            ->withPivot('supplier_sku', 'purchase_price', 'min_order_qty', 'lead_time_days', 'is_preferred', 'notes')
            ->withTimestamps();
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
