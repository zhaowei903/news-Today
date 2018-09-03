<?php

class News
{
    public $pdo;

    public function __construct()
    {
        $db = array(
            'dsn' => 'mysql:host=localhost;dbname=news;port=3306;charset=utf8',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        );
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        );
        try {
            $this->pdo = new PDO($db['dsn'], $db['username'], $db['password'], $options);
        } catch (PDOException $e) {
            die('数据库连接失败:' . $e->getMessage());
        }
    }
    public function activeDelete()
    {
        $id=$_GET['id'];
        $rows  =  $this->pdo->exec("delete from  card where id = ".$id);
        echo $rows;
    }
    public function activeInsert()
    {
        $getit=$_GET['getit'];

        $stmt = $this->pdo->prepare("insert into card(getit)values(?)");
        $stmt->bindValue(1, $getit);

        $rows=$stmt->execute();
        echo $rows;
    }
    public function activeView()
    {
        $stmt = $this->pdo->query('select * from card');
        $rows = $stmt->fetchAll();
        include "../add.html";
    }
}
$news=new News();

if (isset($_GET['active'])){
    $method="active".$_GET['active'];
}else{
    $method="activeView";
}
$news->$method();
