<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'photo',
    ];

    /**
     * Set the name attribute and auto-generate slug
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Get all ballroom spaces in this city
     */
    public function ballroomspaces(): HasMany
    {
        return $this->hasMany(ballroomspace::class);
    }

    /**
     * Get only available ballroom spaces in this city
     */
    public function availableBallroomspaces(): HasMany
    {
        return $this->hasMany(ballroomspace::class)->available();
    }

    /**
     * Get the photo URL
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
}
