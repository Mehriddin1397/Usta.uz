<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'master_id',
        'rating',
        'comment',
        'media_paths',
    ];

    protected $casts = [
        'media_paths' => 'array',
        'rating' => 'integer',
    ];

    /**
     * Get the order that the review belongs to.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user that wrote the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the master that the review is for.
     */
    public function master()
    {
        return $this->belongsTo(Master::class);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($review) {
            $review->master->updateRating();
        });

        static::updated(function ($review) {
            $review->master->updateRating();
        });

        static::deleted(function ($review) {
            $review->master->updateRating();
        });
    }

    /**
     * Get the media files for this review.
     */
    public function getMediaFiles()
    {
        return $this->media_paths ?? [];
    }

    /**
     * Add a media file to this review.
     */
    public function addMediaFile($path)
    {
        $mediaPaths = $this->media_paths ?? [];
        $mediaPaths[] = $path;
        $this->media_paths = $mediaPaths;
        $this->save();
    }
}
