<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;

    protected $fillable = ['show_id', 'starts_at', 'ends_at', 'status', 'notes'];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function stats()
    {
        return $this->hasOne(PerformanceStat::class);
    }
}
