<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Booking model - represents customer vehicle rental bookings
 * 
 * @property int $id
 * @property int $user_id
 * @property int $vehicle_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property int $total_price - Calculated: days * vehicle daily price (minimum 1 day)
 * @property string $status - pending|confirmed|completed|cancelled
 * @property string $note - Customer notes/requests
 * 
 * @property User $user
 * @property Vehicle $vehicle
 * @property Review $review
 */
class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'note'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}