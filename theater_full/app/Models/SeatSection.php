<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatSection extends Model
{
    use HasFactory;

    protected $fillable = ['venue_id', 'name', 'description'];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
