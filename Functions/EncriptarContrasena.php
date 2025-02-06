<?php
	//Definimos cómo vamos a encriptar la contraseña
	define('METHOD','AES-256-CBC');
	define('SECRET_KEY','@&21123%wqa12/asd$"q23!·$%&');
	define('SECRET_IV','99e59f');
	class EncriptarContrasena 
	{
		public static function encriptar($string)
		{//Realizamos al encriptación
			$output=FALSE;	
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}
	}