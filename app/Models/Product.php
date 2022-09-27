<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Product extends Model
{
    use HasFactory;
    protected $connection = 'eg_product';
    protected $table='products';

    public function reviews()
    {
        return $this
            ->hasMany(Review::class)
            ->orderBy('created_at', 'desc');
    }
    public function images()
    {
        return $this->hasMany(Image::class)->orderBy('id', 'desc');
    }
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
    public function price()
    {
        return $this->hasMany(Price::class);
    }
    public function scopeActive($query)
    {
        return $query->where('active', '=', 1);
    }
    public function scopeMain($query)
    {
        return $query->normal()->where('is_main', '=', 1);
    }
    public function scopeNormal($query)
    {
        return $query->where('type', 0);
    }
  
}
