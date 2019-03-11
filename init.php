<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'functions.php';
require_once 'config/db.php';
require_once 'config/config.php';
require_once 'db_func.php';

session_start();// открываем ссесию
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];

$title = 'YetiCave';

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");

$categories = db_categories($link);
