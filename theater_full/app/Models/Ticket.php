<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['performance_id','seat_id','order_id','purchaser_id','price','status','qr_code','issued_at','checked_in_at'];

    protected $casts = [
        'issued_at' => 'datetime',
        'checked_in_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function performance()
    {
        return $this->belongsTo(Performance::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function purchaser()
    {
        return $this->belongsTo(User::class, 'purchaser_id');
    }
}
