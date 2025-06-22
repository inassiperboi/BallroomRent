<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ballroomspace extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'city_id',
        'is_open',
        'is_full_booked',
        'price',
        'duration',
        'address',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'is_booked' => 'boolean',
        'price' => 'integer',
        'duration' => 'integer',
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
     * Get the photos for the ballroom space
     */
    public function photos(): HasMany
    {
        return $this->hasMany(ballroomspacephoto::class, 'ballroomspace_id');
    }

    /**
     * Get the benefits for the ballroom space
     */
    public function benefits(): HasMany
    {
        return $this->hasMany(ballroomspacebenefit::class, 'ballroomspace_id');
    }

    /**
     * Get the city that the ballroom space belongs to
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the booking transactions for this ballroom space
     */
    public function bookingTransactions(): HasMany
    {
        return $this->hasMany(BookingTransaction::class, 'ballroomspace_id');
    }

    /**
     * Scope to get only open ballroom spaces
     */
    public function scopeOpen($query)
    {
        return $query->where('is_open', true);
    }

    /**
     * Scope to get available ballroom spaces (open and not fully booked)
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_open', true)->where('is_booked', false);
    }

    /**
     * Get the thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }
}
