<?php
class BaseModel {
    private $table;
    private $pdo;
    public function __construct($table){
       $this->table = $table;
       $this->connectDatabase();
    }
    public function create($dataCreate){
        try {
            $key = array_keys($dataCreate);
            $columns = implode(", ", $key);

            $valueColumn = implode(", ", array_map(function ($k){
                return ":$k";
            }, $key));
            $sql = "INSERT INTO $this->table ($columns) VALUES ($valueColumn)";
            $statement = $this->pdo->prepare($sql);
            $statement->execute($dataCreate);
            $id = $this->pdo->lastInsertId();
            if($id){
                return $id;
            }
            return "Insert Fail";
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

    }
    public function connectDatabase(){
        $host = '127.0.0.1';
        $db   = 'oop';
        $user = 'root';
        $pass = '';
        $port = "3306";
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
        try {
            $this->pdo = new \PDO($dsn, $user, $pass);
            var_dump("Connect success");
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}