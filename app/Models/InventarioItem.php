<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioItem extends Model
{
    protected $fillable = ['nombre', 'codigo_serie', 'cantidad'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}