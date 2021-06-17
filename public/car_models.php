<?php

require_once 'bootstrap.php';

//var_dump($_GET);
$brand_id = $_GET['brand_id'];
//var_dump($brand);
$result = $pdo->prepare("SELECT * FROM `car_brands` A,`car_models`B WHERE A.`car_brand_id`=B.`car_brand` AND A.`car_brand_id`=? ORDER BY B.`car_model_name`");
$result->execute(array($brand_id));
while ($row = $result->fetch()) {
    $model_list[] = $row;
    //var_dump($row);
}

$result_brand = $pdo->prepare("SELECT * FROM `car_brands` A WHERE A.`car_brand_id`=? ");
$result_brand->execute(array($brand_id));
while ($row = $result_brand->fetch()) {
    $brand_det[] = $row;
    //var_dump($row);
}

$model = ['models'=>$model_list,'brand'=>$brand_det];
//var_dump($model);
echo $handlebars->render("car_models", $model);
