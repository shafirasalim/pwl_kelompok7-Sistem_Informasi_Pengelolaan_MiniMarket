<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditable;

class StockMovement extends Model
{
    use HasFactory, Auditable;

    protected $fillable = ['user_id', 'stock_id', 'type', 'quantity', 'movement_date'];

    protected $casts = [
        'movement_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}