<?php

/*
  Autor: Albert Cadena Rubio
  Data última modificació: 29/03/2017
  Objectiu: Classe que gestiona la connexió i les consultes que es fan a la base de dades.
  Fitxers relacionats: mainPage.php
 */

session_start();

class Connexio {

    protected static $connection;
    //protected static $host = "52.56.253.209";
    protected static $host = "localhost";
    protected static $servername = "alcaroldb";
    //protected static $username = "admin";
    //protected static $password = "bemen3";
    protected static $username = "root";
    protected static $password = "";

    /**
     * Constructor de la classe.
     */
    function __construct() {
        $connection;
        $host = $host;
        $servername = $servername;
        $username = $username;
        $password = $password;
    }

    /**
     * Estableix la connexió amb la base de dades
     * @return type Si no s'ha pogut establir connexió, retorna un null.
     * @throws Exception Excepció en la connexió.
     */
    public static function connect() {
        try {
            if ($conn = mysqli_connect(self::$host, self::$username, self::$password, self::$servername)) {
                return $conn;
            } else {
                die("Connection failed: " . $connection->connect_error);
                throw new Exception('Unable to connect');
            }
        } catch (Exception $e) {
            die("Connection failed: " . $connection->connect_error);
            echo($e);
            return null;
        }
    }

    /**
     * Query the database
     *
     * @param $query The query string
     * @return mixed The result of the mysqli::query() function
     */
    public static function query($query) {
        // Connect to the database
        self::$connection = self::connect();

        // Query the database
        $result = mysqli_query(self::$connection, $query) or die(mysqli_error(self::$connection));

        return $result;
    }

    /**
     * Mètode encarregat de validar si el usuari i password están registrat
     * a la base de dades.
     * @param type $username el nom d'usuari per el login
     * @param type $password el password del login
     * @return boolean retorna si la validació de l'usuari ha sigut vàlida o no.
     */
    public static function queryLoadUser($username, $password) {
        self::$connection = self::connect();
        $query = ("SELECT id, nombre, dni "
                . "FROM usuarios WHERE (dni = '" . $username . "' or nombre = '" . $username . "' ) and password = '" . $password . "'");
        $result = mysqli_query(self::$connection, $query);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                //$_SESSION['conexion'] = $connection;

                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['user_dni'] = $row['dni'];
                $_SESSION['id'] = $row['id'];
                /*
                  if ($row["tipus"] == "cuiner") {
                  print json_encode(array('estado' => '1', 'mensaje' => 'Bienvenido '.$_SESSION['nom_usuari'], 'tipus' => 'cuiner'));
                  header('Location: mainPage.php');
                  } else if ($row["tipus"] == "maitre") {
                  print json_encode(array('estado' => '1', 'mensaje' => 'Bienvenido '.$_SESSION['nom_usuari']));
                  header('Location: mainPage.php');
                  } else {
                  print json_encode(array('estado' => '2', 'mensaje' => 'Rol no válido.'));
                  } */
            }
            return true;
        } else {
            echo 'Usuari o contrasenya incorrectes';
            return false;
        }
    }

    /* CARGA DE DATOS DE LOS ESTILOS: */

    /**
     * Carga todos los estilos con todo su contenido de un usuario concreto.
     * @param type $userId
     * @return boolean
     */
    public static function queryListaEstilosCompletos($userId) {
        self::$connection = self::connect();
        $query = ("SELECT * "
                . "FROM estilos WHERE FK_id_usuario = " . $userId);
        $result = mysqli_query(self::$connection, $query);

        $listaEstilos = array();
        $count = 0;

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $listaEstilos["resultadoEstilo" . $count] = array_map('utf8_encode', ['id' => $row["id"],
                    'id_usuario' => $row["FK_id_usuario"],
                    'nombre' => $row["nombre"],
                    'vida' => $row["vida"],
                    'mana' => $row["mana"],
                    'destreza' => $row["destreza"],
                    'percepcion' => $row["percepcion"],
                    'fuerza' => $row["fuerza"],
                    'carisma' => $row["carisma"],
                    'constitucion' => $row["constitucion"],
                    'inteligencia' => $row["inteligencia"],
                    'sabiduria' => $row["sabiduria"]]);

                $count++;
            }
            print json_encode($listaEstilos);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Carga el listado de todos los estilos de un usuario concreto. Pero solo con
     * la información del nombre y id de cada estlio.
     * @param type $userId
     * @return boolean
     */
    public static function queryListaEstilosSoloIdNombre($userId) {
        self::$connection = self::connect();
        $query = ("SELECT id, FK_id_usuario, nombre "
                . "FROM estilos WHERE FK_id_usuario = " . $userId);
        $result = mysqli_query(self::$connection, $query);

        $listaEstilos = array();
        $count = 0;

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $listaEstilos["resultadoEstilo" . $count] = array_map('utf8_encode', ['id' => $row["id"],
                    'id_usuario' => $row["FK_id_usuario"],
                    'nombre' => $row["nombre"]]);

                $count++;
            }
            print json_encode($listaEstilos);
            return true;
        } else {
            print json_encode(array('estado' => '2', 'mensaje' => 'No tienes estilos creados'));
            return false;
        }
    }

    /**
     * Carga toda la información de un estilo concreto.
     * @param type $estiloId
     * @return boolean
     */
    public static function queryEstiloByID($estiloId) {
        self::$connection = self::connect();
        $query = ("SELECT * "
                . "FROM estilos WHERE id = " . $estiloId);
        $result = mysqli_query(self::$connection, $query);

        $listaEstilos = array();
        $count = 0;

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $listaEstilos["resultadoEstilo" . $count] = array_map('utf8_encode', ['id' => $row["id"],
                    'id_usuario' => $row["FK_id_usuario"],
                    'nombre' => $row["nombre"],
                    'vida' => $row["vida"],
                    'mana' => $row["mana"],
                    'destreza' => $row["destreza"],
                    'percepcion' => $row["percepcion"],
                    'fuerza' => $row["fuerza"],
                    'carisma' => $row["carisma"],
                    'constitucion' => $row["constitucion"],
                    'inteligencia' => $row["inteligencia"],
                    'sabiduria' => $row["sabiduria"]]);

                $count++;
            }
            print json_encode($listaEstilos);
            return true;
        } else {
            print json_encode(array('estado' => '2', 'mensaje' => 'No tienes estilos creados'));
            return false;
        }
    }

    /**
     * Metodo par insertar un nuevo Estilo asignado a un id de Usuario.
     * @param type $idUsuario
     * @param type $datosNuevoEstilo
     */
    public static function queryInsertNuevoEstilo($idUsuario, $datosNuevoEstilo) {
        $query = "INSERT INTO estilos(FK_id_usuario, nombre, vida, mana, destreza, percepcion, fuerza, carisma, constitucion, inteligencia, sabiduria) "
                . "values (" . $idUsuario . ","
                . "'" . $datosNuevoEstilo["nombre"] . "',"
                . "'" . $datosNuevoEstilo["vida"] . "',"
                . "'" . $datosNuevoEstilo["mana"] . "',"
                . "'" . $datosNuevoEstilo["destreza"] . "',"
                . "'" . $datosNuevoEstilo["percepcion"] . "',"
                . "'" . $datosNuevoEstilo["fuerza"] . "',"
                . "'" . $datosNuevoEstilo["carisma"] . "',"
                . "'" . $datosNuevoEstilo["constitucion"] . "',"
                . "'" . $datosNuevoEstilo["inteligencia"] . "',"
                . "'" . $datosNuevoEstilo["sabiduria"] . "')";

        $retorno = self::query($query);
        if ($retorno) {
            //Datos insertados correctamente.
            print json_encode(array('estado' => '1', 'mensaje' => 'Datos insertados correctamente', 'id_estilo' => self::getLastEstiloCreadoByUser($idUsuario)));
        } else {
            //Fallo al insertar.
            print json_encode(array('estado' => '2', 'mensaje' => 'Fallo al insertar'));
        }
    }

    /**
     * Retorna la id del último estilo creado por el usuario.
     * @param type $idUsuario
     * @return type
     */
    public static function getLastEstiloCreadoByUser($idUsuario) {
        self::$connection = self::connect();
        $query = ("SELECT id "
                . "FROM estilos WHERE FK_id_usuario = " . $idUsuario . " ORDER BY id DESC LIMIT 1");
        $result = mysqli_query(self::$connection, $query);
        $row = mysqli_fetch_assoc($result);
        return $row["id"];
    }

    public static function queryListaInfoTablaEstilos() {
        self::$connection = self::connect();
        $query = ("SHOW COLUMNS "
                . "FROM estilos WHERE Field not Like 'id' and Field not Like 'FK_id_usuario' and Field not Like 'nombre'");
        $result = mysqli_query(self::$connection, $query);
        $count = 0;
        $listaAtributos = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $listaAtributos["resultadoAtributo" . $count] = array_map('utf8_encode', ['nombre' => $row["Field"]]);
            $count++;
        }
        print json_encode($listaAtributos);
    }

    public static function queryBorrarEstilo($idUsuario, $idEstilo){
        
        $query = "DELETE FROM personajes WHERE FK_id_usuari = ".$idUsuario." and FK_id_estilo = ".$idEstilo;
        $retorno = self::query($query);
        if($retorno){
            $query = "DELETE FROM estilos WHERE FK_id_usuari = ".$idUsuario." and id = ".$idEstilo;
            $retorno = self::query($query);
            if($retorno){
                print json_encode(array('estado' => '1', 'mensaje' => 'Estilo Borrado correctamente'));
            }else{
               print json_encode(array('estado' => '2', 'mensaje' => 'Fallo al borrar estilo')); 
            }
        }else{
            print json_encode(array('estado' => '2', 'mensaje' => 'Fallo al borrar personajes'));
        }
        
    }
    
    /* FIN CARGA DE DATOS DE LOS ESTILOS. */

    /* QUERYS PARA PERSONAJES */

    public static function queryInsertNuevoPersonaje($idUsuario, $datosNuevoEstilo) {
        $query = "INSERT INTO personajes(FK_id_usuari, FK_id_estilo, nombre, vida, mana, destreza, percepcion, fuerza, carisma, constitucion, inteligencia, sabiduria) "
                . "values (" . $idUsuario . ","
                . "" . $datosNuevoEstilo["id_estilo"] . ","
                . "'" . $datosNuevoEstilo["nombre"] . "',"
                . "'" . $datosNuevoEstilo["vida"] . "',"
                . "'" . $datosNuevoEstilo["mana"] . "',"
                . "'" . $datosNuevoEstilo["destreza"] . "',"
                . "'" . $datosNuevoEstilo["percepcion"] . "',"
                . "'" . $datosNuevoEstilo["fuerza"] . "',"
                . "'" . $datosNuevoEstilo["carisma"] . "',"
                . "'" . $datosNuevoEstilo["constitucion"] . "',"
                . "'" . $datosNuevoEstilo["inteligencia"] . "',"
                . "'" . $datosNuevoEstilo["sabiduria"] . "')";

        $retorno = self::query($query);
        if ($retorno) {
            //Datos insertados correctamente.
            print json_encode(array('estado' => '1', 'mensaje' => 'Datos insertados correctamente'));
        } else {
            //Fallo al insertar.
            print json_encode(array('estado' => '2', 'mensaje' => 'Fallo al insertar'));
        }
    }

    public static function queryUpdatePersonaje($idUsuario, $idPersonaje, $datosModificados) {
        $query = "UPDATE personajes "
                . "SET nombre = " . "'" . $datosModificados["nombre"] . "'";

        foreach ($datosModificados as $key => $value) {
            //do something with your $key and $value;
            if($key != 'nombre')$query .= ", ".$key." = '".$value."'";
            
        }
        $query .= " WHERE id = ".$idPersonaje." and FK_id_usuari = ".$idUsuario;
        
        $retorno = self::query($query);
        if ($retorno) {
            //Datos insertados correctamente.
            print json_encode(array('estado' => '1', 'mensaje' => 'Datos modificados correctamente'));
        } else {
            //Fallo al modificar.
            print json_encode(array('estado' => '2', 'mensaje' => 'Fallo al modificar'));
        }
    }

    public static function queryListaPersonajesCompletos($userId, $estiloId) {
        self::$connection = self::connect();
        $query = ("SELECT * "
                . "FROM personajes WHERE FK_id_usuari = " . $userId . " and FK_id_estilo = " . $estiloId);
        $result = mysqli_query(self::$connection, $query) or die(mysqli_error(self::$connection));

        $listaPersonajes = array();
        $count = 0;

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $listaPersonajes["resultadoPersonaje" . $count] = array_map('utf8_encode', ['id' => $row["id"],
                    'id_usuario' => $row["FK_id_usuari"],
                    'nombre' => $row["nombre"],
                    'vida' => $row["vida"],
                    'mana' => $row["mana"],
                    'destreza' => $row["destreza"],
                    'percepcion' => $row["percepcion"],
                    'fuerza' => $row["fuerza"],
                    'carisma' => $row["carisma"],
                    'constitucion' => $row["constitucion"],
                    'inteligencia' => $row["inteligencia"],
                    'sabiduria' => $row["sabiduria"]]);

                $count++;
            }
            print json_encode($listaPersonajes);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fetch rows from the database (SELECT query)
     *
     * @param $query The query string
     * @return bool False on failure / array Database rows on success
     */
    public static function select($query) {
        $rows = array();
        $result = $this->query($query);
        if ($result === false) {
            return false;
        }
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * Fetch the last error from the database
     * 
     * @return string Database error message
     */
    public function error() {
        $connection = $this->connect()[1];
        return $connection->error;
    }

    /**
     * Quote and escape value for use in a database query
     *
     * @param string $value The value to be quoted and escaped
     * @return string The quoted and escaped string
     */
    public function quote($value) {
        $connection = $this->connect()[1];
        return "'" . $connection->real_escape_string($value) . "'";
    }

}
?>

