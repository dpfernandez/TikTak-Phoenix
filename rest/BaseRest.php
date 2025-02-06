<?php
require_once(__DIR__."/../Model/TikTakPhoenix_Usuarios_Model.php");
require_once(__DIR__."/../Functions/EncriptarContrasena.php");

/**
* Class BaseRest
*
* Superclass for Rest endpoints
*
* It simply contains a method to authenticate users via HTTP Basic Auth against
* the User database via UserMapper.
*
* @author lipido <lipido@gmail.com>
*/
class BaseRest {
	public function __construct() { }

	/**
	* Authenticates the current request. If the request does not contain
	* auth credentials, it will generate a 401 response code and end PHP processing
	* If the request contain credentials, it will be checked against the database.
	* If the credentials are ok, it will return the User object just logged. If the
	* credentials are invalid, it will generate a 401 code as well and end PHP
	* processing.
	*
	* @return User the user just authenticated.
	*/
	public function authenticateUser() {
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
			header($_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized');
			header('WWW-Authenticate: Basic realm="Rest API of TikTakPhoenix"');
			die('This operation requires authentication');
		}
		else {
				$contrasena = EncriptarContrasena::encriptar($_SERVER['PHP_AUTH_PW']);
				$usuario = new Usuarios_Model($_SERVER['PHP_AUTH_USER'],$contrasena,'','','','','');
				if($usuario->validarUsuario()){
					return $usuario;
				}
					
				else{
				
				header($_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized');
				header('Content-Type: application/json');
				header('WWW-Authenticate: Basic realm="TikTakPhoenix"');

				die('The username/password is not valid');
			}
		}
	}
}
