<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model  
{
    protected $fillable = [
        'code',
        'name',
        'price',
        'model',
        'description',
        'photo',
        'stock',      // Added stock management
        'created_by', // To track which employee/admin added the product
    ];

    /**
     * Relationship: A product has many orders
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relationship: A product is added by an admin or employee
     */
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
