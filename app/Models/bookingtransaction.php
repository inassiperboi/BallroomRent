<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTransaction extends Model
{
    protected $table = 'bookingtransactions';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone_number',
        'booking_trx',
        'ballroomspace_id',
        'total_amount',
        'duration',
        'started_at',
        'ended_at',
        'is_paid',
        'user_id',
    ];

    protected $casts = [
        'total_amount' => 'integer',
        'duration' => 'integer',
        'started_at' => 'date',
        'ended_at' => 'date',
        'is_paid' => 'boolean',
    ];

    /**
     * Get the ballroom space for this booking
     */
    public function ballroomspace(): BelongsTo
    {
        return $this->belongsTo(ballroomspace::class, 'ballroomspace_id');
    }

    /**
     * Get the user who made this booking (if applicable)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate unique booking transaction code
     */
// App\Models\BookingTransaction.php
protected static function booted()
{
    static::creating(function ($model) {
        if (empty($model->booking_trx_id)) {
            $model->booking_trx_id = 'TRX' . now()->format('YmdHis') . rand(100, 999);
        }
    });
}


    /**
     * Scope to get paid bookings only
     */
    public function scopePaid($query)
    {
        return $query->where('is_paid', true);
    }

    /**
     * Scope to get unpaid bookings only
     */
    public function scopeUnpaid($query)
    {
        return $query->where('is_paid', false);
    }

    /**
     * Check if booking is active (current date is between started_at and ended_at)
     */
    public function getIsActiveAttribute()
    {
        $now = now()->toDateString();
        return $now >= $this->started_at && $now <= $this->ended_at;
    }
}
