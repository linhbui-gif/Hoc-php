<?php

namespace Models;

use PDO;

class BaseModel {

    protected $table;

    private $pdo;

    private $where = [];

    private $select = '*';

    private $groupBy = null;

    private $having = null;

    private $orderBy = null;

    private $limit = null;

    private $offset = null;

    private $join = [];

    protected $primaryKey = 'id';

    protected $attribute = [];

    private $oneToMany = [];

    public function __construct()
    {
        $this->pdo = $this->connectPdo();
    }

    public function insert($data)
    {
        $table = $this->table;
        $columnKey = array_keys($data);
        $columns = implode(', ', $columnKey);

        $tmpPlaceHolder = [];
        $values = [];
        foreach ($data as $value) {
            $tmpPlaceHolder[] = '?';
            $values[] = $value;
        }

        $placeHolderSql = implode(', ', $tmpPlaceHolder);
        $sql = "INSERT INTO $table ($columns) VALUES ($placeHolderSql)";
        // chuan bi sql
        $stmt = $this->pdo->prepare($sql);
        // thuc thi sql
        $dataExcute = $stmt->execute($values);
        if($dataExcute) {
           $lastInsertId = $this->pdo->lastInsertId();
        }
        if($lastInsertId) {
            return $lastInsertId;
        }

        return false;
    }


    public function delete() 
    {
        $table = $this->table;
        $tmpWhere = [];
        foreach($this->where as $key => $valueWhere) {
            $keyWhere = 'where_' . $key;
            $tmpWhere[] = $valueWhere['column'] . ' ' . $valueWhere['operator'] . ' :' . $keyWhere;
            $dataExcute[$keyWhere] = $valueWhere['value'];
          
        }
        $where = implode(' AND ', $tmpWhere);
        $sql = "DELETE FROM $table WHERE ";
        if($this->where) {
            $sql = $sql . $where;
        }

        $stmt = $this->pdo->prepare($sql);
        // thuc thi sql
        $dataExcute = $stmt->execute($dataExcute);
        
    }

    public function select($select) 
    {
        if($select) {
            $this->select = $select;
        } else {
            $this->select = "*";
        }
        
        return $this;
    }

    public function groupBy($groupBy) 
    {
        $this->groupBy = $groupBy;
        return $this;
    }

    
    public function having($having) 
    {
        $this->having = $having;
        return $this;
    }

    public function orderBy($orderBy) 
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function limit($limit, $offset) 
    {
        $this->limit = $limit;
        $this->offset = $offset;

        return $this;
    }

    public function join($tableJoin, $condition) 
    {
        $this->join[] = [
            'type' => 'INNER',
            'tableJoin' => $tableJoin,
            'condition' => $condition
        ];
        return $this;
    }



    public function get() 
    {
        $dataWhere = [];
        // SELECT CustomerName, City, Country FROM Customers;
        $sql = "SELECT ";

        // select
        $sql = $sql . $this->select . ' FROM ' . $this->table;

        // join INNER JOIN Customers ON Orders.CustomerID=Customers.CustomerID;
        if($this->join) {
            foreach($this->join as $valueJoin) {
                $sql = $sql . ' ' . $valueJoin['type'] . ' JOIN ' . $valueJoin['tableJoin'] . ' ON ' . $valueJoin['condition'];
            }
        }

        // where
        if($this->where) {
            list($where, $dataWhere) = $this->whereAnd();
            $sql = $sql . ' WHERE ' . $where;
        }

        // group by
        if($this->groupBy) {
            $sql = $sql . ' GROUP BY ' . $this->groupBy;
        }

        // having
        if($this->having) {
            $sql = $sql . ' HAVING ' . $this->having;
        }

        // order
        if($this->orderBy) {
            $sql = $sql . ' ORDER BY ' . $this->orderBy;
        }

        // limit
        // LIMIT [offset,] row_count;
        if(is_numeric($this->limit)) {
            if(is_numeric($this->offset)) {
                $sql = $sql . ' LIMIT ' . $this->offset . ', ' . $this->limit;
            } else {
                $sql = $sql . ' LIMIT ' . $this->limit;
            }
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($dataWhere);
        
        // thuc thi sql
        $dataMain = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $dataMain;

    }

    private function whereAnd() 
    {
        $tmpWhere = [];
        $dataWhere = [];
        foreach($this->where as $key => $valueWhere) {
            $keyWhere = 'where_' . $key;
            $tmpWhere[] = $valueWhere['column'] . ' ' . $valueWhere['operator'] . ' :' . $keyWhere;
            $dataWhere[$keyWhere] = $valueWhere['value'];
          
        }
        $where = implode(' AND ', $tmpWhere);

        return [$where, $dataWhere];
    }



    public function update($data) 
    {
        $table = $this->table;

        $dataExcute = [];
        foreach($data as $key => $value) {
            $tmpKey[] = $key . ' = :' . $key;
            $dataExcute[$key] = $value;
        }
        $column = implode(', ', $tmpKey);

        $tmpWhere = [];
        foreach($this->where as $key => $valueWhere) {
            $keyWhere = 'where_' . $key;
            $tmpWhere[] = $valueWhere['column'] . ' ' . $valueWhere['operator'] . ' :' . $keyWhere;
            $dataExcute[$keyWhere] = $valueWhere['value'];
          
        }

        $where = implode(' AND ', $tmpWhere);
        $sql = "UPDATE $table SET $column WHERE ";

        // check have where
        if($this->where) {
            $sql = $sql . $where;
        }

        $sql = "UPDATE $table SET $column WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        // thuc thi sql
        $dataExcute = $stmt->execute($dataExcute);

    }

    public function where() 
    {

        $numArg = func_num_args();
        $args = func_get_args();

        if($numArg === 2) {
            $column = $args[0];
            $operator = '=';
            $value = $args[1];
        } elseif($numArg === 3) {
            $column = $args[0];
            $operator = $args[1];
            $value = $args[2];
        } else {
            $column = null;
            $operator = null;
            $value = null;
        }

        $this->where[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
       
        return $this;

    }

    public function connectPdo() 
    {
        $host = '127.0.0.1';
        $db   = 'example';
        $user = 'root';
        $pass = '';
        $port = "3307";
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";

        try {
            return new PDO($dsn, $user, $pass);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }   
    }


    public function save($instanceObj) 
    {
       

        $data = [];
        foreach($instanceObj->getFilAble() as $value) {
            $method = 'get' . ucfirst($value);
            $data[$value] = $instanceObj->$method();
        }
        $this->attribute = $data;

    }

    public function whereArray($conditionArray) 
    {

        if(is_array($conditionArray) && count($conditionArray) === 1) {
            $conditionArray = [$conditionArray];
        }

        foreach($conditionArray as $itemArray) {

            list($column, $operator, $value) = $itemArray;

            $this->where[] = [
                'column' => $column,
                'operator' => $operator,
                'value' => $value
            ];
            
        }

        return $this;

    }

   
}