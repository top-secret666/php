<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = ['section_id', 'row', 'number', 'seat_type', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(SeatSection::class, 'section_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
