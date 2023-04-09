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
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $products;
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
        } else{
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
    public function connectDatabase(){
        $host = '127.0.0.1';
        $db   = 'oop';
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
}