<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_number',
        'source_zone_id',
        'target_zone_id',
        'status',
        'user_id',
        'approved_by',
        'approved_at',
        'received_by',
        'received_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
            'received_at' => 'datetime',
        ];
    }

    public function sourceZone(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'source_zone_id');
    }

    public function targetZone(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'target_zone_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function receivedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InventoryTransferItem::class);
    }
}
