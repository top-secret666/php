<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceStat extends Model
{
    use HasFactory;

    protected $fillable = ['performance_id','sold_tickets','revenue_cents','attendance_percentage'];

    protected $casts = [
        'sold_tickets' => 'integer',
        'revenue_cents' => 'integer',
        'attendance_percentage' => 'float',
    ];

    public function performance()
    {
        return $this->belongsTo(Performance::class);
    }
}
