<?php

require_once 'bootstrap.php';

$model_list = [];
$result = $pdo->prepare("SELECT * FROM `car_brands`");
$result->execute();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $model_list[] = $row;
    //var_dump($row);
}
//var_dump($model_list);

$model = ['title'=>'Каталога авто','brands'=>$model_list];
//var_dump($model);

$template = $twig->load('index.html');

echo $template->render($model);