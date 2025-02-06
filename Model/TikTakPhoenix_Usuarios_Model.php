<?php
class Usuarios_Model
{
	//USUARIO
	var $login;	// declaración del atributo login
	var $contrasena; // declaración del atributo contrasena
	
	var $rol; // declaración del atributo rol
	
	var $alias; // declaración del atributo alias
	
	var $email; // declaración del atributo email
	var $nacimiento; // declaración del atributo nacimiento
	var $foto_perfil; // declaración del atributo foto_perfil
	
	//BD
	var $mysqli; // declaración del atributo manejador de la bd

	


	
	
	
	//------------------------
	//Constructor de la clase
	//------------------------
	function __construct($login,$contrasena,	$rol,	$alias,		$email,$nacimiento,$foto_perfil)
	{
			//asignación de valores de parámetro a los atributos de la clase
		$this->login = $login;
		$this->contrasena = $contrasena;
		
		$this->rol = $rol;
		
		$this->alias = $alias;
		
		$this->email = $email;
		$this->nacimiento = $nacimiento;
		$this->foto_perfil = $foto_perfil;
		
		include_once '../Model/Access_DB.php';// incluimos la funcion de acceso a la bd
		$this->mysqli = ConnectDB();// conectamos con la bd y guardamos el manejador en un atributo de la clase
	}
	
	public function getLogin() {
		return $this->login;
	}

	/**
	* Sets the username of this user
	*
	* @param string $username The username of this user
	* @return void
	*/
	public function setLogin($login) {
		$this->login = $login;
	}

	/**
	* Gets the password of this user
	*
	* @return string The password of this user
	*/
	public function getContrasena() {
		return $this->contrasena;
	}
	/**
	* Sets the password of this user
	*
	* @param string $passwd The password of this user
	* @return void
	*/
	public function setContrasena($contrasena) {
		$this->contrasena = $contrasena;
	}
	
	public function getRol() {
		return $this->rol;
	}

	/**
	* Sets the username of this user
	*
	* @param string $username The username of this user
	* @return void
	*/
	public function setRol($rol) {
		$this->rol = $rol;
	}
	
	public function getAlias() {
		return $this->alias;
	}

	/**
	* Sets the username of this user
	*
	* @param string $username The username of this user
	* @return void
	*/
	public function setAlias($alias) {
		$this->alias = $alias;
	}
	
	public function getEmail() {
		return $this->email;
	}

	/**
	* Sets the username of this user
	*
	* @param string $username The username of this user
	* @return void
	*/
	public function setEmail($email) {
		$this->email = $email;
	}
	
	
	public function getNacimiento() {
		return $this->nacimiento;
	}

	/**
	* Sets the username of this user
	*
	* @param string $username The username of this user
	* @return void
	*/
	public function setNacimiento($nacimiento) {
		$this->nacimiento = $nacimiento;
	}
	
	public function getFotoPerfil() {
		return $this->foto_perfil;
	}

	/**
	* Sets the username of this user
	*
	* @param string $username The username of this user
	* @return void
	*/
	public function setFotoPerfil($foto_perfil) {
		$this->foto_perfil = $foto_perfil;
	}
	
	


	
	
	
	
	
//--------------------------------------------------------------------------------------------------------------------
//Metodo CONECTAR-----------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------




		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo LOGIN
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
				//Funcion enfocada a comprobar los datos e autentificación en la BD
			function login()
			{ 
				$sql = "SELECT * FROM usuarios WHERE login = '".$this->login."'";//Consulta por login en la base de datos Usuarios
				$resultado = $this->mysqli->query($sql);
				if ($resultado->num_rows == 0)//Si no hay coincidencias compara si la contraseña  es correcta y si la hay sale 
				{
					return 'respuesta_CombinacionInvalida';//No me interesa mostrarle al usuario que logins tengo o dejo de tener//No lo envío al usuario. Ya que no lo reenvio como en REGISTRO a MESSAGE
				}
				else
				{
					$tupla = $resultado->fetch_array();
					if ($tupla['contrasena'] == $this->contrasena)//Si la comprobación es correcta envía un TRUE con el que daremos el OK al LOGIN
					{
						return true;
					}
					else
					{	
						return 'respuesta_CombinacionInvalida';//No me interesa mostrarlo, así que no lo voy a meter en mensajes como en el resgitro//Queda anotado con ese return pero no reutilizo esta sentencia.
					}
				}
			}






//--------------------------------------------------------------------------------------------------------------------
//Metodos USUARIO-------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------



		
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo AÑADIR/REGISTRAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
			//Funcion enfocada a COMPROBAR los datos que pretendes insertar en la BD
			function ComprobarADD()
			{
				//1//
				//------------------------------------------//
				//-----------//EMAIL//----------------------//
				//------------------------------------------//
					
					$checkEmail = "SELECT COUNT(*) FROM `usuarios` WHERE `email` = '".$this->email."'";//Variable para guardar la coonsulta  y comprobar si el EMAIL existe
					$resultEmail = $this->mysqli->query($checkEmail);
					if ($resultEmail >= 1) // Si count >= 1 significa que el correo electrónico ya está en la base de datos.
					{
							//------------------------------------------//
							//-----------//USUARIO//----------------------//
							//------------------------------------------//
								$checkLogin = "SELECT COUNT(*) FROM `usuarios` WHERE `login` = '".$this->login."'";//Variable para guardar la consulta  y comprobar si el Login del USUARIO existe
								$resultLogin = $this->mysqli->query($checkLogin);
								if ($resultLogin >= 1) // Si count >= 1 significa que el nombre ya está en la base de datos.
								{
									return 'respuesta_Reg_EmailRegLogin';
								}
								else 
								{
									return 'respuesta_Reg_Email';
								}
					}			
					else 
					{
							//2//
							//------------------------------------------//
							//-----------//USUARIO//----------------------//
							//------------------------------------------//
								$checkLogin = "SELECT COUNT(*) FROM `usuarios` WHERE `login` = '".$this->login."'";//Variable para guardar la coonsulta  y comprobar si el Login del USUARIO existe
								$resultLogin = $this->mysqli->query($checkLogin);
								if ($resultLogin >= 1) // Si count >= 1 significa que el nombre ya está en la base de datos.
								{
									return 'respuesta_Reg_Login';
								}
								else 
								{
									return true; 
								}			
					}	
	
			}

			
			
			
				//Función enfocada a ESCRIBIR los datos en la BD
			function registrar()//Insertar los datos en la BD
			{
					$sql = "INSERT INTO USUARIOS 
								(
									login,
									contrasena,
							
									rol,
							
									alias,
									
									email,
									nacimiento
								) 
							VALUES 
								(
									'".$this->login."',
									'".$this->contrasena."',
									
									'".$this->rol."',
									
									'".$this->alias."',
									
									'".$this->email."',
									'".$this->nacimiento."'
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
				//1//
				//------------------------------------------//
				//-----------//EMAIL//----------------------//
				//------------------------------------------//
					$checkEmail = "SELECT email FROM usuarios WHERE email = '".$this->email."'";//Variable para guardar la coonsulta  y comprobar si el EMAIL existe
					$resultEmail = $this->mysqli->query($checkEmail);
					$countEmail = mysqli_num_rows($resultEmail);
					//Comprobamos que el EMAIL elegido sólo pueda estar duplicado si es nuestro EMAIL antiguo
					$checkEmailLogin = "SELECT email FROM usuarios WHERE login = '".$this->login."'";
					$resultEmailLogin = $this->mysqli->query($checkEmailLogin);
					$tuplaEmail = $resultEmailLogin->fetch_array();
					if ($countEmail < 1 ||$tuplaEmail['email'] == $this->email) //O no está o es el que estamos actualizando
					{

						return true;
					}			
					else 
					{
						return 'respuesta_Reg_Email';

					}	
			}

			
			
			//<---EDITAR NORMAL---->
			//Función enfocada a ACTUALIZAR los datos en la BD
			function editar()//ACTUALIZAR los datos en la BD
			{
					$sql = "UPDATE `usuarios` SET 
								`contrasena`='".$this->contrasena."',
								
								`rol`='".$this->rol."',
								
								`alias`='".$this->alias."',
								
								`email`='".$this->email."',
								`nacimiento`='".$this->nacimiento."',
								`foto_perfil`='".$this->foto_perfil."',
								`n_seguidores`=(SELECT COUNT(login_seguidor) FROM seguidores WHERE login=(SELECT id FROM usuarios WHERE login = '".$this->login."'))
								WHERE
								`login`='".$this->login."'";
					if (!$this->mysqli->query($sql)) //Comprobar reacción
					{
						return 'respuesta_NOedit'; //No consigue ACTUALIZAR
					}
					
					else
					{
						return true; //Consigue ACTUALIZAR
					}
			}








			//<---EDITAR SIN FOTO---->
				//Función enfocada a ACTUALIZAR los datos en la BD
			function editar_SinFoto()//ACTUALIZAR los datos en la BD
			{
					$sql = "UPDATE `usuarios` SET 
								`contrasena`='".$this->contrasena."',
								
								`rol`='".$this->rol."',
								
								`alias`='".$this->alias."',
								
								`email`='".$this->email."',
								`nacimiento`='".$this->nacimiento."',
								`n_seguidores`=(SELECT COUNT(login_seguidor) FROM seguidores WHERE login=(SELECT id FROM usuarios WHERE login = '".$this->login."'))
								WHERE
								`login`='".$this->login."'";
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
					//Nos aseguramos que el usuario EXISTE
					$checkUsuario = "SELECT * FROM `usuarios` WHERE `login`= '".$this->login."'";
					$resultUsuario = $this->mysqli->query($checkUsuario);
					$countUsuario = mysqli_num_rows($resultUsuario);
					if ($countUsuario == 1)
					{
							//Borramos el USUARIO
							$sql = "DELETE FROM `usuarios` WHERE `login` =  '".$this->login."'";//BORRAR los datos en la BD en base al LOGIN
							if (!$this->mysqli->query($sql)) 
							{
								return 'respuesta_NOdel'; //No consigue BORRAR
							}
							else
							{
								return true; //Consigue BORRAR
							}
					}
					else
					{
						return 'respuesta_NOdel'; //No consigue BORRAR ya que no encuentra el USUARIO
					}
			}
		
		

		
		
		
		
		
		
		
		
		
//--------------------------------------------------------------------------------------------------------------------
//Metodo MOSTRAR DATOS------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
		//---------------
		//NUMERO DE FILAS
		//---------------
				function verN_Usuario()//Vista_showALL
				{
						$sql = "SELECT COUNT(login) AS N
							FROM usuarios
							WHERE id>0
							ORDER BY login";
						$resultado = $this->mysqli->query($sql);
						$tupla = $resultado->fetch_array();
						return $tupla;
				}
				
				
				
				
				
		//------------
		//VER un VALOR
		//------------
		
							//----------------------VER_USUARIOS
					//Función enfocada a VER el NOMBRE de la USUARIOS con respecto a la TABLA
					function VER_USUARIOS()
					{
							//------------------------------------------//
							//-----------//USUARIOS//----------------------//
							//------------------------------------------//
								//MOSTRAR todos los datos de la tabla USUARIOS
								$sql = "SELECT id,login,alias,rol
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

			//----------------------VER_EMAIL
				//Función enfocada a VER el EMAIL del USUARIO con respecto a la TABLA
			function verEMAIL()
			{
						//------------------------------------------//
						//-----------//EMAIL//----------------------//
						//------------------------------------------//
						$sql = "SELECT email FROM usuarios WHERE login = '".$this->login."'";
						$resultado = $this->mysqli->query($sql);
						$tupla = $resultado->fetch_array();
						return $tupla['email'];

								
			}
			
			
			//----------------------VER_LOGIN
				//Función enfocada a VER el LOGIN del USUARIO con respecto a la TABLA
			function verLOGIN()
			{
						//------------------------------------------//
						//-----------//LOGIN//----------------------//
						//------------------------------------------//
						$sql = "SELECT login FROM usuarios WHERE email= '".$this->email."'";
						$resultado = $this->mysqli->query($sql);
						$tupla = $resultado->fetch_array();
						return $tupla['login'];
			}
			
			
			//----------------------VER_ROL
				//Función enfocada a VER el ROL del USUARIO con respecto a la TABLA
			function verROL()
			{
						//------------------------------------------//
						//-----------//ROL//----------------------//
						//------------------------------------------//
						$sql = "SELECT rol FROM `usuarios` WHERE login= '".$this->login."'";
						$resultado = $this->mysqli->query($sql);
						$tupla = $resultado->fetch_array();
						return $tupla['rol'];
			}
			
			
			//----------------------VER_ALIAS
				//Función enfocada a VER el ROL del USUARIO con respecto a la TABLA
			function verALIAS()
			{
						//------------------------------------------//
						//-----------//ALIAS//----------------------//
						//------------------------------------------//
						$sql = "SELECT alias FROM `usuarios` WHERE login= '".$this->login."'";
						$resultado = $this->mysqli->query($sql);
						$tupla = $resultado->fetch_array();
						return $tupla['alias'];
			}
			
			//----------------------verFOTOPERFIL
				//Función enfocada a VER el ROL del USUARIO con respecto a la TABLA
			function verFOTOPERFIL()
			{
						//------------------------------------------//
						//-----------//FOTOPERFIL//----------------------//
						//------------------------------------------//
						$sql = "SELECT foto_perfil FROM `usuarios` WHERE login= '".$this->login."'";
						$resultado = $this->mysqli->query($sql);
						$tupla = $resultado->fetch_array();
						return $tupla['foto_perfil'];
			}


			//----------------------COMPROBAR_LOGIN
				//Función enfocada a COMPROBAR el Login del USUARIO con respecto a la TABLA
			function ComprobarLogin()
			{
				$checkLogin = "SELECT * FROM usuarios WHERE login = '".$this->login."'";//Variable para guardar la consulta  y comprobar si el Login del USUARIO existe
				$resultLogin = $this->mysqli->query($checkLogin);
				$countLogin = mysqli_num_rows($resultLogin);
				if ($countLogin == 1) // Si count == 1 significa que el nombre ya está en la base de datos.
				{
					return true;
				}
				else
				{
					return 'respuesta_NOlogin';
				}
			}
			

			
			
			
			
			
			

			
			
			

			
		
		
		
		
		
		
		
		
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo MOSTRAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		
		
			//----------------------SHOW_ALL
				//Función enfocada a MOSTRAR todos los datos de la BD
			function ShowAll()
			{
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
								login,
								contrasena,

								rol,

								alias,

								email,
								nacimiento,
								foto_perfil,
								(SELECT COUNT(login_seguidor) FROM seguidores WHERE login=id)
								
								
								FROM usuarios
								WHERE id>0
							 ORDER BY FIELD (rol, 'administrador', 'usuario_normal') ASC, login, alias) i
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
				//MOSTRAR datos de un USUARIO
			function ShowAll_CE_usuario()
			{
				$sql ="SET @numero=0;";
				$this->mysqli->query($sql);
				$sql = "SELECT *
							FROM
							(SELECT (@numero:=@numero+1),
								login,
								contrasena,

								rol,

								alias,

								email,
								nacimiento,
								foto_perfil,
								(SELECT COUNT(login_seguidor) FROM seguidores WHERE login=id)

								FROM usuarios
                                WHERE login ='".$this->login."'
							 ORDER BY FIELD (rol, 'administrador', 'usuario_normal') ASC, login, alias) i
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
								id,
								login,
								alias,
								rol,
								email,
								nacimiento,
								foto_perfil,
								n_seguidores,
								contrasena
								
								FROM usuarios
                                WHERE 
								login = '".$this->login."'";
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
									login,
									contrasena,

									rol,

									alias,

									email,
									nacimiento,
									foto_perfil,
									(SELECT COUNT(login_seguidor) FROM seguidores WHERE login=id)

								FROM usuarios
                                WHERE 	
									login LIKE '%".$this->login."%' AND
									contrasena LIKE '%".$this->contrasena."%' AND

									rol LIKE '%".$this->rol."%' AND

									alias LIKE '%".$this->alias."%' AND

									email LIKE '%".$this->email."%' AND
									nacimiento LIKE '%".$this->nacimiento."%'
							 ORDER BY FIELD (rol, 'administrador', 'usuario_normal') ASC, login, alias) i
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


				function verN_Usuario_Buscar()//ShowAll desde Busqueda (F)
				{
						$sql = "SELECT COUNT(login) AS N
								FROM usuarios
                                WHERE 	
									login LIKE '%".$this->login."%' AND
									contrasena LIKE '%".$this->contrasena."%' AND

									rol LIKE '%".$this->rol."%' AND

									alias LIKE '%".$this->alias."%' AND
									
									email LIKE '%".$this->email."%' AND
									nacimiento LIKE '%".$this->nacimiento."%'
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
//Metodos SEGUIR------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//login->id_login    //alias->id_login_seguidor
	
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo AÑADIR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function EmpezarASeguir_Actualizar()//Añadir un nuevo vinculo login con login_seguidor
		{
			//LOGIN + LOGIN_SEGUIDOR
			//SELECT id FROM `seguidores` WHERE login='Vas A Seguir' AND login_seguidor=' Tu '
			$sql = "SELECT id FROM `seguidores` WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->login."') AND login='".$this->alias."'"; 
			$resultado = $this->mysqli->query($sql);
			if ($resultado->num_rows <= 0)
			{
					$sql = "INSERT INTO seguidores
					(
						login,
						login_seguidor
					) 
					VALUES 
					(
						'".$this->alias."',
						(SELECT id FROM usuarios WHERE login='".$this->login."')
					)";
					if (!$this->mysqli->query($sql)) //Comprobar reacción
					{
						return 'respuesta_NOadd';//Enviamos esta sentencia para que lo interprete el Switch y así comunicatselo al MESSAGE
					}
					else
					{
							//Contar nº de seguidores tiene X cuenta
							$sql = "UPDATE `usuarios` SET 
							`n_seguidores`=(SELECT COUNT(login_seguidor) FROM `seguidores` WHERE login='".$this->alias."')
							WHERE
							`id`='".$this->alias."'
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
				return 'respuesta_YaSiguesAEstaCuenta';
			}
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		//----------------------------------------------------------------------------------------------------------------------
		//------------------------
		//Metodo BORRAR
		//------------------------
		//----------------------------------------------------------------------------------------------------------------------
		function DejarDeSeguir_Actualizar()	//Quitar vinculo login con login_seguidor
		{
			//LOGIN + LOGIN_SEGUIDOR
			//SELECT id FROM `seguidores` WHERE login='2' AND login_seguidor='5'
			$sql = "SELECT id FROM `seguidores` WHERE login_seguidor=(SELECT id FROM usuarios WHERE login='".$this->login."') AND login='".$this->alias."'"; 
			$resultado = $this->mysqli->query($sql);
			if ($resultado->num_rows > 0)
			{
					$sql = "DELETE FROM `seguidores` WHERE `login_seguidor` =  (SELECT id FROM usuarios WHERE login='".$this->login."') AND `login` =  '".$this->alias."'";//BORRAR los datos en la BD
					if (!$this->mysqli->query($sql)) 
					{
						return 'respuesta_NOdel'; //No consigue BORRAR
					}
					else
					{
							//Contar nº de seguidores tiene X cuenta
							$sql = "UPDATE `usuarios` SET 
							`n_seguidores`=(SELECT COUNT(login_seguidor) FROM `seguidores` WHERE login='".$this->alias."')
							WHERE
							`id`='".$this->alias."'
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
				return 'respuesta_NoSiguesAEstaCuenta';
			}
		}
		
		public function validarUsuario() {
		$sql = "SELECT `login` FROM `usuarios` WHERE `login`='".$this->login."' AND `contrasena`='".$this->contrasena."'";
		$resultado = $this->mysqli->query($sql);

		if ($resultado->num_rows > 0) {
			return true;
		}
	}
	
	
	/***************************************************************NUEVO*******************************************************************/
	
	public function buscarUsuariosDB() {
				$sql= "SELECT `login`, `rol`, `alias`, `email`, `nacimiento`, `foto_perfil`, `n_seguidores` FROM `usuarios` ORDER BY `n_seguidores` DESC";
				$resultado = $this->mysqli->query($sql);
				$result = $resultado->fetch_all(MYSQLI_ASSOC);
				
				$users=array();
				foreach($result as $user){
					array_push($users,$user);
				}
				
				return $users;
			}
	
	public function buscarUsuarioPorLogin(){
		$sql = "SELECT `login`, `rol`, `alias`, `email`, `nacimiento`, `foto_perfil` FROM `usuarios` WHERE `login`='".$this->login."'";
		$resultado = $this->mysqli->query($sql);
		$result = $resultado->fetch_assoc();
		
		return $result;
	}
	
	public function buscarUsuarioPorIdVideo(){
		$sql = "SELECT `login`, `rol`, `alias`, `email`, `nacimiento`, `foto_perfil` FROM `usuarios` WHERE `id`= (SELECT `autor` FROM `videos` WHERE `id`='".$this->login."')";
		$resultado = $this->mysqli->query($sql);
		$result = $resultado->fetch_assoc();
		
		return $result;
	}
	
	function editarFoto()//ACTUALIZAR los datos en la BD
			{
					$sql = "UPDATE `usuarios` SET 
								`foto_perfil`='".$this->foto_perfil."',
								`n_seguidores`=(SELECT COUNT(login_seguidor) FROM seguidores WHERE login=(SELECT id FROM usuarios WHERE login = '".$this->login."'))
								WHERE
								`login`='".$this->login."'";
					if (!$this->mysqli->query($sql)) //Comprobar reacción
					{
						return 'respuesta_NOedit'; //No consigue ACTUALIZAR
					}
					
					else
					{
						return true; //Consigue ACTUALIZAR
					}
			}
			
	
	function ComprobarRegistro()
			{
				
					
				$checkEmail = "SELECT * FROM `usuarios` WHERE `email` = '".$this->email."'";//Variable para guardar la coonsulta  y comprobar si el EMAIL existe
				$resultEmail = $this->mysqli->query($checkEmail);
				$countEmail= mysqli_num_rows($resultEmail);
				if ($countEmail >= 1) // Si count >= 1 significa que el correo electrónico ya está en la base de datos.
				{
					return false;
				}			
				else 
				{
						
					$checkLogin = "SELECT * FROM `usuarios` WHERE `login` = '".$this->login."'";//Variable para guardar la coonsulta  y comprobar si el Login del USUARIO existe
					$resultLogin = $this->mysqli->query($checkLogin);
					$countLogin= mysqli_num_rows($resultLogin);
					if ($countLogin >= 1) // Si count >= 1 significa que el nombre ya está en la base de datos.
					{
						return false;
					}
					else 
					{
						return true; 
					}			
				}	
	
			}
			
	
}