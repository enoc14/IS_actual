<?php
	session_start();
	if($_SESSION['tipo'] != 'admin1'){
		header("Location:index.php");
	}
	$page_title = 'Eliminar anuncio no publicado';
	include 'includes/menu.php'; // incluir en diseño del menú a la página

	echo "<div class='cont'>
	<h1>Eliminar un anuncio no publicado<h1>";

	// Verificar si el ID del usuario es válido (método GET o POST)
	if ( (isset($_GET['id']))) // desde paginas.php
		$anuncio = $_GET['id'];
	elseif ( (isset($_POST['id']))) // por Formulario
		$anuncio = $_POST['id'];
	else { // ID inválido, salir del script
		echo '<p>Esta página se intentó acceder por error</p>';
		include ("../includes/footer.php");
		exit();
	}

	// Conectar a la base de datos
	require ("../mysqli_connect_is.php");

	// Verificar que la forma ha sido enviada
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$a = $_POST['id'];
		if ($_POST['sure'] == 'Yes') { // Es seguro eliminar el registro
			// Estructurar la consulta para borrar
			$query = "call eliminarAnuncio('$a')";		
			$resul = @mysqli_query ($conexion, $query);
			if (mysqli_affected_rows($conexion) == 1){
				// mostrar el mensaje
				echo '<script>alert("El anuncio ha sido eliminado con éxito")</script>';				
				echo "<script>location.href='publicar.php'</script>";
			}
			else { // si la consulta no tuvo éxito
				echo '<p class="error">Por un error del sistema, el anuncio NO fue eliminado</p>';
				echo '<p>' . mysqli_error($conexion) . '<br />Query: ' . $query . '</p>'; 
			}
		} else{
			echo '<script>alert("El anuncio NO fue eliminado")</script>';				
			echo "<script>location.href='publicar.php'</script>";
		}
	}
	else { // Mostrar el formulario

		// estructurar la consulta
		$query = "call getNP('$anuncio');";
		$resul = @mysqli_query ($conexion, $query);

		if (mysqli_num_rows($resul) == 1) { // Se encontró el ID

			// extraer la información del usuario
			$fila = mysqli_fetch_assoc ($resul);
			
			// mostrar el registro que se desea eliminar
			echo "<h3>Título: ".$fila['titulo']."</h3>
				 ¿Está seguro de querer eliminar este anuncio?";
			
			// crear el formulario
			echo '<form action="eliminar_anuncio_np.php" method="POST">
					<div>
						<p>
							<label for="s">Si</label>
							<input type="radio" id="s" name="sure" value="Yes" />
						</p>
						<p>
							<label for="n">No</label>
							<input type="radio" id="n" name="sure" value="No" checked="checked" />
						</p>
					</div>
					<center><button class=boton>Enviar</button></center>
					<input type="hidden" name="id" value="' .$anuncio. '" />
				  </form>'; // el campo id y su valor se envían ocultos (type="hidden")
		} else
			echo '<p class="error">Esta página ha sido accedida por error.</p>';

	} // Fin de mostrar el formulario. 
	mysqli_close($conexion);
?>
	</div>
	</div>
	<div class="sidebar2">
		<a href="logout.php">
			<img src="comun/imagenes/logout.png" width="80%">
		</a>
	</div>
</body>
</html>
