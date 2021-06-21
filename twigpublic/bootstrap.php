<?php

require_once ("../vendor/autoload.php");

$appdir = dirname(__DIR__);

//ENV
$dotenv = Dotenv\Dotenv::createImmutable($appdir);
$dotenv->load();

//twig
$loader = new \Twig\Loader\FilesystemLoader($appdir."/twigtemplates");
$twig = new \Twig\Environment($loader);



//PDO
class Config
{
    private $user = "" ; // пользователь

    private $password = ""; // пароль
    
    private $db = ""; // название бд
    
    private $host = ""; // хост
    
    private $charset = 'utf8mb4';//'utf8'; // кодировка

    private $log_con;
    
    public function __construct($db,$user,$pass,$host)
    {
        $this->db = $db;
        $this->user = $user;
        $this->password = $pass;
        $this->host = $host;    
    }

    public function Connect_PDO()
    {
        
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->db;charset=$this->charset", $this->user, $this->password
            ,array (PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8")
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            echo "ОШИБКА Connect.php";
                //die($e->getMessage());
            
        }

        $pdo->query("SET NAMES 'utf8'");
        $pdo->query("SET CHARACTER SET 'utf8';");
        $pdo->query("SET SESSION collation_connection = 'utf8_general_ci';");
        
        return $pdo;
    }
}


$db = $_ENV['CONFIG_DB'];
$us = $_ENV['CONFIG_USER'];
$pw = $_ENV['CONFIG_PASSWORD'];
$ht = $_ENV['CONFIG_HOST'];
$config = new Config($db,$us,$pw,$ht);
$pdo = $config->Connect_PDO();