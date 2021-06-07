<?php

require_once 'bootstrap.php';

//var_dump($_GET);
$brand = $_GET['brand'];
$result = $pdo->prepare("SELECT * FROM `car_brands` A,`car_models`B WHERE A.`car_brand_id`=B.`car_brand` AND A.`car_brand_name`=? ");
$result->execute(array($brand));
while ($row = $result->fetch()) {
    $model_list[] = $row;
    //var_dump($row);
}
$result_brand = $pdo->prepare("SELECT * FROM `car_brands` A WHERE A.`car_brand_name`=? ");
$result_brand->execute(array($brand));
while ($row = $result_brand->fetch()) {
    $brand_det[] = $row;
    //var_dump($row);
}

$model = ['models'=>$model_list,'brand'=>$brand_det];
var_dump($model);
echo $handlebars->render("brand", $model);