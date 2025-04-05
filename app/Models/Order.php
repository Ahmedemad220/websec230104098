<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Fillable fields for mass assignment
    protected $fillable = ['user_id', 'product_id', 'price', 'status'];

    /**
     * Relationship: An order belongs to a single product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relationship: An order belongs to a single user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set the order's status.
     *
     * @param  string  $value
     * @return void
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }

    /**
     * Get the order's status.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return ucfirst($this->attributes['status']);
    }

    /**
     * Helper method to mark order as completed.
     */
    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->save();
    }

    /**
     * Helper method to mark order as cancelled.
     */
    public function markAsCancelled()
    {
        $this->status = 'cancelled';
        $this->save();
    }

    /**
     * Helper method to mark order as pending.
     */
    public function markAsPending()
    {
        $this->status = 'pending';
        $this->save();
    }
}
