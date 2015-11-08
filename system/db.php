<?php

//xDebug - поиск ошибок в коде

//error_reporting (0);

/*mzapeka = "mzapeka.mysql.ukraine.com.ua";
$user = "mzapeka_db";
$pass = "gamt8Rxd";
$db_name = "mzapeka_db";*/

//namespace db;

class DB {
    private $host = "localhost";
    private $dbUser = "root";
    private $dbPass = "";
    private $dbType = "mysql";
    private $db_name;
    private $link;

    function __construct($db_name) {
        $this->db_name = $db_name;
        $param = $this->dbType.":host=".$this->host.";dbname=".$this->db_name;
        try {
            $this->link = new PDO($param, $this->dbUser, $this->dbPass);
        }
        catch (PDOException $e){
            return $e->getMessage();
        }
        $this->link->query('SET character_set_database=utf8');
        $this->link->query('SET NAMES utf8');
    }

    function select($tableName, $fildName = false, $value = array()){
        if (!$fildName){
            $fildName = "*";
        }
        elseif (is_array($fildName)) {
            foreach ($fildName as $fild){
                $filds = $filds.$koma."`$fild`";
                $koma = ",";
            }
            $fildName = $filds;
        }
        else {
            $fildName = "`$fildName`";
        }

        $sql = "SELECT $fildName FROM `$tableName` ";

            if ($value){
                $whrSql = "WHERE ";
                $i = 1;
                $and = "";
                $mask = array();
                foreach ($value as $kay => $val){
                    $whrSql = $whrSql.$and."`{$kay}` = :value".$i;
                    $mask += [":value".$i => $val];
                    $and = " AND ";
                    $i++;
                }
                $sql = $sql.$whrSql;
            }
        try{
            $query = $this->link->prepare($sql);
            $query->execute($mask);
            while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                $array[] = $row;
            }

        }
        catch (PDOException $e){
            return $e->getMessage();
        }
        return $array;
    }

    function sendQuery($query, $values = array()){
            $result = $this->link->prepare($query);
            $result->execute($values);
        if (is_bool($result)){
            return $result;
        }
        else {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                $array[] = $row;
            }
            return $array;
        }
    }
    function insert($tableName, $values = array()){
        $i = 1;
        $valMask = array();
        foreach ($values as $kay => $value){
            $keys = $keys.$koma."`$kay`";
            $valMask += [":val".$i => $value];
            $valuesAll = $valuesAll.$koma.":val".$i;
            $koma = ",";
            $i++;
        }
        $sql = "INSERT INTO `$tableName` ($keys) VALUES ($valuesAll)";
        $query = $this->link->prepare($sql);
        $query->execute($valMask);
        return $query->errorCode();
        //return $this->link->lastInsertId();
    }
    function update($tableName, $values = array(), $forWhich = array()){
        if(!$this->select($tableName, false, [$forWhich[0] => $forWhich[1]])){
            $result[0] = false;
        }
        else{
            $i = 1;
            $mask = array();
            foreach ($values as $kay => $value){
                $updData = $updData.$koma."`$kay`"." = :value".$i;
                $mask += [":value".$i => $value];
                $koma = ",";
                $i++;
            }
            $selected = "`$forWhich[0]` = :value".$i;
            $mask += [":value".$i => $forWhich[1]];
            $sql = "UPDATE `$tableName` SET $updData WHERE $selected";
            $query = $this->link->prepare($sql);
            $query->execute($mask);
            $result = $query->errorInfo();
        }
        return ($result);
    }

    function delete($tableName, $forWhich = array()){
        /** @var $forWhich TYPE_NAME */
        if(!$this->select($tableName, false, [$forWhich[0] => $forWhich[1]])){
            $result = false;
        }
        else {
            $selected = "`$forWhich[0]` = :value";
            $mask = [":value" => $forWhich[1]];
            $sql = "DELETE FROM `$tableName` WHERE $selected";
            $query = $this->link->prepare($sql);
            $query->execute($mask);
            $error = $query->errorInfo();
            if ($error[0]){
                $result = true;
            }
            else {
                $result = false;
            }
        }
        return ($result);
        }

    function setCurentTime($tableName, $fild, $forWhich){
        if(!$this->select($tableName, false, [$forWhich[0] => $forWhich[1]])){
            $result[0] = false;
        }
        else{
            $updData = "`$fild` = (NOW())";
            $selected = "`$forWhich[0]` = :value";
            $mask = [":value" => $forWhich[1]];
            $sql = "UPDATE `$tableName` SET $updData WHERE $selected";
            $query = $this->link->prepare($sql);
            $query->execute($mask);
            $result = $query->errorInfo();
        }
        return ($result);
    }
}


