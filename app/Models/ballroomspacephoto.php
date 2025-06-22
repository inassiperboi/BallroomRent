<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ballroomspacephoto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'photo',
        'ballroomspace_id',
    ];

    /**
     * Get the ballroom space that owns the photo
     */
    public function ballroomspace(): BelongsTo
    {
        return $this->belongsTo(ballroomspace::class, 'ballroomspace_id');
    }

    /**
     * Get the full URL for the photo
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
}
