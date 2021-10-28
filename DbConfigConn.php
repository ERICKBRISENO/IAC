<?php
/**
 * Class GenPdoAdminConect
 */
final class DbConfigConn {

	private static $engine = 'mysql';
	private static $host = 'localhost';
	private static $usuario = 'saradmon_IAC';
	private static $password = 'SARadmon123';
	private static $base = 'saradmon_IAC';
	private static $CONFIG = array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' " );
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
			$conn = self::$engine
				. ':dbname=' . self::$base
				. ';host=' . self::$host
                . ';charset = utf8mb4';
			try {
				$PDO            = new PDO($conn , self::$usuario , self::$password , self::$CONFIG);
				self::$instance = $PDO;
			} catch (PDOException $e) {
				exit('Falló la conexión: ' . $e->getMessage());
			}
		}
		return self::$instance;
	}
}
