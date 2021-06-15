<?php

require_once 'bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $modelid = (int)$_GET['model_id'];
    //var_dump($modelid);
    $result_model = $pdo->prepare("SELECT * FROM `car_models` WHERE `car_model_id` = :id");
    $result_model->bindParam(':id', $modelid, PDO::PARAM_INT);
    $result_model->execute();
    while ($row = $result_model->fetch()) {
        $model_list[] = $row;
    //var_dump($row);
    }
    $result_body = $pdo->prepare("SELECT * FROM `body_types`");
    $result_body->execute();
    while ($row = $result_body->fetch()) {
        $body_type[] = $row;
    //var_dump($row);
    }

    $model = ['title'=> "Добавить вариант модели",'model'=>$model_list,'body_type'=>$body_type];
    //var_dump($model);

    echo $handlebars->render("new_car", $model);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{ 
    var_dump($_POST);
    $modelid = (int)$_POST['Modelid'];
    $carname = (string)$_POST['CarName'];
    $bodytype = (int)$_POST['BodyTypeid'];
    $modification = (string)$_POST['CarModification'];
    $capacity = (int)$_POST['CarCapacity'];
    $yearstart = (int)$_POST['CarYearStart'];
    $yearstop = (int)$_POST['CarYearStop'];
    $data=[':cname'=>$carname,
            ':cmodel'=>$modelid,
            ':bodytype'=>$bodytype,
            ':modification'=>$modification,
            ':capacity'=>$capacity,
            ':yearstart'=>$yearstart,
            ':yearstop'=>$yearstop
            ];

            
    $result = $pdo->prepare("INSERT INTO `cars` (`car_name`,`car_model`,`body_type`,`modification`,`capacity`,`year_of_issue`,`year_end`) 
                                VALUES (:cname,:cmodel,:bodytype,:modification,:capacity,:yearstart,:yearstop)");

    try {
        $result->execute($data);
        $log->debug('Добавлена запись в таблицу Car_Models ', ['car_model' => $data[':cname'], 'car_model_id'=>$pdo->lastInsertId()]);
    } catch(PDOException $e) {
            $log->error('Ошибка добавления записи в таблицу Car_Models', ['message' => $e->getMessage()]);
            echo $e->getMessage();
    }

}