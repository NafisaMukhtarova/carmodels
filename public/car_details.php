<?php

require_once 'bootstrap.php';

//var_dump($_GET);
$car_id = $_GET['car_id'];
$result = $pdo->prepare("SELECT A.`car_name`, A.`car_id`,A.`modification`,A.`capacity`,A.`year_of_issue`,A.`year_end`,B.`car_model_name`, C.`body_type` 
                            FROM `cars` A,`car_models` B, `body_types` C 
                            WHERE A.`car_model`= B.`car_model_id` 
                                AND A.`body_type`=C.`body_type_id` 
                                AND A.`car_id`=? ");
$result->execute(array($car_id));
while ($row = $result->fetch()) {
    $model = array('car_name'=>$row['car_name'],
                    'car_model_name'=>$row['car_model_name'],
                    'modification'=>$row['modification'],
                    'capacity'=>$row['capacity'],
                    'year_of_issue'=>$row['year_of_issue'],
                    'year_end'=>$row['year_end'],
                    'body_type'=>$row['body_type'],
                    'car_id'=>$row['car_id']
                    );
    //var_dump($row);
}

//   

//var_dump($model);
echo $handlebars->render("car_detail", $model);