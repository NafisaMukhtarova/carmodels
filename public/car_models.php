<?php

require_once 'bootstrap.php';

session_start();

//var_dump($_GET);
$brand_id = $_GET['brand_id'];
//var_dump($brand);
$result = $pdo->prepare("SELECT * FROM `car_brands` A,`car_models`B WHERE A.`car_brand_id`=B.`car_brand` AND A.`car_brand_id`=? ORDER BY B.`car_model_name`");
$result->execute(array($brand_id));
while ($row = $result->fetch()) {
    $model_list[] = $row;
    //var_dump($row);
}
$model = ['models'=>$model_list];

$result_brand = $pdo->prepare("SELECT * FROM `car_brands` A WHERE A.`car_brand_id`=? ");
$result_brand->execute(array($brand_id));
while ($row = $result_brand->fetch()) {
    $brand_det[] = $row;
    //var_dump($row);
    $model += ['car_brand_name'=>$row['car_brand_name']];
    $model += ['brand_photo'=>$row['brand_photo']];
    $model += ['car_brand_id'=>$row['car_brand_id']];
}


//$model = ['models'=>$model_list,'brand'=>$brand_det];
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
echo $handlebars->render("car_models", $model);
