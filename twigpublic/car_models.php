<?php

require_once 'bootstrap.php';

//var_dump($_GET);
$brand_id = $_GET['brand_id'];
//var_dump($brand);
$result = $pdo->prepare("SELECT * FROM `car_brands` A,`car_models`B WHERE A.`car_brand_id`=B.`car_brand` AND A.`car_brand_id`=? ORDER BY B.`car_model_name`");
$result->execute(array($brand_id));
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $model_list[] = $row;
    //var_dump($row);
}

$result_brand = $pdo->prepare("SELECT * FROM `car_brands` A WHERE A.`car_brand_id`=? ");
$result_brand->execute(array($brand_id));
while ($row = $result_brand->fetch(PDO::FETCH_ASSOC)) {
    $brand_det = $row['car_brand_name'];
    //var_dump($row);
}

$model = ['title'=>'Модели бренда','models'=>$model_list,'brand'=>$brand_det];
var_dump($model);
$template = $twig->load('car_models.html');
echo $template->render($model);