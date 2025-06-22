<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ballroomspacebenefit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'ballroomspace_id',
    ];

    /**
     * Get the ballroom space that owns the benefit
     */
    public function ballroomspace(): BelongsTo
    {
        return $this->belongsTo(ballroomspace::class, 'ballroomspace_id');
    }
}
