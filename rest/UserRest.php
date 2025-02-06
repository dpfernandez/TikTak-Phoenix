<?php

require_once(__DIR__."/../Model/TikTakPhoenix_Usuarios_Model.php");
require_once(__DIR__."/BaseRest.php");
require_once(__DIR__."/../Functions/EncriptarContrasena.php");

/**
* Class UserRest
*
* It contains operations for adding and check users credentials.
* Methods gives responses following Restful standards. Methods of this class
* are intended to be mapped as callbacks using the URIDispatcher class.
*
*/
/**
* Class UserRest
*
* It contains operations for adding and check users credentials.
* Methods gives responses following Restful standards. Methods of this class
* are intended to be mapped as callbacks using the URIDispatcher class.
*
*/
class UserRest extends BaseRest {

	public function __construct() {
		parent::__construct();
	}

	public function registro($data) {
		$passEncrip=EncriptarContrasena::encriptar($data->contrasena);
		$user= new Usuarios_Model($data->login,$passEncrip,'usuario_normal',$data->alias,$data->email,$data->nacimiento,'');
		$comprobacion= $user->ComprobarRegistro();
		
		if($comprobacion == true){
			$user->registrar();
			header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
			header("Location: ".$_SERVER['REQUEST_URI']."/".$data->login);
		}
		else {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			die("select different login and/or email please");
		}
	}

	public function login($login) {
		$currentLogged = parent::authenticateUser();
		if ($currentLogged->getLogin() != $login) {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("You are not authorized to login as anyone but you");
		} else {
			header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
			echo("Hello ".$login);
		}
	}

	public function getAllUserData() {
		$userModel= new Usuarios_Model('','','','','','','');
		$users= $userModel->buscarUsuariosDB();
		
		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($users));
		
	}

	
	public function getUserData() {
		$currentLogged = parent::authenticateUser();
		$login= $currentLogged->getLogin();
		$userModel= new Usuarios_Model($login,'','','','','','');
		$user= $userModel->buscarUsuarioPorLogin();
		
		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($user));
		
	}
	
	
	public function findUserDataByLogin($login) {
		$userModel= new Usuarios_Model($login,'','','','','','');
		$user= $userModel->buscarUsuarioPorLogin();
		
		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($user));
		
	}
	
	public function findUserDataByVideoId($id) {
		$userModel= new Usuarios_Model($id,'','','','','','');
		$user= $userModel->buscarUsuarioPorIdVideo();
		
		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($user));
		
	}
	
	public function changeUserPhoto() {
		 $currentLogged = parent::authenticateUser();
		 $autor= $currentLogged->getLogin();
		 if(!empty($_FILES['file'])){//Con file
			//DATOS PREVIOS-------------------------------------------------------
			//Fecha_Subida
			date_default_timezone_set('Europe/Madrid');
			$fecha_subida= date('Y-m-d H:i:s');
			//Nombre_Vídeo
			$nombre_imagen= $_FILES['file']['name'];
			//Ubicación_Vídeo
			$carpeta_usuario_imagen="../Files/Imagenes/".$autor."/";
			$dir_imagenFinal=$carpeta_usuario_imagen.$nombre_imagen;
			//Configuración_Vídeo
			$maxTam_imagen = 41943040;
			$imagenExtensiones_permitidas = array("png","PNG","jpg","JPG","jpeg","JPEG","gif","GIF");
			//------------------------------------------//
			//-----------//TAMAÑO//----------------------//
			//------------------------------------------//
			if(($_FILES['file']['size'] < $maxTam_imagen) || ($_FILES['file']['size'] > 0))
			{
				//------------------------------------------//
				//-----------//EXTENSION//----------------------//
				//------------------------------------------//
				$ext_nombre_imagen = new SplfileInfo($nombre_imagen);
				$ext_nombre_imagen =$ext_nombre_imagen->getExtension();
				if( in_array($ext_nombre_imagen,$imagenExtensiones_permitidas) )//Comprueba si un valor existe en un array
				{
					$usuario = new Usuarios_Model($autor,'','','','','', $dir_imagenFinal);
					
						$respuesta = $usuario->editarFoto();//Añade los datos
						if($respuesta == 'true')//Lanza un mensaje segun el resultado.
						{
							//CrearCarpeta_SiNoEstáCreada------------------------------------------------
							if (!is_dir("../Files/Imagenes/".$autor))//Si no existe el directorio lo crea
							{
								mkdir(("../Files/Imagenes/".$autor), 0777);
							}
							if(move_uploaded_file($_FILES['file']['tmp_name'],$dir_imagenFinal))//Mueve un archivo subido a una nueva ubicación
							{
								header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
							}
							else
							{
								header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
							}
						}
						else
						{
							header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
						}
					
				}
				else 
				{
					header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
				}
			}			
			else 
			{
				header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			}
		 }
						
	}
	
	public function editUserData($data){
		$currentLogged = parent::authenticateUser();
		$login= $currentLogged->getLogin();
		$userModel= new Usuarios_Model($login,'','','','','','');
		$user= $userModel->buscarUsuarioPorLogin();
		$rol= $user['rol'];
		if(!empty($data->alias) && !empty($data->email) && !empty($data->birthday) && !empty($data->password)){
			if($data->password == $data->repeatPassword){  //MODIFICAR el usuario que elijas//Comprobamos si ambas contraseñas son iguales, si no lo son se interrumpe todo y envio un mensaje
				$pass=$data->password;
				$passEncrip=EncriptarContrasena::encriptar($pass);	//Transformamos la contraseña, encriptandola antes de enviarlos
				$regFecha=$data->birthday;//Almacenamos su fecha de nacimiento para saber si es menor de edad
				$fechaNac = new DateTime($regFecha);
				$hoy = new DateTime();
				$anno = $hoy->diff($fechaNac);
				$edad=$anno->y;
				if($edad>=18){//Si es menor de edad se interrumpe pero sino continuamos con la comprobaciones.
							
					if (preg_match("/\\s/", $data->alias) || preg_match("/\\s/", $data->email) || preg_match("/\\s/", $data->password)){
						header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
						die("blank spaces in fields");
					}
					else{
						if($login == $data->alias){
							header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
							die("login and alias can't match!");
						}
						else{
								$usuario = new Usuarios_Model($login, $passEncrip, $rol, $data->alias, $data->email, $data->birthday, '');
								$respuesta = $usuario->ComprobacionEdit();
								if ($respuesta == 'true')//Si son correctos los insertará y se logueará en el sistema y si no lo son te reenviará a una página donde te dirá el error.
								{
									$respuesta = $usuario->editar_SinFoto();//Añade los datos
									if($respuesta == 'true')//Lanza un mensaje segun el resultado.
									{
										header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
									}
									else
									{
										header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
										echo("data can't be updated");
										
									}
								}
								else
								{
									header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
									die("something is wrong with added data");
									
									
								}
						}
					}
					
				}
				else { //Menor de Edad, no debería estar aquí.
					
						header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
						die("underage user");
						
				}	
			}
							
			else{ //Ambas contraseñas no son iguales, envio un mensaje
					header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
					die("no matching passwords");
					
			}
		}
		
		else{
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			die("blank fields");
				
		
		}
	}

}


// URI-MAPPING for this Rest endpoint
$userRest = new UserRest();
URIDispatcher::getInstance()
->map("GET",	"/user/users", array($userRest,"getAllUserData"))
->map("GET",	"/user/login/$1", array($userRest,"findUserDataByLogin"))
->map("GET",	"/user/idvideo/$1", array($userRest,"findUserDataByVideoId"))
->map("GET",	"/user", array($userRest,"getUserData"))
->map("GET",	"/user/$1", array($userRest,"login"))
->map("PUT",	"/user", array($userRest,"editUserData"))
->map("POST",	"/user/$1", array($userRest,"changeUserPhoto"))
->map("POST", "/user", array($userRest,"registro"));