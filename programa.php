<?php
	/*CONEXION CON MYSQLI ORIENTADO A OBJETOS*/
	if(isset($_POST["funcion"])) { // Se pasa una acción
		$funcion = $_POST['funcion'];
		switch($funcion) { // ¿Qué acción?
            case 1:
                grabar_datos();
				break;
			case 2:
				mostrar_datos();
				break;
            default:
                echo "Error: Falta una acción";
        }
	}


	/*abre la conexion con la base de datos*/
	function conexion(){
		include('db_acceso.php');
		//conexion con el servidor mysql y seleccion de la base de datos:
		$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_database);
		$mysqli->set_charset("utf8");

		#compruebo la conexion, en caso de error salgo
		if ($mysqli->connect_errno) {
   			printf("Connect error:".$mysqli->connect_error);
   			exit();
		}
		return $mysqli;
	}
	
	/*metodo para grabar los datos introducidos en la bd*/
	function grabar_datos(){
		$mysqli =conexion();
		$stmt = $mysqli->prepare("insert into libros (nombre,isbn,año,autor) values(?,?,?,?)");  
		//los valores recogidos sol los que paso por ajax       
    	$stmt->bind_param("ssis",$_POST['nombre'],$_POST['isbn'],$_POST['año'],$_POST['autor']);
		//ejecutamos
		if ( $stmt && $stmt->execute() ){
			$msg= "Filas insertadas: ".$stmt->affected_rows;
			// Cerramos la sentencia preparada.
			$stmt -> close();
			echo "$msg";
		} else {
			$msg=$stmt->error;
			echo "$msg";
		}
		echo $msg;
		// Cerramos la conexión.
		$mysqli->close();
	}

	//funcion para extraer y mostrar los datos de la bd
	function mostrar_datos(){
		$mysqli =conexion();
		//consulta mysql para extraer todos los datos
    	$consulta = "SELECT * FROM libros";
		//ejecuto la consulta y muestro el resultado
		if ($resultado = $mysqli->query($consulta)) {
			echo "<h3>listado de libros</h3>";
			echo "<p>Id--->nombre--->isbn--->año--->autor</h4>";
			/* obtener el array de objetos y saco los valoes de la bd */
			while ($fila = $resultado->fetch_assoc()) {
				echo"<p>".$fila["id"]." ; ".$fila["nombre"]." ; ".$fila["isbn"]." ; ".$fila["año"]." ; ".$fila["autor"]."</p>";
			}
			/* liberar el conjunto de resultados */
			$resultado->close();
		}
		/* cerrar la conexión con la bd*/
		$mysqli->close();
	}
	
?>