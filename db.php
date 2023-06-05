<?php

class DB{
    /**
     * 1. 自動連線資料庫
     * 2. 能夠執行CRUD的操作
     * 3. 能指定資料表
     */

     protected $dsn="mysql:host=localhost;charset=utf8;dbname=vote";
     protected $user="root";
     protected $pw="";
     protected $table;
     protected $pdo;
     protected $query_result;

     function __construct($table)
     {
        $this->table=$table;
        $this->pdo=new PDO($this->dsn,$this->user,$this->pw);
     }

     function all(...$arg){
        $sql="select * from $this->table ";

        if(!empty($arg)){
            if(is_array($arg[0])){
                foreach($arg[0] as $key => $value){
    
                    $tmp[]="`$key`='$value'";
                }
        
                $sql =$sql .  " where " . join(" && ",$tmp);
            }else{
    
                $sql=$sql .  $arg[0];
                
            }
        }
    
        if(isset($arg[1])){
            $sql=$sql .  $arg[1];
        }
    
        $this->query_result=$this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        return $this;
     }

     function dd(){
        echo "<pre>";
        print_r($this->query_result);
        echo "</pre>";
    }
    

     function q($sql){
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
     }
}


$Topic=new DB('topics');
$Option=new DB('options');

#all('topics')
#all('options')

/* dd($Topic->all(['id'=>6]));
dd($Option->all()); */

$Topic->all(['id'=>7])->dd();


function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
