<?php
class BasesData{
	private $PDO;

	private $_Identificador;
	private $_Base_Datos;
	private $_Num_Matchs;
	private $db_user='saradmon_adminis';
	//private $db_user='saradmon_adminis';
	public function __construct($PDO){
		$this->PDO=$PDO;
	}

	public function getBaseByIdent($value){
		$PDO=$this->PDO;
		$sql="select * from A0_BASES123 where IDENTIFY254=:value";
		$query=$PDO->prepare($sql);
		$query->bindValue(':value',$value,PDO::PARAM_STR);
		$query->execute();

		$this->_Num_Matchs=$query->rowCount();

		$result=$query->fetch();

		$this->_Identificador = $result['IDENTIFY254'];
		$this->_Base_Datos = $result['BASEDATA852'];
		return $this->_Num_Matchs;
	}
	public function getBaseConn($Base){
		$direccion = 'localhost:3306';
		$usuario = $this->db_user;
		$password = 'SARadmon123';
		$base="saradmon_".$Base;
		if (!($link=mysql_connect($direccion,$usuario,$password)))
		{echo "Error conectando a la base de datos.";exit();}
		if (!mysql_select_db($base,$link))
		{echo "Error seleccionando la base de datos.";exit();   }
		return $link;
	}
	public function getGenBadSysConn(){
		$direccion = 'localhost:3306';
		$usuario = $this->db_user;
		$password = 'SARadmon123';
		$base="saradmon_IAC";
		if (!($link=mysql_connect($direccion,$usuario,$password)))
		{echo "Error conectando a la base de datos.";exit();}
		if (!mysql_select_db($base,$link))
		{echo "Error seleccionando la base de datos.";exit();   }
		return $link;
	}
	/**
	 * @param mixed $Base_Datos
	 */
	public function setBaseDatos($Base_Datos) {
		$this->_Base_Datos = $Base_Datos;
	}

	/**
	 * @return mixed
	 */
	public function getBaseDatos() {
		return $this->_Base_Datos;
	}

	/**
	 * @param mixed $Identificador
	 */
	public function setIdentificador($Identificador) {
		$this->_Identificador = $Identificador;
	}

	/**
	 * @return mixed
	 */
	public function getIdentificador() {
		return $this->_Identificador;
	}

	/**
	 * @param mixed $Num_Matchs
	 */
	public function setNumMatchs($Num_Matchs) {
		$this->_Num_Matchs = $Num_Matchs;
	}

	/**
	 * @return mixed
	 */
	public function getNumMatchs() {
		return $this->_Num_Matchs;
	}

}