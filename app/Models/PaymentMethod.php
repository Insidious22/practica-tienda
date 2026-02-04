<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
        'requires_reference',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'requires_reference' => 'boolean',
        ];
    }

    public function salesOrderPayments(): HasMany
    {
        return $this->hasMany(SalesOrderPayment::class);
    }
}
