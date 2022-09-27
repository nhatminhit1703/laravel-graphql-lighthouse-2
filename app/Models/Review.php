<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $connection = 'ec_dbs';
    protected $table = 'reviews';
    protected $guarded  = array('id');
    protected $fillable = ['product_id','customer_id','nick_name','ranking','rating','title','content',
    'photo_key','motor_id','customer_ip','view_status','product_sku','product_manufacturer','product_manufacturer_id',
    'product_manufacturer_code','product_name','product_thumbnail','product_category','product_category_search','motor_name',
    'motor_manufacturer','motor_capacity','deleted_at','order_id','ref_type', 'note', 'country', 'country_name', 'image_path'
   ];

    public function customer(){
        return $this->belongsTo( Customer::class );
    }

    public function product(){
        return $this->belongsTo( Product::class );
    }
//    public function motor(){
//        return $this->belongsTo( Motor::class, 'motor_id', 'url_rewrite' );
//    }
    public function comments(){
        return $this->hasMany( ReviewComment::class )
            ->orderBy('created_at','desc');
    }

    public function publishedComments(){
        return $this->comments()->where('verify' , '1');
    }

    public function motors(){
        return $this->hasMany( ReviewMotor::class );
    }

    public function category(){
        return $this->belongsTo( Category::class, 'product_category');
    }

    public function manufacturer(){
        return $this->hasMany( Manufacturer::class, 'product_manufacturer_id');
    }

    public function images()
    {
        return $this->hasMany(ReviewImage::class, 'review_id', 'id');
    }
    /**
     * Scope review which is not deleted
     *
     * @param $query
     * @return QueryBuilder
     * @author nguyen_duy
     * @since 20180328
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Scope review active status
     *
     * @param $query
     * @return QueryBuilder
     * @author nguyen_duy
     * @since 20180328
     */
    public function scopeActiveViewStatus($query)
    {
        return $query->where('view_status', 1);
    }

    public function reviewMotor(){
        return $this->hasMany( ReviewMotor::class,'review_id','id');
    }

    public function fitModels()
    {
        return $this->hasMany(FitModel::class,'product_id','product_id');
    }

    public function translations() {
        return $this->hasMany(ReviewTranslation::class, 'review_id');
    }
    public function relationKeyProduct(){
        return $this->hasOne(Relation::class,'product_id','product_id');
    }
}
