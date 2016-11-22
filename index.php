<?php
session_start();
session_name("studio404");
error_reporting(E_ALL);
ini_set('memory_limit', '5120M');
ini_set('display_errors', 1);

require_once 'app/init.php';

$app = new App;