<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'director', 'description', 'duration_minutes', 'language', 'age_rating', 'venue_id', 'poster_url', 'status'
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function performances()
    {
        return $this->hasMany(Performance::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class)->withPivot(['character_name','billing_order'])->withTimestamps();
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
