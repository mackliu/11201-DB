<?php

class DB
{
    /**
     * 1. 自動連線資料庫
     * 2. 能夠執行CRUD的操作
     * 3. 能指定資料表
     */

    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=vote";
    protected $user = "root";
    protected $pw = "";
    protected $table;
    protected $pdo;
    protected $query_result;

    function __construct($table)
    {
        $this->table = $table;
        $this->pdo = new PDO($this->dsn, $this->user, $this->pw);
    }

    function all(...$arg)
    {
        $sql = "select * from $this->table ";

        if (!empty($arg)) {
            if (is_array($arg[0])) {
                foreach ($arg[0] as $key => $value) {

                    $tmp[] = "`$key`='$value'";
                }

                $sql = $sql .  " where " . join(" && ", $tmp);
            } else {

                $sql = $sql .  $arg[0];
            }
        }

        if (isset($arg[1])) {
            $sql = $sql .  $arg[1];
        }

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    function find($arg)
    {
        $sql = "select * from `$this->table`  where ";

        if (is_array($arg)) {
            foreach ($arg as $key => $value) {

                $tmp[] = "`$key`='$value'";
            }

            $sql .= join(" && ", $tmp);
        } else {

            $sql .= " `id` = '$arg' ";
        }

        //echo $sql;
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    function save($cols){
        if(isset($cols['id'])){
            //update
            foreach($cols as $key => $value){
                if($key!='id'){
                    $tmp[]= "`$key`='$value'";
                }
            }
        
            $sql="update `$this->table` set  ".join(",",$tmp)." where `id`='{$cols['id']}'";

            return $this->pdo->exec($sql);
        }else{
            //insert
            $keys=array_keys($cols);
            $sql="insert into $this->table (`" . join("`,`", $keys) . "`) values('".join("','",$cols)."')";
                //echo $sql;
            return $this->pdo->exec($sql);
        }
    }

    function del($arg){
        $sql="delete from `$this->table` where ";
        if(is_array($arg)){
            foreach($arg as $key => $value){
    
                $tmp[]="`$key`='$value'";
            }
    
            $sql .= join(" && ",$tmp);
        }else{
    
            $sql .= " `id` = '$arg' ";
            
        }
    
        //echo $sql;

        return $this->pdo->exec($sql);
    }

}


/* function q($sql)
{
    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
} */
$Topic = new DB('topics');
$Option = new DB('options');

#all('topics')
#all('options')

dd($Topic->del(6));

function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
