<?php

require_once 'bootstrap.php';

//var_dump($_GET);
$car_model = $_GET['model'];
$result_cars = $pdo->prepare("SELECT * FROM `cars` A,`car_models` B WHERE A.`car_model`= B.`car_model_id` AND B.`car_model_name`= ?");
$result_cars->execute(array($car_model));
while ($row = $result_cars->fetch()) {
    $model_cars[] = $row;
    //var_dump($row);
}
$result_model = $pdo->prepare("SELECT * FROM `car_models` A WHERE A.`car_model_name`= ?");
$result_model->execute(array($car_model));
while ($row = $result_model->fetch()) {
    $car_model = $row['car_model_name'];
    //var_dump($row);
}


$model = ['models'=>$model_cars,'car_model'=>$car_model];
//var_dump($model);
echo $handlebars->render("model", $model);