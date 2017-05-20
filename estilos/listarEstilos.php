<?php

require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_REQUEST["id_usuario"]) && isset($_REQUEST["tipoConsulta"])){
        if($_REQUEST["tipoConsulta"] == "1"){
            Connexio::queryListaEstilosSoloIdNombre($_REQUEST["id_usuario"]);
        }else{
            print json_encode(array('estado' => '2', 'mensaje' => 'Datos incorrectos'));
        }
    }else{
        print json_encode(array('estado' => '2', 'mensaje' => 'Faltan Datos.'));
    }
}

?>
