<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    // Fillable fields for mass assignment
    protected $fillable = [
        'code',
        'name',
        'price',
        'model',
        'description',
        'photo',
        'quantity',
        'created_by', // To track which employee/admin added the product
    ];

    /**
     * Relationship: A product has many orders.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relationship: A product is added by an admin or employee (creator of the product).
     */
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Ensure `created_by` is always set when creating a product
    protected static function booted()
    {
        static::creating(function ($product) {
            // Automatically set the 'created_by' field with the currently authenticated user
            if (auth()->check()) {
                $product->created_by = auth()->id();
            }
        });
    }
}
