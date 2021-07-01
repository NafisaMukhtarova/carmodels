<?php

require_once 'bootstrap.php';

session_start();

//var_dump($_GET);
$car_id = (int)$_GET['car_id'];
$result = $pdo->prepare("SELECT * FROM `car_photos` A,`cars` B WHERE A.`car_id`= ? AND A.`car_id`= B.`car_id` ");
$result->execute(array($car_id));
$model_photo=[];
while ($row = $result->fetch()) {
    $model_photo[] = $row;
    //var_dump($row);
}

//   
$model= ['title'=>" Галерея",'car_id'=>$car_id,'photos'=>$model_photo];

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
echo $handlebars->render("car_photo_gallery", $model);