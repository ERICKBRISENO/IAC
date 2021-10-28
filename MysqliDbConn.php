<?php
/**
 * Class GenPdoAdminConect
 */
final class MysqliDbConn {

    private static $host = 'localhost';
    private static $usuario = 'saradmon_adminis';
    private static $password = 'SARadmon123';
    private static $base = 'saradmon_A0Config';
    private static $instance;

    /**
     *
     */
    private function __construct() {
    }

    public function __clone() {
    }

    /**
     * @return string
     */
    public function __toString() {
        return 'Conección a Bd';
    }

    /**
     * @return PDO
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {

            $mysqli = new mysqli(self::$host, self::$usuario, self::$password, self::$base);

            /* verificar la conexión */
            if (mysqli_connect_errno()) {
                printf("Falló la conexión: %s\n", mysqli_connect_error());
                exit();
            }

            /* cambiar el conjunto de caracteres a utf8 */
            if (!$mysqli->set_charset("utf8")) {
                printf("Error cargando el conjunto de caracteres utf8: %s\n", $mysqli->error);
            }

            self::$instance = $mysqli;
        }
        return self::$instance;
    }
}