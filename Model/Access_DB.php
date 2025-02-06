<?php
//Datos de acceso a la base de datos.
// "localhost";		// IP
// "tiktakphoenix";	// Nombre del usuario de la BD
// "tsw_21";		// Contraseña
// "tiktakphoenix";	// Nombre de la base de datos

//Conectarse a la base de datos
function ConnectDB()
{
    $mysqli = new mysqli('localhost', 'tiktakphoenix', 'tsw_21' , 'tiktakphoenix');
	if ($mysqli->connect_errno) //Si la conexion falla muestra un mensaje de error en la página MESSAGE si está bien pudes usar sesa variable para iteractuar con la BD
	{
		include '../View/Vistas/Base/Mensajes/MESSAGE_View.php';//<------------------EDITAR---------------------------------------------------------------------------------------------------------<<<<
		$mensaje='BD_ERROR';
		$opcion=1;
		$volver='';
		$tipo='';
		new MESSAGE($mensaje,$opcion,$volver,$tipo);
	}
	else
	{
		return $mysqli;
	}
}