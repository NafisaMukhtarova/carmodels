<?php

require_once 'bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
$model = ['title'=> "Добавить бренд"];
//var_dump($model);

echo $handlebars->render("new_brand", $model);
}

function can_upload($file)
{
	// если имя пустое, значит файл не выбран
    if($file['name'] == '') {
		return 'Вы не выбрали файл.';   
    } 
	
	/* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
	if($file['size'] == 0) {
		return 'Файл слишком большой.';
    }
    
	// разбиваем имя файла по точке и получаем массив
	$getMime = explode('.', $file['name']);
	// нас интересует последний элемент массива - расширение
    //var_dump($getMime);
	$mime = strtolower(end($getMime));
	// объявим массив допустимых расширений
	$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
	
	// если расширение не входит в список допустимых - return
	if(!in_array($mime, $types)) {
		return 'Недопустимый тип файла.';
    }

	return true;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{ 
    $data=[];

    $data=[':bname'=>$_POST['BrandName'],':photo'=>''];
var_dump($_FILES);
    if($_FILES['image']['name']!='') {
        $check = can_upload($_FILES['image']);
        var_dump($check);
        if($check===true) {
        $getMime = explode('.',$_FILES['image']['name']);
        $mime = strtolower(end($getMime));
        //echo 'mime '. $mime. ' ';
        $photo = $data[':bname'].'.'.$mime;
        echo 'photo '. $photo. ' ';
        $data[':photo']=$photo;
        } else {
            echo $check; 
            exit();
        }
    }
    var_dump($data);
    $result = $pdo->prepare("INSERT INTO `car_brands` (`car_brand_name`,`brand_photo`) VALUES (:bname,:photo)");
    try {
        $result->execute($data);
        //добавляем фото в базу 
        move_uploaded_file($_FILES['image']['tmp_name'],"images/".$photo);
        $log->debug('Добавлена запись в таблицу car_brands ', ['brand' => $data[':bname'], 'brand_id'=>$pdo->lastInsertId()]);
    } catch(PDOException $e) {
        $log->error('Ошибка добавления записи в таблицу car_brands', ['message' => $e->getMessage()]);
        echo $e->getMessage();
    }

    header('Location: /');
}
