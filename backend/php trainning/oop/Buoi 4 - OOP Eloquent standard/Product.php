<?php
require __DIR__ . '/Model.php';
class Product extends Model {
    protected $table = "products";
    private $name;
    protected $fillable = [
        'name'
    ];
    protected $primaryKey = 'product_id';
    public function setName($name){
        $this->name = $name;
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}