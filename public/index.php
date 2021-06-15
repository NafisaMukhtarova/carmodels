<?php

require_once 'bootstrap.php';

$model_list = [];
$result = $pdo->prepare("SELECT * FROM `car_brands` ORDER BY `car_brand_name`");
$result->execute();
while ($row = $result->fetch()) {
    $model_list[] = $row;
    //var_dump($row);
}
//var_dump($model_list);
$model = ['brands'=>$model_list];
//var_dump($model);
echo $handlebars->render("main", $model);
