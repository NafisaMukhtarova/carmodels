<?php

require_once 'bootstrap.php';

session_start();

$name = $user_id['name'];

session_destroy();

$log->debug(' Пользователь вышел из системы: ', ['user' => $name]);

$header = 'Location: /'.$_ENV['LOCATION'];
header($header);