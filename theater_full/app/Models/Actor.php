<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = ['full_name', 'bio', 'birth_date', 'photo_path'];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function shows()
    {
        return $this->belongsToMany(Show::class)->withPivot(['character_name','billing_order'])->withTimestamps();
    }
}
