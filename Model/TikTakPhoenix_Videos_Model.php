<?php
class Videos_Model
{
	//USUARIO
	var $id;
	var $autor;	// declaración del atributo autor
	var $nombre; // declaración del atributo nombre
	var $texto; // declaración del atributo texto
	var $ubicacion; // declaración del atributo ubicacion
	var $fecha_subida; // declaración del atributo fecha_subida
	var $visible; // declaración del atributo visible
	//BD
	var $mysqli; // declaración del atributo manejador de la bd

	


	
	
	
	//------------------------
	//Constructor de la clase
	//------------------------
	function __construct($id,$autor,$nombre,$texto,$ubicacion,$fecha_subida,$visible)
	{
			//asignación de valores de parámetro a los atributos de la clase
		$this->id = $id;
		$this->autor = $autor;
		$this->nombre = $nombre;
		$this->texto = $texto;
		$this->ubicacion = $ubicacion;
		$this->fecha_subida = $fecha_subida;
		$this->visible = $visible;
		
		include_once '../Model/Access_DB.php';// incluimos la funcion de acceso a la bd
		$this->mysqli = ConnectDB();// conectamos con la bd y guardamos el manejador en un atributo de la clase
	}
	
	public function getID() {
		return $this->id;
	}

	
	public function getAutor() {
		return $this->autor;
	}
	
	public function setAutor($autor) {
		$this->autor = $autor;
	}
	
	public function getNombre() {
		return $this->nombre;
	}

	
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}
	
	public function getTexto() {
		return $this->texto;
	}

	
	public function setTexto($texto) {
		$this->texto = $texto;
	}
	
	public function getUbicacion() {
		return $this->ubicacion;
	}

	
	public function setUbicacion($ubicacion) {
		$this->ubicacion = $ubicacion;
	}
	
	
	public function getFechaSubida() {
		return $this->fecha_subida;
	}

	
	public function setFechaSubida($fecha_subida) {
		$this->fecha_subida = $fecha_subida;
	}
	
	public function getVisible() {
		return $this->visible;
	}

	
	public function setVisible($visible) {
		$this->visible = $visible;
	}


	
	
	
	
	
//--------------------------------------------------------------------------------------------------------------------
//Metodos VIDEO-------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------



		
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo AÑADIR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
			//Funcion enfocada a COMPROBAR los datos que pretendes insertar en la BD
			function ComprobarADD()
			{//Como mucho comprobar si existe un texto identico mirar si el video vinculado tambien lo es
				return true;
			}	
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				

			
			
				//Función enfocada a ESCRIBIR los datos en la BD
			function anadir()//Insertar los datos en la BD
			{
					$sql = "INSERT INTO VIDEOS 
								(
									autor,
									nombre,
									texto,
									ubicacion,
									fecha_subida
								) 
							VALUES 
								(
									(SELECT id FROM usuarios WHERE login='".$this->autor."'),
									'".$this->nombre."',
									'".$this->texto."',
									'".$this->ubicacion."',
									'".$this->fecha_subida."'
								)";
					if (!$this->mysqli->query($sql)) //Comprobar reacción
					{
						return 'respuesta_NOadd';//Enviamos esta sentencia para que lo interprete el Switch y así comunicatselo al MESSAGE
					}
					
					else
					{
						return true;
					}		
			}
		
		
		
		
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo EDITAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------


				//Función enfocada a COMPROBAR los datos que quieres insertar en la tabla
			function ComprobacionEdit()
			{
				//Como mucho comprobar si existe un texto identico mirar si el video vinculado tambien lo es
				return true;
			}

			
			
			
				//Función enfocada a ACTUALIZAR los datos en la BD
			function editar()//ACTUALIZAR los datos en la BD
			{
					$sql = "UPDATE `videos` SET 
								`autor`='".$this->autor."',
								`nombre`='".$this->nombre."',
								`texto`='".$this->texto."',
								`ubicacion`='".$this->ubicacion."',
								`fecha_subida`='".$this->fecha_subida."',
								`visible`='".$this->visible."'
								WHERE
								`id`='".$this->id."'";
					if (!$this->mysqli->query($sql)) //Comprobar reacción
					{
						return 'respuesta_NOedit'; //No consigue ACTUALIZAR
					}
					
					else
					{
						return true; //Consigue ACTUALIZAR
					}
			}



		
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo BORRAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------


				//Función enfocada a BORRAR una tupla en la BD
			function borrar()
			{
				//Borramos los Likes del Video
				$sql = "DELETE FROM `videos_likes` WHERE `id_video` =  '".$this->id."'";//BORRAR los datos en la BD en base al ID
				if (!$this->mysqli->query($sql)) 
				{
					return 'respuesta_NOdel'; //No consigue BORRAR
				}
				else
				{
					//Borramos los Favoritos del Video
					$sql = "DELETE FROM `videos_favoritos` WHERE `id_video` =  '".$this->id."'";//BORRAR los datos en la BD en base al ID
					if (!$this->mysqli->query($sql)) 
					{
						return 'respuesta_NOdel'; //No consigue BORRAR
					}
					else
					{
						//Borramos el Hashtags del Vídeo
						$sql = "DELETE FROM `videos_hashtags` WHERE `id_video` =  '".$this->id."'";//BORRAR los datos en la BD en base al ID
						if (!$this->mysqli->query($sql)) 
						{
							return 'respuesta_NOdel'; //No consigue BORRAR
						}
						else
						{
							//Borramos el VIDEO
							$sql = "DELETE FROM `videos` WHERE `id` =  '".$this->id."'";//BORRAR los datos en la BD en base al ID
							if (!$this->mysqli->query($sql)) 
							{
								return 'respuesta_NOdel'; //No consigue BORRAR
							}
							else
							{
								//Actualizar Lista de hashtag donde aparecía este vídeo (pendiente de implementar)
								return true; //Consigue BORRAR
							}
						}
					}
				}
			}
		
		

		
		
		
		
		
		
		
		
		
//--------------------------------------------------------------------------------------------------------------------
//Metodo MOSTRAR DATOS------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
		//---------------
		//NUMERO DE FILAS
		//---------------
				function verN_Video()//Vista_showALL
				{
						$sql = "SELECT COUNT(id) AS N
							FROM videos
							WHERE id>0
							ORDER BY autor";
						$resultado = $this->mysqli->query($sql);
						$tupla = $resultado->fetch_array();
						return $tupla;
				}
				
				
				
				
				
		//------------
		//VER un VALOR
		//------------
				//----------------------VER_USUARIOS
					//Función enfocada a VER el NOMBRE de los USUARIOS con respecto a la TABLA
					function VER_USUARIOS()
					{
							//------------------------------------------//
							//-----------//USUARIOS//----------------------//
							//------------------------------------------//
								//MOSTRAR todos los datos de la tabla USUARIOS
								$sql = "SELECT 	id,
												login,
												alias,
												rol,
												email,
												nacimiento,
												foto_perfil,
												n_seguidores
											FROM usuarios
											ORDER BY FIELD (rol, 'administrador', 'usuario_normal') ASC, login
										";
								$resultado = $this->mysqli->query($sql);
								if (!$this->mysqli->query($sql))
								{ 
									return 'respuesta_NOall'; //No consigue MOSTRAR
								}
								else
								{ 
									$result = $resultado;  //Consigue MOSTRAR
									return $result;  //Devuleve los datos a MOSTRAR
								}
					}
				//----------------------VER_USUARIO
					//Ver datos de un usuario
					function VER_USUARIO_ID()
					{
							//------------------------------------------//
							//-----------//USUARIOS//----------------------//
							//------------------------------------------//
								//MOSTRAR todos los datos de la tabla USUARIOS
								$sql = "SELECT 	id,
												login,
												alias,
												rol,
												email,
												nacimiento,
												foto_perfil,
												n_seguidores
											FROM usuarios
											WHERE
											id='".$this->id."'
										";
						$resultado = $this->mysqli->query($sql);
						$tupla = $resultado->fetch_array();
						return $tupla;
					}
					function VER_USUARIO_LOGIN()
					{
							//------------------------------------------//
							//-----------//USUARIOS//----------------------//
							//------------------------------------------//
								//MOSTRAR todos los datos de la tabla USUARIOS
								$sql = "SELECT 	id,
												login,
												alias,
												rol,
												email,
												nacimiento,
												foto_perfil,
												n_seguidores
											FROM usuarios
											WHERE
											login='".$this->autor."'
										";
						$resultado = $this->mysqli->query($sql);
						$tupla = $resultado->fetch_array();
						return $tupla;
					}
				//----------------------VER_VIDEOS
					//Función enfocada a VER datos de varios videos
					function VER_VIDEOS()
					{
							//------------------------------------------//
							//-----------//VIDEOS//----------------------//
							//------------------------------------------//
								//MOSTRAR todos los datos de la tabla VIDEOS
								$sql = "SELECT 	id,
												autor,
												nombre,
												texto,
												ubicacion,
												fecha_subida
											FROM videos
										";
								$resultado = $this->mysqli->query($sql);
								if (!$this->mysqli->query($sql))
								{ 
									return 'respuesta_NOall'; //No consigue MOSTRAR
								}
								else
								{ 
									$result = $resultado;  //Consigue MOSTRAR
									return $result;  //Devuleve los datos a MOSTRAR
								}
					}
				//----------------------VER_VIDEO
					//Ver datos de un video
					function VER_VIDEO()
					{
							//------------------------------------------//
							//-----------//VIDEOS//----------------------//
							//------------------------------------------//
								//MOSTRAR todos los datos de la tabla VIDEOS
								$sql = "SELECT 	id,
												autor,
												nombre,
												texto,
												ubicacion,
												fecha_subida
											FROM videos
											WHERE
											login='".$this->id."'
										";
						$resultado = $this->mysqli->query($sql);
						$tupla = $resultado->fetch_array();
						return $tupla;
					}

			

			
					

			
			
			

			
		
		
		
		
		
		
		
		
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo MOSTRAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		
		
			//----------------------SHOW_ALL
			function ShowAll()//Función enfocada a MOSTRAR todos los datos de la BD
			{
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
								VV.id,
								(SELECT login FROM usuarios WHERE id=VV.autor),
								(SELECT alias FROM usuarios WHERE id=VV.autor),
								(SELECT foto_perfil FROM usuarios WHERE id=VV.autor),
								VV.nombre,
								VV.texto,
								VV.ubicacion,
								VV.fecha_subida,
								VV.n_likes,
								VV.autor,
								
								/*1 si el usuario logueado lo sigue - 0 si no lo hace*/
								(SELECT COUNT(id) FROM seguidores WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND login=VV.autor),
								
								/*1 si el usuario logueado le dio like - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_likes WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el usuario logueado lo metio en favoritos - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_favoritos WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el video es visible - 0 si no lo es*/
								(SELECT COUNT(id) FROM videos WHERE visible='es_visible' AND id=VV.id)

								FROM videos VV
								WHERE VV.id>0
							ORDER BY VV.fecha_subida DESC,VV.autor,VV.texto,VV.ubicacion) i
						";
				$resultado = $this->mysqli->query($sql);
				if (!$this->mysqli->query($sql))
				{ 
					return 'respuesta_NOall'; //No consigue MOSTRAR
				}
				else
				{ 
					$result = $resultado;  //Consigue MOSTRAR
					return $result;  //Devuleve los datos a MOSTRAR
				}
			}
		
		
		
		
		
			//----------------------SHOW_ALL_Visible
			function ShowAll_Visible()
			{
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
								VV.id,
								(SELECT login FROM usuarios WHERE id=VV.autor),
								(SELECT alias FROM usuarios WHERE id=VV.autor),
								(SELECT foto_perfil FROM usuarios WHERE id=VV.autor),
								VV.nombre,
								VV.texto,
								VV.ubicacion,
								VV.fecha_subida,
								VV.n_likes,
								VV.autor,
								
								/*1 si el usuario logueado lo sigue - 0 si no lo hace*/
								(SELECT COUNT(id) FROM seguidores WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND login=VV.autor),

								/*1 si el usuario logueado le dio like - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_likes WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el usuario logueado lo metio en favoritos - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_favoritos WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el video es visible - 0 si no lo es*/
								(SELECT COUNT(id) FROM videos WHERE visible='es_visible' AND id=VV.id)
								
								FROM videos VV
								WHERE VV.id>0 AND VV.visible='es_visible'
							ORDER BY VV.fecha_subida DESC,VV.autor,VV.texto,VV.ubicacion) i
						";
				$resultado = $this->mysqli->query($sql);
				if (!$this->mysqli->query($sql))
				{ 
					return 'respuesta_NOall'; //No consigue MOSTRAR
				}
				else
				{ 
					$result = $resultado;  //Consigue MOSTRAR
					return $result;  //Devuleve los datos a MOSTRAR
				}
			}
			
			//----------------------SHOW_ALL_Visible_Sigo
			function ShowAll_Visible_Sigo()
			{
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
								VV.id,
								(SELECT login FROM usuarios WHERE id=VV.autor),
								(SELECT alias FROM usuarios WHERE id=VV.autor),
								(SELECT foto_perfil FROM usuarios WHERE id=VV.autor),
								VV.nombre,
								VV.texto,
								VV.ubicacion,
								VV.fecha_subida,
								VV.n_likes,
								VV.autor,
								
								/*1 si el usuario logueado lo sigue - 0 si no lo hace*/
								(SELECT COUNT(id) FROM seguidores WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND login=VV.autor),

								/*1 si el usuario logueado le dio like - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_likes WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el usuario logueado lo metio en favoritos - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_favoritos WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el video es visible - 0 si no lo es*/
								(SELECT COUNT(id) FROM videos WHERE visible='es_visible' AND id=VV.id)
								
								FROM videos VV
								WHERE VV.id>0 AND VV.visible='es_visible' AND (SELECT COUNT(id) FROM seguidores WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND login=VV.autor)=1
							ORDER BY VV.fecha_subida DESC,VV.autor,VV.texto,VV.ubicacion) i
						";
				$resultado = $this->mysqli->query($sql);
				if (!$this->mysqli->query($sql))
				{ 
					return 'respuesta_NOall'; //No consigue MOSTRAR
				}
				else
				{ 
					$result = $resultado;  //Consigue MOSTRAR
					return $result;  //Devuleve los datos a MOSTRAR
				}
			}
			//----------------------SHOW_ALL_Visible_Sigo
			function ShowAll_Visible_NoSigo()
			{
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
								VV.id,
								(SELECT login FROM usuarios WHERE id=VV.autor),
								(SELECT alias FROM usuarios WHERE id=VV.autor),
								(SELECT foto_perfil FROM usuarios WHERE id=VV.autor),
								VV.nombre,
								VV.texto,
								VV.ubicacion,
								VV.fecha_subida,
								VV.n_likes,
								VV.autor,
								
								/*1 si el usuario logueado lo sigue - 0 si no lo hace*/
								(SELECT COUNT(id) FROM seguidores WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND login=VV.autor),

								/*1 si el usuario logueado le dio like - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_likes WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el usuario logueado lo metio en favoritos - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_favoritos WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el video es visible - 0 si no lo es*/
								(SELECT COUNT(id) FROM videos WHERE visible='es_visible' AND id=VV.id)
								
								FROM videos VV
								WHERE VV.id>0 AND VV.visible='es_visible' AND (SELECT COUNT(id) FROM seguidores WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND login=VV.autor)=0
							ORDER BY VV.fecha_subida DESC,VV.autor,VV.texto,VV.ubicacion) i
						";
				$resultado = $this->mysqli->query($sql);
				if (!$this->mysqli->query($sql))
				{ 
					return 'respuesta_NOall'; //No consigue MOSTRAR
				}
				else
				{ 
					$result = $resultado;  //Consigue MOSTRAR
					return $result;  //Devuleve los datos a MOSTRAR
				}
			}
			//Ver_Número_Videos_Visible
			function ShowAll_Visible_n()//Vista_showALL
			{
				$sql = "SELECT 	COUNT(id)
								FROM videos
								WHERE id>0 AND visible='es_visible'
							ORDER BY fecha_subida DESC,autor,texto,ubicacion";
				$resultado = $this->mysqli->query($sql);
				$tupla = $resultado->fetch_array();
				return $tupla;
			}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
			//----------------------ShowAll_CE_usuario
				//MOSTRAR datos de un USUARIO
			function ShowAll_CE_usuario()
			{
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
								id,
								(SELECT login FROM usuarios WHERE id=autor),
								(SELECT alias FROM usuarios WHERE id=autor),
								(SELECT alias FROM usuarios WHERE id=autor),
								(SELECT foto_perfil FROM usuarios WHERE id=autor),
								nombre,
								texto,
								ubicacion,
								fecha_subida
								
								FROM videos
                                WHERE autor ='".$this->autor."'
							ORDER BY fecha_subida DESC,texto,ubicacion) i
								";
				$resultado = $this->mysqli->query($sql);
				if (!$this->mysqli->query($sql))
				{ 
					return 'respuesta_NOall'; //No consigue MOSTRAR
				}
				else
				{ 
					$result = $resultado;  //Consigue MOSTRAR
					return $result;  //Devuleve los datos a MOSTRAR
				}
			}
		

		
		

			
			
			//----------------------SHOW_CURRENT
				//Función enfocada a MOSTRAR los datos  de una tupla en concreto de la BD
			function ShowCurrent()
			{
				//MOSTRAR los datos de la tabla con el LOGIN especifico
				$sql = "SELECT
								VV.visible,
								VV.id,
								(SELECT login FROM usuarios WHERE id=VV.autor),
								(SELECT alias FROM usuarios WHERE id=VV.autor),
								(SELECT foto_perfil FROM usuarios WHERE id=VV.autor),
								VV.nombre,
								VV.texto,
								VV.ubicacion,
								VV.fecha_subida,
								VV.n_likes,
								VV.autor,
								
								/*1 si el usuario logueado lo sigue - 0 si no lo hace*/
								(SELECT COUNT(id) FROM seguidores WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND login=VV.autor),

								/*1 si el usuario logueado le dio like - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_likes WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el usuario logueado lo metio en favoritos - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_favoritos WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el video es visible - 0 si no lo es*/
								(SELECT COUNT(id) FROM videos WHERE visible='es_visible' AND id=VV.id)
								
								FROM videos VV
                                WHERE 
								VV.id = '".$this->id."'
								";
				$resultado = $this->mysqli->query($sql);
				if (!$this->mysqli->query($sql))
				{ 
					return 'respuesta_NOcur'; //No consigue MOSTRAR
				}
				else
				{ 
					$result = $resultado->fetch_array();
					return $result; //Devuleve los datos a MOSTRAR
				}
				
			}
		
		
		
		
		
		
		
		
		
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo BUSCAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------

				//Función enfocada a BUSCAR los datos en la BD
			function Buscar()
			{		
				//BUSCAR los datos en la BD buscando con LIKE alguna coincidencia, devolviendo aquellas tuplas que tengan algo en común con lo pedido
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
									id,
									(SELECT login FROM usuarios WHERE id=autor),
									(SELECT alias FROM usuarios WHERE id=autor),
									(SELECT alias FROM usuarios WHERE id=autor),
									(SELECT foto_perfil FROM usuarios WHERE id=autor),
									nombre,
									texto,
									ubicacion,
									fecha_subida
								FROM videos
                                WHERE 	
									autor LIKE '%".$this->autor."%' AND
									nombre LIKE '%".$this->nombre."%' AND
									texto LIKE '%".$this->texto."%' AND
									ubicacion LIKE '%".$this->ubicacion."%' AND
									fecha_subida LIKE '%".$this->fecha_subida."%'
								ORDER BY fecha_subida DESC,texto,ubicacion) i
									";

				$resultado = $this->mysqli->query($sql);
				if (!$this->mysqli->query($sql))
				{ 
					return 'respuesta_NObusc'; //No consigue BUSCAR
				}
				else
				{ 
					return $resultado;  //Devuleve los datos a BUSCAR //Consigue BUSCAR
				}	
			}


				function verN_Video_Buscar()//ShowAll desde Busqueda (F)
				{
						$sql = "SELECT COUNT(id) AS N
								FROM videos
                                WHERE 	
									autor LIKE '%".$this->autor."%' AND
									nombre LIKE '%".$this->nombre."%' AND
									texto LIKE '%".$this->texto."%' AND
									ubicacion LIKE '%".$this->ubicacion."%' AND
									fecha_subida LIKE '%".$this->fecha_subida."%'
							";
					$resultado = $this->mysqli->query($sql);
					if (!$this->mysqli->query($sql))
					{ 
						return 'respuesta_NObusc'; //No consigue BUSCAR
					}
					else
					{ 
						return $resultado;  //Devuleve los datos a BUSCAR //Consigue BUSCAR
					}	
				}




















//--------------------------------------------------------------------------------------------------------------------
//Metodos LIKE------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//autor->id_usuario    //id->id_video
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo COMPROBAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function Comprobar_SiDiLike()
		{
			$sql = "SELECT id FROM `videos_likes` WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video='".$this->id."'"; 
			$resultado = $this->mysqli->query($sql);
			if ($resultado->num_rows > 0)
			{
				return true;
			}
			else
			{
				return 'respuesta_NoLeDisteLike';
			}
		}
		function Comprobar_SiNoDiLike()
		{
			$sql = "SELECT id FROM `videos_likes` WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video='".$this->id."'"; 
			$resultado = $this->mysqli->query($sql);
			if ($resultado->num_rows <= 0)
			{
				return true;
			}
			else
			{
				return 'respuesta_YaLeDisteLike';
			}
		}
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo ACTUALIZAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function Like_Actualizar()//Actualizar_NLikes[VIDEO]
		{
			//Contar nº de Likes tiene X video
			$sql = "UPDATE `videos` SET 
			`n_likes`=(SELECT COUNT(id_usuario) FROM `videos_likes` WHERE id='".$this->id."')
			WHERE
			`id`='".$this->id."'
			";
			if (!$this->mysqli->query($sql)) //Comprobar reacción
			{
				return 'respuesta_NOedit'; //No consigue ACTUALIZAR
			}
			else
			{
				return true; //Consigue ACTUALIZAR
			}
		}
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo AÑADIR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function DarLike_Actualizar()
		{
			$sql = "SELECT id FROM `videos_likes` WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video='".$this->id."'"; 
			$resultado = $this->mysqli->query($sql);
			if ($resultado->num_rows <= 0)
			{
					$sql = "INSERT INTO videos_likes
					(
						id_usuario,
						id_video
					) 
					VALUES 
					(
						(SELECT id FROM usuarios WHERE login='".$this->autor."'),
						'".$this->id."'
					)";
					if (!$this->mysqli->query($sql)) //Comprobar reacción
					{
						return 'respuesta_NOadd';//Enviamos esta sentencia para que lo interprete el Switch y así comunicatselo al MESSAGE
					}
					else
					{
						$sql = "UPDATE `videos` SET 
						`n_likes`=(SELECT COUNT(id_usuario) FROM `videos_likes` WHERE id_video='".$this->id."')
						WHERE
						`id`='".$this->id."'
						";
						if (!$this->mysqli->query($sql)) //Comprobar reacción
						{
							return 'respuesta_NOedit'; //No consigue ACTUALIZAR
						}
						else
						{
							return true; //Consigue ACTUALIZAR
						}
					}
			}
			else
			{
				return 'respuesta_YaLeDisteLike';
			}
		}
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo BORRAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function QuitarLike_Actualizar()
		{
			$sql = "SELECT id FROM `videos_likes` WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video='".$this->id."'"; 
			$resultado = $this->mysqli->query($sql);
			if ($resultado->num_rows > 0)
			{
					$sql = "DELETE FROM `videos_likes` WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video='".$this->id."'";//BORRAR los datos en la BD
					if (!$this->mysqli->query($sql)) 
					{
						return 'respuesta_NOdel'; //No consigue BORRAR
					}
					else
					{
						$sql = "UPDATE `videos` SET
						`n_likes`=(SELECT COUNT(id_usuario) FROM `videos_likes` WHERE id_video='".$this->id."')
						WHERE
						`id`='".$this->id."'
						";
						if (!$this->mysqli->query($sql)) //Comprobar reacción
						{
							return 'respuesta_NOedit'; //No consigue ACTUALIZAR
						}
						else
						{
							return true; //Consigue ACTUALIZAR
						}
					}
			}
			else
			{
				return 'respuesta_NoLeDisteLike';
			}
		}



//--------------------------------------------------------------------------------------------------------------------
//Metodos FAVORITOS---------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//autor->id_usuario    //id->id_video
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo COMPROBAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function Comprobar_AñadiAFavoritos()
		{
			$sql = "SELECT id FROM `videos_favoritos` WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video='".$this->id."'"; 
			$resultado = $this->mysqli->query($sql);
			if ($resultado->num_rows > 0)
			{
				return true;
			}
			else
			{
				return 'respuesta_NoLeDisteLike';
			}
		}
		function Comprobar_LoQuiteDeFavoritos()
		{
			$sql = "SELECT id FROM `videos_favoritos` WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video='".$this->id."'"; 
			$resultado = $this->mysqli->query($sql);
			if ($resultado->num_rows <= 0)
			{
				return true;
			}
			else
			{
				return 'respuesta_YaLeDisteLike';
			}
		}
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo ACTUALIZAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function Favoritos_Actualizar()//Actualizar_NLikes[VIDEO]
		{
			//Contar nº de Likes tiene X video
			$sql = "UPDATE `videos` SET 
			`n_likes`=(SELECT COUNT(id_usuario) FROM `videos_favoritos` WHERE id='".$this->id."')
			WHERE
			`id`='".$this->id."'
			";
			if (!$this->mysqli->query($sql)) //Comprobar reacción
			{
				return 'respuesta_NOedit'; //No consigue ACTUALIZAR
			}
			else
			{
				return true; //Consigue ACTUALIZAR
			}
		}
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo AÑADIR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function AnadirAFavoritos_Actualizar()
		{
			$sql = "SELECT id FROM `videos_favoritos` WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video='".$this->id."'"; 
			$resultado = $this->mysqli->query($sql);
			if ($resultado->num_rows <= 0)
			{
					$sql = "INSERT INTO videos_favoritos
					(
						id_usuario,
						id_video
					) 
					VALUES 
					(
						(SELECT id FROM usuarios WHERE login='".$this->autor."'),
						'".$this->id."'
					)";
					if (!$this->mysqli->query($sql)) //Comprobar reacción
					{
						return 'respuesta_NOadd';//Enviamos esta sentencia para que lo interprete el Switch y así comunicatselo al MESSAGE
					}
					else
					{
						return true; //Consigue ACTUALIZAR
					}
			}
			else
			{
				return 'respuesta_YaEstaEnFavoritos';
			}
		}
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo BORRAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function QuitarFavoritos_Actualizar()
		{
			$sql = "SELECT id FROM `videos_favoritos` WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video='".$this->id."'"; 
			$resultado = $this->mysqli->query($sql);
			if ($resultado->num_rows > 0)
			{
					$sql = "DELETE FROM `videos_favoritos` WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video='".$this->id."'";//BORRAR los datos en la BD
					if (!$this->mysqli->query($sql)) 
					{
						return 'respuesta_NOdel'; //No consigue BORRAR
					}
					else
					{
						$sql = "UPDATE `videos` SET
						`n_likes`=(SELECT COUNT(id_usuario) FROM `videos_favoritos` WHERE id_video='".$this->id."')
						WHERE
						`id`='".$this->id."'
						";
						if (!$this->mysqli->query($sql)) //Comprobar reacción
						{
							return 'respuesta_NOedit'; //No consigue ACTUALIZAR
						}
						else
						{
							return true; //Consigue ACTUALIZAR
						}
					}
			}
			else
			{
				return 'respuesta_NoEstaEnFavoritos';
			}
		}














//--------------------------------------------------------------------------------------------------------------------
//Metodos HASHTAGS---------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//hashtags
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo COMPROBAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function Comprobar_AñadiHashtag()
		{
		}
		function Comprobar_QuitarHashtag()
		{
		}
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo ACTUALIZAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function Hashtag_VideoVisible()//Actualizar_NLikes[VIDEO]
		{
			$sql= "UPDATE `hashtags` SET `n_veces` = `n_veces`+1 WHERE `id`=(SELECT `id_hashtag` FROM `videos_hashtags` WHERE `id_video`='".$this->id."')";
			$resultado = $this->mysqli->query($sql);
	
		}
		
		
		
		function Hashtag_VideoBorrarOcultar()//Actualizar_NLikes[VIDEO]
		{
			$sql= "UPDATE `hashtags` SET `n_veces` = `n_veces`-1 WHERE `id`=(SELECT `id_hashtag` FROM `videos_hashtags` WHERE `id_video`='".$this->id."')";
			$resultado = $this->mysqli->query($sql);
	
		}
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo AÑADIR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function AnadirHashtag_Actualizar()
		{
			$sql= "SELECT `id` FROM `hashtags` WHERE `nombre`='".$this->nombre."'";
			$resultado = $this->mysqli->query($sql);
			
			if ($resultado->num_rows == 0)//Si no se listo nunca, lo crea 0 veces listado
			{	
				$sql = "INSERT INTO `hashtags`( `nombre`, `fecha`, `n_veces`) VALUES ('".$this->nombre."', '".$this->fecha_subida."', 1)";
				$resultado = $this->mysqli->query($sql);
				
				$sql="INSERT INTO `videos_hashtags` (`id_video`, `id_hashtag`) VALUES ((SELECT MAX(`id`) FROM `videos`), (SELECT MAX(`id`) FROM `hashtags`))";
				$resultado = $this->mysqli->query($sql);
			}
			else
			{
			
				if ($resultado->num_rows > 0)//Si se listo anteriormente, simplemente suma 1 a las veces listado
				{
					
						$sql= "UPDATE `hashtags` SET `n_veces` = `n_veces`+1 WHERE `nombre`='".$this->nombre."'";
						$resultado = $this->mysqli->query($sql);
						
						$sql= "INSERT INTO `videos_hashtags` (`id_video`, `id_hashtag`) VALUES ((SELECT MAX(`id`) FROM `videos`), (SELECT `id` FROM `hashtags` WHERE `nombre`='".$this->nombre."'))";
						$resultado = $this->mysqli->query($sql);
				}
			}
			
		}
		
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo BORRAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function QuitarHashtag_Actualizar()
		{	
			
	
		}




//--------------------------------------------------------------------------------------------------------------------
//Metodos VISIBLILIDAD_VIDEO--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//Visible
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo HACER VISIBLE
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function HacerVisible_Video_Actualizar()
		{
			//Comprobar si YA es visible
			//Editar Video visible='es_visible'
			$sql = "SELECT id FROM `videos` WHERE id='".$this->id."' AND visible='no_visible'"; //Si está oculto
			$resultado = $this->mysqli->query($sql);
			if ($resultado->num_rows > 0)
			{
					$sql = "UPDATE `videos` SET
								`visible`='es_visible'
							WHERE
								`id`='".$this->id."'
					";
					if (!$this->mysqli->query($sql)) //Comprobar reacción
					{
						return 'respuesta_NOedit';//Enviamos esta sentencia para que lo interprete el Switch y así comunicatselo al MESSAGE
					}
					else
					{
						return true; //Consigue ACTUALIZAR
					}
			}
			else
			{
				return 'respuesta_YaEstaVisible';
			}
		}
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo OCULTAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function Ocultar_Video_Actualizar()
		{
			//Comprobar si NO es visible
			//Editar Video visible='no_visible'
			$sql = "SELECT id FROM `videos` WHERE id='".$this->id."' AND visible='es_visible'"; //Si no está oculto
			$resultado = $this->mysqli->query($sql);
			if ($resultado->num_rows > 0)
			{
					$sql = "UPDATE `videos` SET
								`visible`='no_visible'
							WHERE
								`id`='".$this->id."'
					";
					if (!$this->mysqli->query($sql)) //Comprobar reacción
					{
						return 'respuesta_NOedit';//Enviamos esta sentencia para que lo interprete el Switch y así comunicatselo al MESSAGE
					}
					else
					{
						return true; //Consigue ACTUALIZAR
					}
			}
			else
			{
				return 'respuesta_NoEstaOculto';
			}
		}


































//--------------------------------------------------------------------------------------------------------------------
//Metodos VER(SEGUIDORES_LIKE_FAVORITOS)-----------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------

		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo SEGUIR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		
				//----------------------ShowAll_SEGUIDORES
					function ShowAll_SEGUIDORES()
					{
						$sql = "SELECT *
									FROM
									(SELECT (@numero:=@numero+1),
										UU.id,
										UU.login,
										UU.alias,
										UU.foto_perfil,
										UU.rol,
										UU.email,
										UU.nacimiento,
										UU.n_seguidores,
										(SELECT COUNT(id) FROM seguidores WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND login=UU.id)
										
										FROM usuarios UU
										
										WHERE UU.id>0
									ORDER BY UU.n_seguidores DESC, UU.alias,UU.login) i
								";
						$resultado = $this->mysqli->query($sql);
						if (!$this->mysqli->query($sql))
						{ 
							return 'respuesta_NOall'; //No consigue MOSTRAR
						}
						else
						{ 
							$result = $resultado;  //Consigue MOSTRAR
							return $result;  //Devuleve los datos a MOSTRAR
						}
					}

					
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo LIKE
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
			function ShowAll_Like()
			{
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
								VV.id_video,		
								(SELECT login FROM usuarios WHERE id=(SELECT autor FROM videos WHERE id=VV.id_video)),
								(SELECT alias FROM usuarios WHERE id=(SELECT autor FROM videos WHERE id=VV.id_video)),
								(SELECT foto_perfil FROM usuarios WHERE id=(SELECT autor FROM videos WHERE id=VV.id_video)),
								
								(SELECT nombre FROM videos WHERE id=VV.id_video),
								(SELECT texto FROM videos WHERE id=VV.id_video),
								(SELECT ubicacion FROM videos WHERE id=VV.id_video),
								(SELECT fecha_subida FROM videos WHERE id=VV.id_video),
								(SELECT n_likes FROM videos WHERE id=VV.id_video),
								(SELECT autor FROM videos WHERE id=VV.id_video),
								
								/*1 si el usuario logueado lo sigue - 0 si no lo hace*/
								(SELECT COUNT(id) FROM seguidores WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->autor."') 
								AND login=(SELECT autor FROM videos WHERE id=VV.id_video)),
								
								/*1 si el usuario logueado le dio like - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_likes WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') 
								AND id_video=(SELECT id FROM videos WHERE id=VV.id_video)),
								
								/*1 si el usuario logueado lo metio en favoritos - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_favoritos WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') 
								AND id_video=(SELECT id FROM videos WHERE id=VV.id_video)),
								
								/*1 si el video es visible - 0 si no lo es*/
								(SELECT COUNT(id) FROM videos WHERE visible='es_visible' AND id=VV.id_video)

								
								FROM videos_likes VV
								WHERE VV.id>0	AND VV.id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND (SELECT COUNT(id) FROM videos WHERE visible='es_visible' AND id=VV.id_video)=1
							ORDER BY (SELECT fecha_subida FROM videos WHERE id=VV.id_video) DESC,(SELECT alias FROM usuarios WHERE id=VV.id_usuario),(SELECT login FROM usuarios WHERE id=VV.id_usuario)) i
						";
				$resultado = $this->mysqli->query($sql);
				if (!$this->mysqli->query($sql))
				{ 
					return 'respuesta_NOall'; //No consigue MOSTRAR
				}
				else
				{ 
					$result = $resultado;  //Consigue MOSTRAR
					return $result;  //Devuleve los datos a MOSTRAR
				}
			}

		
		
		
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo FAVORITOS
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
			function ShowAll_Favoritos()
			{
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
								VV.id_video,		
								(SELECT login FROM usuarios WHERE id=(SELECT autor FROM videos WHERE id=VV.id_video)),
								(SELECT alias FROM usuarios WHERE id=(SELECT autor FROM videos WHERE id=VV.id_video)),
								(SELECT foto_perfil FROM usuarios WHERE id=(SELECT autor FROM videos WHERE id=VV.id_video)),
								
								(SELECT nombre FROM videos WHERE id=VV.id_video),
								(SELECT texto FROM videos WHERE id=VV.id_video),
								(SELECT ubicacion FROM videos WHERE id=VV.id_video),
								(SELECT fecha_subida FROM videos WHERE id=VV.id_video),
								(SELECT n_likes FROM videos WHERE id=VV.id_video),
								(SELECT autor FROM videos WHERE id=VV.id_video),
								
								/*1 si el usuario logueado lo sigue - 0 si no lo hace*/
								(SELECT COUNT(id) FROM seguidores WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->autor."')
								AND login=(SELECT autor FROM videos WHERE id=VV.id_video)),
								
								/*1 si el usuario logueado le dio like - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_likes WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."')
								AND id_video=(SELECT id FROM videos WHERE id=VV.id_video)),
								
								/*1 si el usuario logueado lo metio en favoritos - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_favoritos WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."')
								AND id_video=(SELECT id FROM videos WHERE id=VV.id_video)),
								
								/*1 si el video es visible - 0 si no lo es*/
								(SELECT COUNT(id) FROM videos WHERE visible='es_visible' AND id=VV.id_video)
								
								FROM videos_favoritos VV
								WHERE VV.id>0	AND VV.id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND (SELECT COUNT(id) FROM videos WHERE visible='es_visible' AND id=VV.id_video)=1
							ORDER BY (SELECT fecha_subida FROM videos WHERE id=VV.id_video) DESC,(SELECT alias FROM usuarios WHERE id=VV.id_usuario),(SELECT login FROM usuarios WHERE id=VV.id_usuario)) i
						";
				$resultado = $this->mysqli->query($sql);
				if (!$this->mysqli->query($sql))
				{ 
					return 'respuesta_NOall'; //No consigue MOSTRAR
				}
				else
				{ 
					$result = $resultado;  //Consigue MOSTRAR
					return $result;  //Devuleve los datos a MOSTRAR
				}
			}

		
		
		
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo HASTAGS
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
			//HASTAG
			function ShowAll_Hashtags()
			{
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
								HH.id,
								HH.nombre,
								(SELECT COUNT(VV.id) FROM videos_hashtags VV WHERE VV.id_hashtag=HH.id AND (SELECT COUNT(id) FROM videos WHERE id=VV.id_video AND visible='es_visible')),
								HH.imagen,
								HH.fecha
								FROM hashtags HH
								WHERE HH.id>0
							ORDER BY (SELECT COUNT(VV.id) FROM videos_hashtags VV WHERE VV.id_hashtag=HH.id AND (SELECT COUNT(id) FROM videos WHERE id=VV.id_video AND visible='es_visible')) DESC, HH.nombre
							) i
						";
				$resultado = $this->mysqli->query($sql);
				if (!$this->mysqli->query($sql))
				{ 
					return 'respuesta_NOall'; //No consigue MOSTRAR
				}
				else
				{ 
					$result = $resultado;  //Consigue MOSTRAR
					return $result;  //Devuleve los datos a MOSTRAR
				}
			}
			//VIDEOS(<-----------------------------------------------------------------------------------------------------------------------)
			function ShowAll_Videos_Hashtag()
			{
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
								VV.id_video,		
								(SELECT login FROM usuarios WHERE id=(SELECT autor FROM videos WHERE id=VV.id_video)),
								(SELECT alias FROM usuarios WHERE id=(SELECT autor FROM videos WHERE id=VV.id_video)),
								(SELECT foto_perfil FROM usuarios WHERE id=(SELECT autor FROM videos WHERE id=VV.id_video)),
								
								(SELECT nombre FROM videos WHERE id=VV.id_video),
								(SELECT texto FROM videos WHERE id=VV.id_video),
								(SELECT ubicacion FROM videos WHERE id=VV.id_video),
								(SELECT fecha_subida FROM videos WHERE id=VV.id_video),
								(SELECT n_likes FROM videos WHERE id=VV.id_video),
								(SELECT autor FROM videos WHERE id=VV.id_video),
								
								/*1 si el usuario logueado lo sigue - 0 si no lo hace*/
								(SELECT COUNT(id) FROM seguidores WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->autor."')
								AND login=(SELECT autor FROM videos WHERE id=VV.id_video)),
								
								/*1 si el usuario logueado le dio like - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_likes WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."')
								AND id_video=(SELECT id FROM videos WHERE id=VV.id_video)),
								
								/*1 si el usuario logueado lo metio en favoritos - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_favoritos WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."')
								AND id_video=(SELECT id FROM videos WHERE id=VV.id_video)),
								
								/*1 si el video es visible - 0 si no lo es*/
								(SELECT COUNT(id) FROM videos WHERE visible='es_visible' AND id=VV.id_video)
								
								FROM videos_hashtags VV
								WHERE VV.id>0	AND VV.id_hashtag='".$this->id."' AND (SELECT COUNT(id) FROM videos WHERE visible='es_visible' AND id=VV.id_video)=1
							ORDER BY (SELECT fecha_subida FROM videos WHERE id=VV.id_video) DESC,(SELECT alias FROM usuarios WHERE id=VV.id_hashtag),(SELECT login FROM usuarios WHERE id=VV.id_hashtag)) i
						";
				$resultado = $this->mysqli->query($sql);
				if (!$this->mysqli->query($sql))
				{ 
					return 'respuesta_NOall'; //No consigue MOSTRAR
				}
				else
				{ 
					$result = $resultado;  //Consigue MOSTRAR
					return $result;  //Devuleve los datos a MOSTRAR
				}
			}
			
			
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo MiPerfil
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
			function ShowAll_MiPerfil()
			{
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
								VV.id,
								(SELECT login FROM usuarios WHERE id=VV.autor),
								(SELECT alias FROM usuarios WHERE id=VV.autor),
								(SELECT foto_perfil FROM usuarios WHERE id=VV.autor),
								VV.nombre,
								VV.texto,
								VV.ubicacion,
								VV.fecha_subida,
								VV.n_likes,
								VV.autor,
								
								/*1 si el usuario logueado lo sigue - 0 si no lo hace*/
								(SELECT COUNT(id) FROM seguidores WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND login=VV.autor),
								
								/*1 si el usuario logueado le dio like - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_likes WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el usuario logueado lo metio en favoritos - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_favoritos WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el video es visible - 0 si no lo es*/
								(SELECT COUNT(id) FROM videos WHERE visible='es_visible' AND id=VV.id)
								
								FROM videos VV
								WHERE VV.id>0 AND VV.autor=(SELECT id FROM usuarios WHERE login='".$this->autor."')
							ORDER BY VV.fecha_subida DESC,VV.autor,VV.texto,VV.ubicacion) i
						";
				$resultado = $this->mysqli->query($sql);
				if (!$this->mysqli->query($sql))
				{ 
					return 'respuesta_NOall'; //No consigue MOSTRAR
				}
				else
				{ 
					$result = $resultado;  //Consigue MOSTRAR
					return $result;  //Devuleve los datos a MOSTRAR
				}
			}
			
			
			function ShowAll_Perfil_Usuario()
			{
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
								VV.id,
								(SELECT login FROM usuarios WHERE id=VV.autor),
								(SELECT alias FROM usuarios WHERE id=VV.autor),
								(SELECT foto_perfil FROM usuarios WHERE id=VV.autor),
								VV.nombre,
								VV.texto,
								VV.ubicacion,
								VV.fecha_subida,
								VV.n_likes,
								VV.autor,
								
								/*1 si el usuario logueado lo sigue - 0 si no lo hace*/
								(SELECT COUNT(id) FROM seguidores WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND login=VV.autor),
								
								/*1 si el usuario logueado le dio like - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_likes WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el usuario logueado lo metio en favoritos - 0 si no lo hizo*/
								(SELECT COUNT(id) FROM videos_favoritos WHERE id_usuario=(SELECT id FROM usuarios WHERE login='".$this->autor."') AND id_video=VV.id),
								
								/*1 si el video es visible - 0 si no lo es*/
								(SELECT COUNT(id) FROM videos WHERE visible='es_visible' AND id=VV.id)
								
								FROM videos VV
								WHERE VV.id>0 AND VV.autor='".$this->id."' AND VV.visible='es_visible'
							ORDER BY VV.fecha_subida DESC,VV.autor,VV.texto,VV.ubicacion) i
						";
				$resultado = $this->mysqli->query($sql);
				if (!$this->mysqli->query($sql))
				{ 
					return 'respuesta_NOall'; //No consigue MOSTRAR
				}
				else
				{ 
					$result = $resultado;  //Consigue MOSTRAR
					return $result;  //Devuleve los datos a MOSTRAR
				}
			}
			
			/**********************************************************************************************NUEVO*****************************************************************************************/
			
			public function findUserVideos() {
		
				$sql = "SELECT * FROM `videos` WHERE `autor` = (SELECT `id` FROM `usuarios` WHERE `login`='".$this->autor."')";
				$resultado = $this->mysqli->query($sql);
				$result = $resultado->fetch_all(MYSQLI_ASSOC);
				
				$videos=array();
				foreach($result as $video){
					array_push($videos,$video);
				}
				
				return $videos;
			}
			
			public function findUserVideoById() {
		
				$sql = "SELECT * FROM `videos` WHERE `id` = '".$this->id."'";
				$resultado = $this->mysqli->query($sql);
				$result = $resultado->fetch_assoc();
				
				return $result;
			}
			
			public function findLoginByAutor() {
					$sql = "SELECT `login` FROM `usuarios` WHERE `id`= (SELECT DISTINCT `autor` FROM `videos` WHERE `autor` = '".$this->autor."')";
					$resultado = $this->mysqli->query($sql);
					$result = $resultado->fetch_assoc();
					
					return $result;
			}
			
			public function findAllHashtags() {
				$sql= "SELECT * FROM `hashtags` ORDER BY `n_veces` DESC";
				$resultado = $this->mysqli->query($sql);
				$result = $resultado->fetch_all(MYSQLI_ASSOC);
				
				$hashtags=array();
				foreach($result as $hashtag){
					array_push($hashtags,$hashtag);
				}
				
				return $hashtags;
			}
			
}