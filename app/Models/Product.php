<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
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
