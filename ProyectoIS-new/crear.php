<?php
// Verificar si se inició sesión
session_start();
if($_SESSION['tipo'] != 'admin1'){
	header("Location:index.php");
}

$page_title = "Crear anuncio"; 	// Nombre de la pestaña
include 'includes/menu.php'; // incluir en diseño del menú a la página

// Conexión con el servidor
if ($_SERVER['REQUEST_METHOD']=='POST') {

	// Conectar a la base de datos
	require ("../mysqli_connect_is.php");

	// Arreglo para almacenar mensajes de error
	$error = array();

	// Verificar que se proporcione el Título
	if (isset($_POST['titulo'])&&empty($_POST['titulo']))
		$error[]="Olvidó introducir el Título.";
	else{
		$titulo = trim($_POST['titulo']);
	}

	// Verificar que se propocione la información
	if (isset($_POST['info'])&&empty($_POST['info']))
		$error[]="Olvidó introducir la Información.";
	else{
		$info = trim($_POST['info']);
	}

	
	// Verificar que se proporcione una plantilla
	if (empty($_POST['plan']))
		$error[] = 'Olvidó elegir el tipo de plantilla';
	else{
		$plan = trim($_POST['plan']);
		//$plan = mysqli_real_escape_string($conexion, $plan);
	}

	// Estructurar la consulta y ejecutarla
	if(empty($error)){
		// procedimiento almacenado para guardar info
		$query = "call guardarAnuncio('$titulo', '$info',$plan)";
		

		// Ejecutar el procedimiento almacenado
		$resultado = mysqli_query($conexion, $query);

		// Si el resultado tuvo éxito, entonces recargar página
		if ($resultado){
			mysqli_next_result($conexion);
			@mysqli_free_result($resultado);
			$query1 = "select LAST_INSERT_ID() as id from anuncio";
			$res1 = mysqli_query($conexion, $query1);
			if($res1){
				echo '<script>alert("¡Gracias! anuncio guardado con éxito")</script>';
				while ($row = mysqli_fetch_assoc($res1)) {
					$id = $row['id'];
					echo "<script>window.open('imagen.php?id=".$id."&plan=".$plan."','_blank');</script>";
					echo '<script>location.href="crear.php"</script>';
					break;
				}
				mysqli_free_result($res1);
			}
			else{
			echo '<h2 class="error">¡Error del sistema!</h2>';
			echo '<p>Lo sentimos el servidor está en mantenimiento, intente más tarde</p>';

			// Debuggin message:
			echo '<p>'.mysqli_error($conexion).'<br>Query: '.$query1.'</p>';
			}
		}
		else{
			echo '<h2 class="error">¡Error del sistema!</h2>';
			echo '<p>Lo sentimos el servidor está en mantenimiento, intente más tarde</p>';

			// Debuggin message:
			echo '<p>'.mysqli_error($conexion).'<br>Query: '.$query.'</p>';
		}
		mysqli_close($conexion);
	}
}

?>
		<form id="form" method="post" action="crear.php">
			<fieldset>
				<label for="titulo" class="txt">Título:</label>
				<input type="text" class="pw lab" id="titulo" name="titulo" value="<?php if(isset($_POST['titulo'])) echo $_POST['titulo']; ?>">
				<br><br>
				<label for="info" class="txt area">Información:</label>
				<textarea id="info" class="pw lab info" name="info" value="<?php if(isset($_POST['info'])) echo $_POST['info']; ?>"></textarea>
				<div class="error centrado">
					<span class="error">
						<?php
							if (!empty($error)){
								foreach ($error as $msg) {	// Mostrar cada error
								echo "<b class='error'>*$msg</b> <br>\n";
								}
							}
						?>
					</span>
				</div>
				<br>
				<div>
					<center>
						<label onclick="flotante(1)" class="txt">Plantilla*:</label>
						<select id="plantilla" name="plan">
							<option value="">-</option>
							<option id="p_1">1</option>
							<option id="p_2">2</option>
							<option id="p-3">3</option>
						</select>
						<!--<a onclick="flotante(1)"><img src="comun/imagenes/ojo.png"></a>-->
						<div id="contenedor" style="display: none;">
							<div id="flotante">
								<h1>Opciones:</h1>
								<img src="comun/imagenes/plantilla_1.jpg" title="1" width="30%" height="50%">
								<img src="comun/imagenes/plantilla_2.jpg" title="2" width="30%" height="50%">
								<img src="comun/imagenes/plantilla_3.jpg" title="3" width="30%" height="50%"><br>
								<h3><a onclick="flotante(2)">Cerrar ventana</a></h3>
							</div>
							<div id="fondo"></div>
						</div>
					</center>
				</div><br>
					<button class="boton">Guardar</button>
					<button class="boton" type="reset">Limpiar</button>
			</fieldset>
		</form>
		</div>

	      <div class="sidebar2">
	      	<a href="logout.php">
				<img src="comun/imagenes/logout.png" width="80%">
			</a>
	      </div>
  		</div>
</body>
</html>
