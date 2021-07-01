<?php

require_once 'bootstrap.php';

session_start();

//var_dump($_GET);
$car_model_id = $_GET['model_id'];
$result_cars = $pdo->prepare("SELECT * FROM `cars` A,`car_models` B WHERE A.`car_model`= B.`car_model_id` AND B.`car_model_id`= ?");
$result_cars->execute(array($car_model_id));
while ($row = $result_cars->fetch()) {
    $model_cars[] = $row;
    //var_dump($row);
}
$result_model = $pdo->prepare("SELECT * FROM `car_models` A,`car_brands` B WHERE A.`car_model_id`= ? AND A.`car_brand` = B.`car_brand_id`");
$result_model->execute(array($car_model_id));
while ($row = $result_model->fetch()) {
    $car_model = $row['car_model_name'];
    $car_brand = $row['car_brand_name'];
    $car_model_id = $row['car_model_id'];
    //var_dump($row);
}

$model = ['models'=>$model_cars,'car_model'=>$car_model,'car_brand'=>$car_brand,'car_model_id'=>$car_model_id];

//users
if (isset($_SESSION['user_id'])) {
    $result_user = $pdo->prepare("SELECT * FROM `users` WHERE `user_id`=?");
    $result_user->execute([$_SESSION['user_id']]);

    while ($row = $result_user->fetch()) {
        $user = array('user_name'=>$row['name'],'admin'=>$row['admin_rights'] );
    }
    $model += ['user'=>$user];
} else {
    $model += ['user'=>NULL];
}

//var_dump($model);
echo $handlebars->render("car", $model);