<?php


require_once 'bootstrap.php';

function can_upload($file)
{
	// если имя пустое, значит файл не выбран
    if($file['name'] == '')
		return 'Вы не выбрали файл.';
        
	
	/* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
	if($file['size'] == 0)
		return 'Файл слишком большой.';
        
	
	// разбиваем имя файла по точке и получаем массив
	$getMime = explode('.', $file['name']);
	// нас интересует последний элемент массива - расширение
    //var_dump($getMime);
	$mime = strtolower(end($getMime));
	// объявим массив допустимых расширений
	$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
	
	// если расширение не входит в список допустимых - return
	if(!in_array($mime, $types))
		return 'Недопустимый тип файла.';
        
	
	return true;
  }



if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $carid = (int)$_GET['car_id'];
    var_dump($_GET);
    echo $handlebars->render("new_photo", ['car_id'=>$carid]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{ 
    var_dump($_POST);
    var_dump($_FILES);

    if($_FILES['image']['name']!='')
    {
    
        $check = can_upload($_FILES['image']);
        if ($check===true) {
            
            $photo = $_FILES['image']['name'];
            $id = $_POST['car_id'];
            var_dump($photo);
            var_dump($id);
            $insert_result = $pdo->prepare("INSERT INTO `car_photos`(`car_id`,`car_photo`) VALUES (:id,:photo)");
        
            try {
                $insert_result->execute([':id'=>$id,':photo'=>$photo]);
                move_uploaded_file($_FILES['image']['tmp_name'],"images/gallery/".$photo);
                $log->debug('Добавлено фото в галарею ', ['car_id' => $id, 'photo'=>$photo]);
            } catch(PDOException $e) {
                    $log->error('Ошибка добавления фото в галерею', ['message' => $e->getMessage()]);
                    echo $e->getMessage();
                }
            
        } else {
            echo $check; 
            exit();
        }
    }
    $url = "/car_gallery.php?car_id=$id";//  генерируем url- обратный переход на список автомобилей
       
    header("Location: $url");
    
}
