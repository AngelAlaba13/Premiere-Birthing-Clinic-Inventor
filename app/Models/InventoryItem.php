<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    protected $fillable = [
        'item_name',
        'in_display',
        'in_stock',
        'unit',
        'category_id',
    ];

    protected $appends = [
        'total_quantity',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function expiries(): HasMany
    {
        return $this->hasMany(InventoryExpiry::class);
    }

    public function getTotalQuantityAttribute(): int
    {
        return $this->in_display + $this->in_stock;
    }
}
