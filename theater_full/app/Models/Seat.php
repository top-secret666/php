<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = ['seat_section_id', 'label', 'row', 'number', 'attributes'];

    protected $casts = [
        'attributes' => 'array',
    ];

    public function section()
    {
        return $this->belongsTo(SeatSection::class, 'seat_section_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
