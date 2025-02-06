<?php

require_once(__DIR__."/../Model/TikTakPhoenix_Videos_Model.php");
require_once(__DIR__."/BaseRest.php");

class VideoRest extends BaseRest{
	
	public function __construct(){
		parent::__construct();
	
	}
	
	public function getVideosUsuario(){
		$currentUser = parent::authenticateUser();
		$login= $currentUser->getLogin();
		
		$videosModel = new Videos_Model('',$login,'','','','','');
		
		$videos= $videosModel->findUserVideos();

		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($videos));
	}
	
	public function findVideosUsuario($login){
		$videosModel = new Videos_Model('',$login,'','','','','');
		
		$videos= $videosModel->findUserVideos();

		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($videos));
	
	}
	
	public function watchVideo($videoId){
		$videosModel = new Videos_Model($videoId,'','','','','','');
		$video = $videosModel->findUserVideoById();
		
		if ($video == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Video with id ".$videoId." not found");
			return;
		}
		
		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($video));
	}
	
	public function hideUnhideVideo($videoId){
		$currentUser = parent::authenticateUser();
		$videosModel = new Videos_Model($videoId,'','','','','','');
		$video = $videosModel->findUserVideoById();

		if ($video == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Video with id ".$videoId." not found");
			return;
		}
		
		$videosModelAutor = new Videos_Model('',$video["autor"],'','','','','');
		$autor=$videosModelAutor->findLoginByAutor();
		
		if ($autor["login"] != $currentUser->getLogin()) {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("you are not the author of this video");
			return;
		}

		if($video["visible"] == "es_visible"){
			$videosModel->Hashtag_VideoBorrarOcultar();
			$videosModel->Ocultar_Video_Actualizar();
			
		}
		else{
			$videosModel->Hashtag_VideoVisible();
			$videosModel->HacerVisible_Video_Actualizar();
		}

		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
	}
	
	
	public function uploadVideo(){
		$currentUser = parent::authenticateUser();
		
		//DATOS PREVIOS-------------------------------------------------------
		//Autor_Vídeo
		$autor=$currentUser->getLogin();
		//Fecha_Subida
		date_default_timezone_set('Europe/Madrid');
		$fecha_subida= date('Y-m-d H:i:s');
		$fecha_subida_simple= date('Y-m-d-H-i-s');
		//Nombre_Vídeo
		$nombre_video_antes= $_FILES['file']['name'];
		$nombre_video=$fecha_subida_simple.$nombre_video_antes;
		//Ubicación_Vídeo
		$carpeta_usuario_video="../Files/Videos/".$autor."/";
		$dir_videoFinal=$carpeta_usuario_video.$nombre_video;
		//Configuración_Vídeo
		$maxTam_video = 500000000;
		$videoExtensiones_permitidas = array("webm","mp4","avi","3gp","mov","mpeg");
		//Tipo fichero
		$extension_video = strtolower(pathinfo($dir_videoFinal,PATHINFO_EXTENSION));
		//------------------------------------------//
		//-----------//TAMAÑO//----------------------//
		//------------------------------------------//
		if(($_FILES['file']['size'] < $maxTam_video) && ($_FILES['file']['size'] > 0))
		{
				//------------------------------------------//
				//-----------//EXTENSION//----------------------//
				//------------------------------------------//
				$ext_nombre_video = new SplFileInfo($nombre_video);
				$ext_nombre_video =$ext_nombre_video->getExtension();
				if( in_array($ext_nombre_video,$videoExtensiones_permitidas) )//Comprueba si un valor existe en un array
				{
					$video = new Videos_Model('',$autor,$nombre_video,$_POST['text'],$dir_videoFinal,$fecha_subida,'');//En este CASE añadiremos los datos
					$respuesta = $video->ComprobarADD();
					if ($respuesta == 'true')//Si son correctos los insertará y se logueará en el sistema y si no lo son te reenviará a una página donde te dirá el error.
					{		
							$respuesta = $video->anadir();//Añade los datos
							if($respuesta == 'true')//Lanza un mensaje segun el resultado.
							{
								$array = [];//array vacio que nos servira luego
								preg_match_all("/(\B#\w\w+)/", $_POST['text'], $matches, PREG_PATTERN_ORDER);//Comprueba si la expresion regular esta en el texto que metemos
								$coincidencias=array_unique($matches[0]);//eliminamos posible duplicados con array_unique
								foreach ($coincidencias as $match)//recorremos empezando desde la posicion 0 hasta el final todas las coincidencias de la expresion regular
								{
									$cadena=print_r($match,true);//Guarda la cadena si el usuario metio hashtags en el texto
									$fecha= date('Y-m-d');//Fija la fecha
									$carpeta=ltrim($cadena, $cadena[0]);//Nos sirve para quitar la almohadilla('#') para crear una carpeta para el hashtag
									array_push($array,new Videos_Model('','',$cadena,'','',$fecha,''));//metemos en el array vacio creado al principio el nombre de cada hashtag mencionado
									//CrearCarpeta_SiNoEstáCreada(Hashtag)------------------------------------------------
									if (!is_dir("../Files/Hashtags/".$carpeta))//Si no existe el directorio lo crea
									{
										mkdir(("../Files/Hashtags/".$carpeta), 0777);
									}
								}
								foreach($array as $valores)//Recorremos el array de models
								{
									$valores->AnadirHashtag_Actualizar();//En caso de ser nombrado por primera vez, añade el hashtag listado 0 veces, si ya ha sido nombrado enocasiones previas, suma 1 a las veces que lo listaron
								}	
								//CrearCarpeta_SiNoEstáCreada(Video)------------------------------------------------
								if (!is_dir("../Files/Videos/".$autor))//Si no existe el directorio lo crea
								{
									mkdir(("../Files/Videos/".$autor), 0777);
								}
								if(move_uploaded_file($_FILES['file']['tmp_name'],$dir_videoFinal))//Mueve un archivo subido a una nueva ubicación
								{
									header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
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
		else 
		{
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
		}
	}
	
	public function deleteVideo($videoId) {
		$currentUser = parent::authenticateUser();
		$videosModelBorrar = new Videos_Model($videoId,'','','','','','');
		$video = $videosModelBorrar->findUserVideoById();

		if ($video == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Video with id ".$videoId." not found");
			return;
		}
		
		$videosModelAutor = new Videos_Model('',$video["autor"],'','','','','');
		$autor=$videosModelAutor->findLoginByAutor();
		
		if ($autor["login"] != $currentUser->getLogin()) {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("you are not the author of this video");
			return;
		}
		
		$videosModelBorrar->Hashtag_VideoBorrarOcultar();
		$videosModelBorrar->borrar();
		unlink($video["ubicacion"]);

		header($_SERVER['SERVER_PROTOCOL'].' 204 No Content');
	}
	
	public function getAllHashtags() {
		$videosModel = new Videos_Model('','','','','','','');
		
		$hashtags= $videosModel->findAllHashtags();

		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($hashtags));
	}
	
	
}

// URI-MAPPING for this Rest endpoint
$videoRest = new VideoRest();
URIDispatcher::getInstance()
->map("GET",	"/video", array($videoRest,"getVideosUsuario"))
->map("GET",	"/video/videos/$1", array($videoRest,"findVideosUsuario"))
->map("GET",	"/video/hashtag", array($videoRest,"getAllHashtags"))
->map("GET",	"/video/$1", array($videoRest,"watchVideo"))
->map("POST",	"/video", array($videoRest,"uploadVideo"))
->map("PUT",	"/video/$1", array($videoRest,"hideUnHideVideo"))
->map("DELETE", "/video/$1", array($videoRest,"deleteVideo"));