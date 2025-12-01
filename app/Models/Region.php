<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the users for the region.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the masters in this region.
     */
    public function masters()
    {
        return $this->hasManyThrough(Master::class, User::class);
    }
    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
