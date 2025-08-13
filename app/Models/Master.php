<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'description',
        'experience_years',
        'rating',
        'reviews_count',
        'is_approved',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'is_approved' => 'boolean',
    ];

    /**
     * Get the user that owns the master profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that the master belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the works for the master.
     */
    public function works()
    {
        return $this->hasMany(Work::class);
    }

    /**
     * Get the orders for the master.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the reviews for the master.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Update master rating based on reviews.
     */
    public function updateRating()
    {
        $reviews = $this->reviews();
        $this->reviews_count = $reviews->count();
        $this->rating = $reviews->avg('rating') ?? 0;
        $this->save();
    }

    /**
     * Scope a query to only include approved masters.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope a query to filter by region.
     */
    public function scopeInRegion($query, $regionId)
    {
        return $query->whereHas('user', function ($q) use ($regionId) {
            $q->where('region_id', $regionId);
        });
    }
}
