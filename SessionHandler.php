<?php


/**
 * Class MySessionHandler
 */
class MySessionHandler{
	private $PDO;

	private $_Usuario;
	private $_Unico_Ident;
	private $_Ident_User;
	private $_Base;
	private $_Tipo_Usuario;
	private $_Ultimo_Acceso;
	private $_Num_Matchs;

	/**
	 * @param $PDO
	 * @param $sesion
	 */
	public function __construct($PDO){
		$this->PDO=$PDO;
	}

	public function doDeleteSession($sesion){

	}
	public function doCreateSession($user,$sufijo,$tipo_user,$unico_ident,$ident_user){
		do{
		$alias=substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz012345678901234567890123456789',15)),0,100);//CARACTERES ALEATORIOS
		$num=$this->doSelectSession($alias);
		} while ($num > 0);
		$PDO=$this->PDO;
		$sql="INSERT into A0_SESION1357abc (ALIAS,USUARIO,BASE,UNICO_IDENT,IDENT_USER,TIPOUSUARIO)";
		$sql.="values(:alias,:user,:sufijo,:unico_ident,:ident_user,:tipo_user)";
		$query=$PDO->prepare($sql);

		$query->bindValue(':alias',$alias,PDO::PARAM_STR);
		$query->bindValue(':user',$user,PDO::PARAM_STR);
		$query->bindValue(':sufijo',$sufijo,PDO::PARAM_STR);
		$query->bindValue(':tipo_user',$tipo_user,PDO::PARAM_STR);
		$query->bindValue(':unico_ident',$unico_ident,PDO::PARAM_STR);
		$query->bindValue(':ident_user',$ident_user,PDO::PARAM_STR);

		$query->execute();
		return $alias;
	}
	public function doSelectSession($sesion){
		$PDO=$this->PDO;

		$sql="select * from A0_SESION1357abc where ALIAS=:sesion";
		$query=$PDO->prepare($sql);
		$query->bindValue(':sesion',$sesion,PDO::PARAM_STR);
		$query->execute();

		$this->_Num_Matchs=$query->rowCount();

		$result=$query->fetch();

		$this->_Usuario = $result['USUARIO'];
		$this->_Unico_Ident = $result['UNICO_IDENT'];
		$this->_Ident_User = $result['IDENT_USER'];
		$this->_Base = $result['BASE'];
		$this->_Tipo_Usuario = $result['TIPOUSUARIO'];
		$this->_Ultimo_Acceso = $result['ULTIMOACCESO'];

		return $this->_Num_Matchs;
	}
	/**
	 * @return mixed
	 */
	public function getNumMatchs() {
		return $this->_Num_Matchs;
	}

	/**
	 * @return mixed
	 */
	public function getBase() {
		return $this->_Base;
	}

	/**
	 * @return mixed
	 */
	public function getIdentUser() {
		return $this->_Ident_User;
	}

	/**
	 * @return mixed
	 */
	public function getTipoUsuario() {
		return $this->_Tipo_Usuario;
	}

	/**
	 * @return mixed
	 */
	public function getUltimoAcceso() {
		return $this->_Ultimo_Acceso;
	}

	/**
	 * @return mixed
	 */
	public function getUnicoIdent() {
		return $this->_Unico_Ident;
	}

	/**
	 * @return mixed
	 */
	public function getUsuario() {
		return $this->_Usuario;
	}


}
