<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceStat extends Model
{
    use HasFactory;

    protected $fillable = ['performance_id','date_calculated','tickets_sold','revenue','checked_in_count'];

    protected $casts = [
        'date_calculated' => 'date',
        'tickets_sold' => 'integer',
        'checked_in_count' => 'integer',
        'revenue' => 'decimal:2',
    ];

    public function performance()
    {
        return $this->belongsTo(Performance::class);
    }
}
