<?php
class Model {
   protected $table;
   private $pdo;
   private $where = [];
   private $select = null;
   private $groupBy = null;
   private $orderBy = null;
   private $having = null;
   private $limit = null;
   private $offset = null;
   private $join = [];
   protected $primaryKey = 'id';
   protected $attribuite = [];
   protected $fillable;
   private $oneToMany = [];
   //set chạy khi 1 thuộc tính troing modal không tồn tại ==> magic setter ==> Cach 1
   public function __set($name,$value){
      $this->attribuite[$name] = $value;
   }
    public function __get($name){
        $this->$name();
    }
    public function __construct(){
        $this->pdo = $this->connectDatabase();
    }
    public function insert($data)
   {
       //$sql = "INSERT INTO users (name, surname, age) VALUES (?,?,?)"
       // output:  string -> [] -> string
       $columnKey = array_keys($data);
       $columns = implode(', ',$columnKey);
       $playHolderSql = array_map(function ($item){
           return ":$item";
       }, $columnKey);
       $playHolderSql = implode(", ", $playHolderSql);
       $sql = "INSERT INTO $this->table ($columns) VALUES ($playHolderSql)";
       $stmt= $this->pdo->prepare($sql);
       $dataExcute = $stmt->execute($data);
       if($dataExcute){
           $lastInsertID =  $this->pdo->lastInsertId();
       }
       if($lastInsertID){
           return $lastInsertID;
       }
       return false;
   }
   //Cach lam 1  sử dụng ? ? ? phải đưa vào đúng thứ tự
//   public function update($data){
//       $table = $this->table;
//       // placeholder column
//       $tmpKey = [];
//       $dataExcute = [];
//       foreach($data as $key => $value) {
//           $tmpKey[] = $key . ' = ?';
//           $dataExcute[] = $value;
//       }
//       $columns = implode(', ', $tmpKey);
//
//       // placeholder where
//       $tmpWhere = [];
//       foreach($this->where as $valueWhere) {
//           $tmpWhere[] = $valueWhere['column'] . ' ' . $valueWhere['operator'] . ' ?';
//           $dataExcute[] = $valueWhere['value'];
//       }
//       $where = implode(' and ', $tmpWhere);
//       $sql = "UPDATE $table SET $columns WHERE";
//       if($this->where){
//           $sql .= $where;
//       }
//       $sql = "UPDATE $table SET $columns WHERE $where";
//       $stmt = $this->pdo->prepare($sql);
//       // thuc thi sql
//       $stmt->execute($dataExcute);
//   }
    //cACH LÀM 2 Sử dụng :name,.... https://phpdelusions.net/pdo_examples/update ==> không cần đưa vào đúng thứ tự
    public function update($data){
        $table = $this->table;
        $tmpKey = [];
        $dataExcute = [];
        foreach($data as $key => $value) {
            $tmpKey[] = $key . "=". ":$key";
            $dataExcute[$key] = $value;
        }
        $columns = implode(', ', $tmpKey);
        $tmpWhere = [];
        foreach($this->where as $key => $valueWhere) {
           $keyWhere = 'where_' . $key;
           $tmpWhere[] = $valueWhere['column'] . $valueWhere['operator']  . ':'. $keyWhere; // sau dau : ten la gi cung duoc
           $dataExcute[$keyWhere] = $valueWhere['value'];
       }
        $where = implode(' and ', $tmpWhere);
        $sql = "UPDATE $table SET $columns WHERE";
       if($this->where){
           $sql .= $where;
       }
        $sql = "UPDATE $table SET $columns WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($dataExcute);
    }
    public function delete(){
        $tmpWhere = [];
        foreach($this->where as $key => $valueWhere) {
            $keyWhere = 'where_' . $key;
            $tmpWhere[] = $valueWhere['column'] . $valueWhere['operator']  . ':'. $keyWhere; // sau dau : ten la gi cung duoc
            $dataExcute[$keyWhere] = $valueWhere['value'];
        }
        $where = implode(' and ', $tmpWhere);
        $sql = "DELETE FROM $this->table  WHERE";
        if($this->where){
            $sql .= $where;
        }
        $sql = "DELETE FROM $this->table  WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($dataExcute);
    }
    public function get(){
        $dataWhere = [];
        $sql = "SELECT ";
        if($this->select){
            $sql .=  $this->select . ' FROM ' . $this->table;
        }
        //Join
        if($this->join){
            foreach($this->join as $join){
                $sql .= ' ' . $join['type'] . ' JOIN ' . $join['tableJoin'] . ' ON ' . $join['condition'];
            }
        }
        //where
        if($this->where){
           list($where,$dataWhere) = $this->whereAnd();// giong destructring asign ment
            $sql .= ' WHERE ' .  $where;
        }
       //Group By
        if($this->groupBy){
            $sql .= ' GROUP BY ' .  $this->groupBy;
        }
        //Order By
        if($this->orderBy){
            $sql .= ' ORDER BY ' .  $this->orderBy;
        }
        //Having
        if($this->having){
            $sql .= ' HAVING ' .  $this->having;
        }
        //limit
        if(is_numeric($this->limit)){
            if(is_numeric($this->offset)){
                $sql .= ' LIMIT ' . $this->offset . ', ' . $this->limit ;
            } else {
                $sql .= ' LIMIT ' . $this->limit ;
            }
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($dataWhere);
        //Lấy data của bảng chính
        $dataMain = $stmt->fetchAll(PDO::FETCH_OBJ);
        if($this->oneToMany){
            foreach ($this->oneToMany as $oneToManyItem){
                $oneToMany = new HasOneToMany();
                $dataRelation = $oneToMany->oneToMany($dataMain, $oneToManyItem, $this->pdo, $this->primaryKey);
//                echo "<pre>";
//                var_dump($dataRelation);
                //choox nay van đang lỗi
                $normalData = new NormalizeData();
                $data = $normalData->normalData($dataRelation, $dataMain,$oneToManyItem);
                return $data;
            }
        }
        return $dataMain;
    }
    public function limit($limit, $offset) {
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }
    public function join($tableJoin, $condition){
          $this->join[] = [
              'type' => 'INNER',
              'tableJoin' => $tableJoin,
              'condition' => $condition
          ];
          return $this;
    }
    private function whereAnd(){
        $tmpWhere = [];
        $dataWhere = [];
        foreach($this->where as $key => $valueWhere) {
            $keyWhere = 'where_' . $key;
            $tmpWhere[] = $valueWhere['column'] . $valueWhere['operator']  . ':'. $keyWhere; // sau dau : ten la gi cung duoc
            $dataWhere[$keyWhere] = $valueWhere['value'];
        }
        $where = implode(' and ', $tmpWhere);
        return [$where,$dataWhere];
    }
    public function select($select){
        if ($select){
            $this->select = $select;
        } else {
            $this->select = "*";
        }
        return $this;
    }
    public function groupBy($groupBy){
        if ($groupBy){
            $this->groupBy = $groupBy;
        }
        return $this;
    }
    public function orderBy($orderBy){
        if ($orderBy){
            $this->orderBy = $orderBy;
        }
        return $this;
    }
    public function having($having){
        if ($having){
            $this->having = $having;
        }
        return $this;
    }
    public function where(){
        $numArg = func_num_args();
        $args = func_get_args();
        if($numArg == 2){
            $column = $args[0];
            $operator = "=";
            $value = $args[1];
        } elseif($numArg == 3){
            $column = $args[0];
            $operator = $args[1];
            $value = $args[2];
        } else{
            $column = null;
            $operator = null;
            $value = null;
        }
        $this->where[]= [
             'column' => $column,
             'operator' => $operator,
             'value' => $value,
        ];
        //trainning method dùng để gọi lại function đó nhiều lần thì phải return this;
      return $this;
   }
   public function whereArray($conditionArray){

        //xu ly cho mang 2 chieu
        if (is_array($conditionArray) && count($conditionArray) === 1){
            $conditionArray = [$conditionArray];
        }
        foreach ($conditionArray as $k => $itemArr){

            if (!empty($itemArr)) {
                list($column,$operator,$value) = $itemArr;
                $this->where[]= [
                    'column' => $column,
                    'operator' => $operator,
                    'value' => $value,
                ];
            }
        }
        return $this;
   }
    public function connectDatabase(){
        $host = '127.0.0.1';
        $db   = 'example';
        $user = 'root';
        $pass = '';
        $port = "3307";
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
        try {
            return new \PDO($dsn, $user, $pass);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    /**
     * Build First laays 1 ban ghi
     * Build find tìm theo ID
     */
    public function save($model)
    {
        //Cach 1 dung magic setter
        $this->insert($this->attribuite);
        //Cach 2 dung getter setter binh thuong
//        $dataColumn = $this->fillable;
//       foreach($dataColumn as $k => $column){
//           $getter = 'get'. ucfirst($column);
//           $value = $model->$getter();
//           $this->attribuite[$column] = $value;
//       }
//       $this->insert($this->attribuite);
    }
    public function hasMany($className, $foreignKey){
        //trainning method
       $classInstance = new $className();
       $tableRelation = $classInstance->table;
       $this->oneToMany[] = [
           "tableRelation" => $tableRelation,
           "foreignKey" => $foreignKey,
       ];
       return $this;
    }
    public function manyToMany(){
       // product -> tags
        //1 Lấy ra tất cả san pham - query chinh
        $productSql = "SELECT * FROM products";

        $stmt = $this->pdo->prepare($productSql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);

        $idProducts = [];
        foreach ($products as $productItem) {
            $idProducts[] = $productItem->id;
        }
        $idProducts = implode(", ", $idProducts);
        //2 Query bảng phụ đưa vào bảng chính
        $sqlTags = "SELECT * FROM tags INNER JOIN product_tag ON tags.id WHERE product_tag.product_id IN ($idProducts)";
        $stmt = $this->pdo->prepare($sqlTags);
        $stmt->execute();
        $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
        $tagGroupByProduct = [];
        foreach ($tags as $tagItem) {
            $key = $tagItem->id;
            $tagGroupByProduct[$key][] = $tagItem;
        }
        foreach ($products as $productItem) {
            $productItem->tags = $tagGroupByProduct[$productItem->id] ?? [];
        }
        echo "<pre>";
        print_r($products);
        echo "<hr/>";
    }
    public function oneToMany(){
        // 3 category -> N -> N + 1 -> 2

        //1 Lấy ra tất cả danh mục
        $categorieSql = "SELECT * FROM categories";
        // 2 lấy sản phẩm thuộc danh mục

        $stmt = $this->pdo->prepare($categorieSql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
        $idCategory = [];
        foreach ($categories as $k => $categoryItem){
            $idCategory[] = $categoryItem->id;
        }
        $idCategoryImplode = implode(", ", $idCategory);
        $sqlProducts = "SELECT * FROM products WHERE category_id IN ($idCategoryImplode)";
        $stmt = $this->pdo->prepare($sqlProducts);
        $stmt->execute();
        // thuc thi sql
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $productGroupByCategory = [];
        foreach($products as $productItem) {
            $key = $productItem->category_id;
            $productGroupByCategory[$key][] = $productItem;
        }
        foreach($categories as $categoryItem) {
            $categoryItem->product = $productGroupByCategory[$categoryItem->id];
        }
        echo "<pre>";
        print_r($productGroupByCategory);
        echo "<hr/>";
    }
    public function oneToManyResever(){
        $productSql = "SELECT * FROM products";
        $stmt = $this->pdo->prepare($productSql);
        $stmt->execute();
        $idCategory = [];
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($products as $key => $product){
            $idCategory[] = $product->category_id;
        }
        $idCategoryImplode = implode(", ", $idCategory);
        $sqlCategory = "SELECT * FROM categories WHERE id IN ($idCategoryImplode)";
        $stmt = $this->pdo->prepare($sqlCategory);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_OBJ);
        foreach($products as $key => $product){
            $product->category = $category;
        }
//        echo "<pre>";
//        print_r($products);
//        echo "<hr/>";
    }
    public function with($modelRelation){
        //chạy đến method là products trong model truyền xuống
        foreach ($modelRelation as $item) {
            $this->$item();
        }
        return $this;
    }
}