 <?php

require_once 'bootstrap.php';

session_start();

$model_list = [];
$result = $pdo->prepare("SELECT * FROM `car_brands` ORDER BY `car_brand_name`");
$result->execute();
while ($row = $result->fetch()) {
    $model_list[] = $row;
    //var_dump($row);
}
//var_dump($model_list);
$model = ['brands'=>$model_list];

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
//var_dump($_SESSION);
echo $handlebars->render("main", $model);
