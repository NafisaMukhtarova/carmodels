<?php

require_once 'bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $brandid = (int)$_GET['brand_id'];
    //var_dump( $brandid);
    $result = $pdo->prepare("SELECT * FROM `car_brands` WHERE `car_brand_id` = :id");
    $result->bindParam(':id', $brandid, PDO::PARAM_INT);
    $result->execute();
    while ($row = $result->fetch()) {
        $brand_list[] = $row;
    //var_dump($row);
    }

    //var_dump($brand_list);
    $model = ['title'=> "Добавить модель",'brand'=>$brand_list];
    //var_dump($model);

    echo $handlebars->render("new_model", $model);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{ 
    $data=[];
    //($_POST);
    $model_name = $_POST['ModelName'];
    $brand_id = (int)$_POST['Brandid'];
    $data=[':mname'=>$model_name,':brandid'=>$brand_id];
    //var_dump($data);
    $result = $pdo->prepare("INSERT INTO `car_models` (`car_model_name`,`car_brand`) VALUES (:mname,:brandid)");
    
    try {
        $result->execute($data);
        $log->debug('Добавлена запись в таблицу Car_Models ', ['car_model' => $data[':mname'], 'car_model_id'=>$pdo->lastInsertId()]);
    } catch(PDOException $e) {
            $log->error('Ошибка добавления записи в таблицу Car_Models', ['message' => $e->getMessage()]);
            echo $e->getMessage();
        }
        
$url = 'Location: /'.$_ENV['LOCATION'].'car_models.php?brand_id=$brand_id';//  генерируем url- обратный переход на список моделей
       
header($url);
}
