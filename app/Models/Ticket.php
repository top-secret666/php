<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['performance_id','seat_id','order_id','price_tier_id','status','qr_code'];

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

    public function priceTier()
    {
        return $this->belongsTo(PriceTier::class);
    }
}
