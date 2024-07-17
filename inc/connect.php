<?php
$login = "root";
$pass = "";
$base = "ridasolutions";
$serveur = "localhost";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,];

$db = new PDO("mysql:host=$serveur;dbname=$base;charset=utf8", $login, $pass, $options);
