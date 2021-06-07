<?php

require_once 'bootstrap.php';

//var_dump($_GET);
$car_model = $_GET['model'];
$result = $pdo->prepare("SELECT * FROM `cars` A,`car_models` B WHERE A.`car_model`= B.`car_model_id` AND B.`car_model_name`= ?");
$result->execute(array($car_model));
while ($row = $result->fetch()) {
    $model_list[] = $row;
    //var_dump($row);
}


$model = ['model'=>$model_list];
//var_dump($model);
echo $handlebars->render("model", $model);