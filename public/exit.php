<?php

require_once 'bootstrap.php';

session_start();
session_destroy();

$log->debug(' Пользователь вышел из системы: ', ['user' => $user_id['name']]);

header('Location: /');