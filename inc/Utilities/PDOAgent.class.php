<?php

//Reference: https://culttt.com/2012/10/01/roll-your-own-pdo-php-class/

class PDOAgent    {

    private $host = DB_HOST;  
    private $user = DB_USER;  
    private $pass = DB_PASS;  
    private $dbname = DB_NAME;

    private $dsn = "";

    private $className;

    private $pdo;
    private $error;

    private $stmt;


    
    public function __construct(String $className)    {

        $this->className = $className;
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;  

        $options = array(  
            PDO::ATTR_PERSISTENT => true,  
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  
            ); 

        try {  
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);  
        } catch (PDOException $e) {  
            $this->error = $e->getMessage();  
        }  
        
    }

    public function query(string $query) {
            $this->stmt = $this->pdo->prepare($query);  
    }

    public function bind(string $param,string $value, $type = null)  {

        if (is_null($type)) {  
            switch (true) {  
                case is_int($value):  
                $type = PDO::PARAM_INT;  
                break;  
                case is_bool($value):  
                $type = PDO::PARAM_BOOL;  
                break;  
                case is_null($value):  
                $type = PDO::PARAM_NULL;  
                break;  
                default:  
                $type = PDO::PARAM_STR;  
            }  
        }

        $this->stmt->bindValue($param, $value, $type); 
    }
    
    public function execute($data = null)   {
        if (is_null($data)) {  
            return $this->stmt->execute();  
        } else {
            return $this->stmt->execute($data);
        }
    }


    public function resultSet(){  
        $this->execute();  
        return $this->stmt->fetchAll(PDO::FETCH_CLASS, $this->className);  
    }

    public function singleResult(){  
        $this->execute();  
        $this->stmt->setFetchMode(PDO::FETCH_CLASS, $this->className);
        return $this->stmt->fetch(PDO::FETCH_CLASS);  
    }  

    public function rowCount(): int{  
        return $this->stmt->rowCount();  
    }
    
    public function lastInsertId(): int{  
        return $this->pdo->lastInsertId();  
    }

    public function rowsAffected(): int {
        return $this->stmt->rowCount();
    }

    public function debugDumpParams(){  
        return $this->stmt->debugDumpParams();  
    }  

}

?>