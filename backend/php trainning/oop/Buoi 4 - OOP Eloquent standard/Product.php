<?php
require __DIR__ . '/Model.php';
class Product extends Model {
    protected $table = "products";
    public function getTable(){
        return $this->table;
    }
}