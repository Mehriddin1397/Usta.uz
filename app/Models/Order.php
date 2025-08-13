<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'master_id',
        'description',
        'status',
        'completion_media',
        'completion_notes',
    ];

    protected $casts = [
        'completion_media' => 'array',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the master that the order belongs to.
     */
    public function master()
    {
        return $this->belongsTo(Master::class);
    }

    /**
     * Get the review for the order.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Scope a query to only include pending orders.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include accepted orders.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope a query to only include completed orders.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Mark order as accepted.
     */
    public function accept()
    {
        $this->status = 'accepted';
        $this->save();
    }

    /**
     * Mark order as in progress.
     */
    public function startProgress()
    {
        $this->status = 'in_progress';
        $this->save();
    }

    /**
     * Mark order as completed.
     */
    public function complete($media = null, $notes = null)
    {
        $this->status = 'completed';
        if ($media) {
            $this->completion_media = $media;
        }
        if ($notes) {
            $this->completion_notes = $notes;
        }
        $this->save();
    }

    /**
     * Mark order as cancelled.
     */
    public function cancel()
    {
        $this->status = 'cancelled';
        $this->save();
    }
}
