<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'city', 'postal_code', 'country', 'phone', 'email', 'seating_map'];

    protected $casts = [
        'seating_map' => 'array',
    ];

    public function shows()
    {
        return $this->hasMany(Show::class);
    }

    public function sections()
    {
        return $this->hasMany(SeatSection::class);
    }
}
