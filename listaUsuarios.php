<?php

//$host = "52.56.253.209";
$host = "localhost";
$servername = "alcaroldb";
$username = "root";
$password = "";

require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_REQUEST["id"]) && isset($_REQUEST["nombre"])){
        //usuarios id, nombre
        /*$query = "INSERT INTO usuarios(id, nombre) values (0, 'albert')";
        $retorno = Connexio::query($query);*/
        if(true){
            echo 'Se ha podido insertar</br>';
            $query = "SELECT id, nombre,dni, password FROM usuarios";
			//$query = "DELETE FROM usuarios WHERE id = 0";
            $retorno = Connexio::query($query);
            while ($row = mysqli_fetch_assoc($retorno)) {
				/*
				echo 'El nombre del usuario es: '.$row["nombre"].',id:'.$row["id"].',dni:'.$row["dni"].',pass:'.$row["password"];
				echo '</br>';*/
				
				print json_encode(array('estado' => '1', 'mensaje' => 'Bienvenido '.$_SESSION['username'], 'id_usuario' => $row['id']));
			}
            
        }else{
            echo 'no ha funcionado la consulta';
        }
    }else{
        echo 'no hay nada';
    }
}
?>
