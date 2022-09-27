<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;
    protected $connection = 'eg_product';
    protected $table='manufacturers';
    public function products()
    {
        return $this->hasOne(Product::class);
    }
    public function info()
    {
        return $this->hasOne(Info::class);
    }
    public function scopeActive($query)
    {
        return $query->where('active',1);
    }
    public function scopeNew($query)
    {
        return $query->where('is_new', 1);
    }
}
