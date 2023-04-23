<?php
class Product extends Model {
    protected $table = "products";
    private $name;
    protected $fillable = [
        'name'
    ];

    public function comments(){
        return $this->hasMany(Brand::class,'product_id');
    }
}