<?php

$host = "http://52.56.253.209";
$servername = "alcaroldb";
$username = "root";
$password = "";

require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_REQUEST["id"]) && isset($_REQUEST["nombre"])){
        //usuarios id, nombre
        $query = "INSERT INTO usuarios(id, nombre) values (0, 'albert')";
        $retorno = Connexio::query($query);
        if($retorno){
            echo 'Se ha podido insertar</br>';
            $query = "SELECT nombre FROM usuarios WHERE id = 0";
            $retorno = Connexio::query($query);
            $row = mysqli_fetch_assoc($retorno);
            echo 'El nombre del usuario es: '.$row["nombre"];
        }else{
            echo 'no ha funcionado la consulta';
        }
    }else{
        echo 'no hay nada';
    }
}
?>
