<?php

require_once ("./vendor/autoload.php");
//require_once 'connection.php';

use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$log = new Logger('CARS');
$log->pushHandler(new StreamHandler(__DIR__ .'/logs/debug/log', Logger::DEBUG));

# Set the partials files
$partialsDir = __DIR__."/templates";
$partialsLoader = new FilesystemLoader($partialsDir,
    [
        "extension" => "html"
    ]
);

# We'll use $handlebars throughout this the examples, assuming the will be all set this way
$handlebars = new Handlebars([
    "loader" => $partialsLoader,
    "partials_loader" => $partialsLoader
]);


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

    public function Connect_PDO($log_con)
    {
        $this->log_con = $log_con;
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->db;charset=$this->charset", $this->user, $this->password
            ,array (PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8")
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->log_con->debug('Подключение Connect.php: ', ['message' => 'успешно']);
        } catch (PDOException $e) {
            echo "ОШИБКА Connect.php";
                //die($e->getMessage());
            $this->log_con->debug('Ошибка Connect.php: ', ['message' => $e->getMessage()]);
        }

        $pdo->query("SET NAMES 'utf8'");
        $pdo->query("SET CHARACTER SET 'utf8';");
        $pdo->query("SET SESSION collation_connection = 'utf8_general_ci';");
        
        return $pdo;
    }
}

$config = new Config(getenv('CONFIG_DB'),getenv('CONFIG_USER'),getenv('CONFIG_PASSWORD'),getenv('CONFIG_HOST'));
$pdo = $config->Connect_PDO($log);