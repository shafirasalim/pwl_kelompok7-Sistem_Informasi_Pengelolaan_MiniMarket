<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id', 'cashier_id', 'sale_date', 'total_price'];

    protected $casts = [
        'sale_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}