<?php
define('ENTORNO','PRODUCTION');
//DEBUG
//PRODUCTION
define('DOMINIO','https://www.sistemaiac.com/');
//define('DOMINIO','/');
define('DOM_IMG',DOMINIO.'IMG/');
define('DOM_IMG_ICO',DOM_IMG.'iconos/');
define('DOM_FILES',DOMINIO.'Files/');
define('DOM_ARCHIVOS_CONDO',DOMINIO.'pantallas/archivos/archivos/');

//.'/'  //ROOT
define('APP_ROOT',$_SERVER['DOCUMENT_ROOT'].'/');
//define('APP_ROOT','http://iac.systemsar.net/');
define('APP_AdminBases',APP_ROOT.'AdminBases/');
define('APP_MODELS',APP_ROOT.'Models/');
define('APP_MODELS_COMMON',APP_MODELS.'Common/');
define('APP_CREATOR',APP_ROOT.'AppCreator/');
define('APP_CONFIG',APP_ROOT.'Configuracion/');
define('APP_CONFIG_TABLES',APP_ROOT.'Configuracion/Tables/');



define('APP_MODELS_AutoDb',APP_MODELS.'AutoDb/');
define('APP_MODELS_UseDb',APP_MODELS.'AutoUseDb/');
define('APP_MODELS_DB_JOIN',APP_MODELS.'DbJoins/');

define('APP_PROCESS',APP_ROOT.'Process/');
define('APP_PROCESS_DBUSE',APP_PROCESS.'DbUseProcess/');
define('APP_PROCESS_DBAUTO',APP_PROCESS.'DbAutoProcess/');

define('APP_VIEWS',APP_ROOT.'Views/');
define('APP_VIEWS_COMMON',APP_VIEWS.'Common/');
define('APP_VIEWS_BASIC_COMPO',APP_VIEWS.'BasicComponents/');

define('APP_EXTERNAL_LIB',APP_ROOT.'lib_PHP/');

define('APP_USER_FILES',APP_ROOT.'UserFiles/');
define('APP_TEMP',APP_ROOT.'TEMP/');

define('APP_MAILER',APP_EXTERNAL_LIB.'PHPMailer-master/');
define('APP_MAILER_6',APP_EXTERNAL_LIB.'PHPMailer6/');

define('APP_OLD_FILES', 'pantallas/archivos/archivos/');
define('DOM_ARCHIVOS_CONDO',DOMINIO.'pantallas/archivos/archivos/');

//CONSTANTES PREDEFINIDAS
$este_año=date('Y');
define('THIS_YEAR',date('Y'));
define('LAST_YEAR',$este_año-1);
define('THIS_MONTH',date('m'));