<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'master_id',
        'title',
        'description',
        'media_paths',
    ];

    protected $casts = [
        'media_paths' => 'array',
    ];

    /**
     * Get the master that owns the work.
     */
    public function master()
    {
        return $this->belongsTo(Master::class);
    }

    /**
     * Get the media files for this work.
     */
    public function getMediaFiles()
    {
        return $this->media_paths ?? [];
    }

    /**
     * Add a media file to this work.
     */
    public function addMediaFile($path)
    {
        $mediaPaths = $this->media_paths ?? [];
        $mediaPaths[] = $path;
        $this->media_paths = $mediaPaths;
        $this->save();
    }
}
