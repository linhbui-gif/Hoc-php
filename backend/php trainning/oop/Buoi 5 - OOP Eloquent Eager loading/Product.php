<?php
require __DIR__ . '/Model.php';
require __DIR__ . '/Comment.php';
class Product extends Model {
    protected $table = "products";
    private $name;
    protected $fillable = [
        'name'
    ];
//    protected $primaryKey = 'product_id';
//    public function setName($name){
//        $this->name = $name;
//    }
//    /**
//     * @return mixed
//     */
//    public function getName()
//    {
//        return $this->name;
//    }
    public function comments(){
        return $this->hasMany(Brand::class,'product_id');
    }
}