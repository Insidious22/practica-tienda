<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryMovementType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'direction',
        'affects_stock',
        'requires_reference',
        'is_system',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'affects_stock' => 'boolean',
            'requires_reference' => 'boolean',
            'is_system' => 'boolean',
        ];
    }

    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class, 'movement_type_id');
    }

    public function isIncoming(): bool
    {
        return $this->direction === 'in';
    }

    public function isOutgoing(): bool
    {
        return $this->direction === 'out';
    }
}
