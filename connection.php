<?php

/*
Autor: Albert Cadena Rubio
Data última modificació: 29/03/2017
Objectiu: Classe que gestiona la connexió i les consultes que es fan a la base de dades.
Fitxers relacionats: mainPage.php
*/

ob_start();
session_start();

class Connexio {

    protected static $connection;
    protected static $host = "52.56.253.209";
    protected static $servername = "alcaroldb";
    protected static $username = "admin";
    protected static $password = "bemen3";

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
        $result = mysqli_query(self::$connection, $query);

        return $result;
    }

    /**
     * Mètode encarregat de validar si el usuari i password están registrat
     * a la base de dades, i també valida si és de tipus cuiner o maitre.
     * @param type $username el nom d'usuari per el login
     * @param type $password el password del login
     * @return boolean retorna si la validació de l'usuari ha sigut vàlida o no.
     */
    public static function queryLoadUser($username, $password) {
        self::$connection = self::connect();
        $query = ("SELECT dni, nom, cognoms, password, tipus "
                . "FROM usuaris WHERE (dni = '" . $username . "' or nom = '" . $username . "' ) and password = '" . $password . "'");
        $result = mysqli_query(self::$connection, $query);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                //$_SESSION['conexion'] = $connection;
                $_SESSION['nom_usuari'] = $row["nom"];
                $_SESSION['tipus'] = $row["tipus"];
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
/*
                if ($row["tipus"] == "cuiner") {
                    print json_encode(array('estado' => '1', 'mensaje' => 'Bienvenido '.$_SESSION['nom_usuari'], 'tipus' => 'cuiner'));
                    header('Location: mainPage.php');
                } else if ($row["tipus"] == "maitre") {
                    print json_encode(array('estado' => '1', 'mensaje' => 'Bienvenido '.$_SESSION['nom_usuari']));
                    header('Location: mainPage.php');
                } else {
                    print json_encode(array('estado' => '2', 'mensaje' => 'Rol no válido.'));
                }*/
                
            }
            return true;
        } else {
            echo 'Usuari o contrasenya incorrectes';
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

