<?php
    require_once realpath('./vendor/autoload.php');
    $dotenv = Dotenv\Dotenv::createImmutable('./');
    $dotenv->load();
 
    $servidor = $_ENV['SERVIDOR'];
    $usuario = $_ENV['USUARIO'];
    $password = $_ENV['PASSWORD'];
    $puerto = $_ENV['PUERTO'];
    $bd = $_ENV['BD'];    
    $conexion = new PDO("mysql:servidor=$servidor;puerto=$puerto;bd=$bd", $usuario, $password);
    if ($conexion == True) {
        echo 'conectado';
    }else {
        echo 'No conectado';
    }


