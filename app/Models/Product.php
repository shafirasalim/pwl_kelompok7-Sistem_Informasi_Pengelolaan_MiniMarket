<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Product extends Model
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = ['name', 'price'];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}