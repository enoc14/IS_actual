<?php
// Verificar si se inició sesión
session_start();
if($_SESSION['tipo'] != 'admin1'){
	header("Location:index.php");
}

	$page_title = "Anuncios"; 	// Nombre de la pestaña
	include 'includes/menu.php'; // incluir en diseño del menú a la página
	$ar = 0;
	$an = 1;
	// Conectar a la base de datos
	require ("../mysqli_connect_is.php");

	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) && (isset($_GET['type'])) && (is_numeric($_GET['type'])) ){ // desde paginas.php
		$id = $_GET['id'];
		$type = $_GET['type'];

		if($type == $an){
			// Preparar PA para publicar anuncio
			$query1 = "call PublicarAnuncio($id)";
			$resultado1 = mysqli_query($conexion, $query1);

			// Si el resultado tuvo éxito, entonces recargar página
			if ($resultado1){
				echo '<script>alert("¡Gracias! anuncio publicado con éxito")</script>';
				echo '<script>location.href="publicar.php"</script>';
				mysqli_next_result($conexion);
				@mysqli_free_result($resultado1);
			}
			else{
				echo '<h2 class="error">¡Error del sistema!</h2>';
				echo '<p>Lo sentimos el servidor está en mantenimiento, intente más tarde</p>';

				// Debuggin message:
				echo '<p>'.mysqli_error($conexion).'<br>Query: '.$query1.'</p>';
			}
		}
		else if($type == $ar){
			// Preparar PA para publicar anuncio
			$query1 = "call PublicarArchivo($id)";
			$resultado1 = mysqli_query($conexion, $query1);

			// Si el resultado tuvo éxito, entonces recargar página
			if ($resultado1){
				echo '<script>alert("¡Gracias! archivo publicado con éxito")</script>';
				echo '<script>location.href="publicar.php"</script>';
				mysqli_next_result($conexion);
				@mysqli_free_result($resultado1);
			}
			else{
				echo '<h2 class="error">¡Error del sistema!</h2>';
				echo '<p>Lo sentimos el servidor está en mantenimiento, intente más tarde</p>';

				// Debuggin message:
				echo '<p>'.mysqli_error($conexion).'<br>Query: '.$query1.'</p>';
			}
		}
	}

	echo "<div class='cont'>
	<h1>Anuncios y Archivos</h1>";

	// Preparar consulta de los anuncios guardados con éxito
	$query = "call getAnunciosNoPublicados()";
	$resultado = mysqli_query($conexion, $query);
	
	// Contar los resultados obtenidos
	$num = @mysqli_num_rows($resultado);

	// Mostrar los anuncios no publicados
	if ($num > 0){

		//Tabla para mostrar los registros
		echo '<table>
				<thead>
					<tr>
						<th colspan="3">Anuncios guardados</th>
					</tr>
					<tr>
						<th>id</th>
						<th colspan="2">Título</th>
					</tr>
				</thead>';

		// Recuperar y mostrar todos los registros
		while ($anp = mysqli_fetch_assoc($resultado)){
			echo '<tbody>
					<tr>
						<td>'.$anp['id'].'</td>
						<td>'.$anp['titulo'].'</td>
						<td>
							<i class="buttona delete"><a href="eliminar_anuncio_np.php?id='.$anp['id'].'">Eliminar</a></i>
							<i class="buttona view"><a href="'.$anp['ruta'].'" target="_blank">Ver</a></i>
							<i class="buttona pub"><a href="publicar.php?id='.$anp['id'].'&type='.$an.'">Publicar</a></i>
						</td>
				  	</tr>
				  </tbody>';
		}
		echo "</table>";
	}
	else // No hubo registros
		echo '<p class="error">Actualmente no hay anuncios guardados</p>';

	// Liberar el recurso y esperar otra query
	mysqli_next_result($conexion);
	@mysqli_free_result($resultado);

	// Preparar consulta de los anuncios guardados con éxito
	$query3 = "call getArchivosNoPublicados()";
	$resultado3 = mysqli_query($conexion, $query3);
	
	// Contar los resultados obtenidos
	$num3 = @mysqli_num_rows($resultado3);

	// Mostrar los anuncios no publicados
	if ($num3 > 0){

		//Tabla para mostrar los registros
		echo '<table>
				<thead>
					<tr>
						<th colspan="3">Archivos guardados</th>
					</tr>
					<tr>
						<th>id</th>
						<th colspan="2">Título</th>
					</tr>
				</thead>';

		// Recuperar y mostrar todos los registros
		while ($arnp = mysqli_fetch_assoc($resultado3)){
			echo '<tbody>
					<tr>
						<td>'.$arnp['id'].'</td>
						<td>'.$arnp['titulo'].'</td>
						<td>
							<i class="buttona delete"><a href="eliminar_archivo_np.php?id='.$arnp['id'].'">Eliminar</a></i>
							<i class="buttona view"><a href="'.$arnp['archivo'].'" target="_blank">Ver</a></i>
							<i class="buttona pub"><a href="publicar.php?id='.$arnp['id'].'&type='.$ar.'">Publicar</a></i>
						</td>
				  	</tr>
				  </tbody>';
		}
		echo "</table>";
	}
	else // No hubo registros
		echo '<p class="error">Actualmente no hay archivos guardados</p>';

	// Liberar el recurso y esperar otra query
	mysqli_next_result($conexion);
	@mysqli_free_result($resultado3);
	
	echo "<br>";

	// Preparar consulta de los anuncios publicads con éxito
	$query2 = "call getAnunciosPublicados()";

	$resultado2 = mysqli_query($conexion, $query2);
	
	// Contar los resultados obtenidos
	$num2 = @mysqli_num_rows($resultado2);

	// Mostrar los anuncios no publicados
	if ($num2 > 0){

		//Tabla para mostrar los registros
		echo '<table>
				<thead>
					<tr>
						<th colspan="3">Publicados</th>
					</tr>
					<tr>
						<th>id</th>
						<th colspan="2">Título</th>
					</tr>
				</thead>';

		// Recuperar y mostrar todos los registros
		while ($ap = mysqli_fetch_assoc($resultado2)){
			echo '<tbody>
					<tr>
						<td>'.$ap['id'].'</td>
						<td>'.$ap['titulo'].'</td>
						<td>
							<i class="buttona view"><a href="'.$ap['ruta'].'" target="_blank">Ver</a></i>
							<i class="buttona delete"><a href="eliminar_anuncio_p.php?id='.$ap['id'].'">Eliminar</a></i>
						</td>
				  	</tr>
				  </tbody>';
		}
		echo "</table>";
	}

	else // No hubo registros
		echo '<p class="error">Actualmente no hay anuncios publicados</p>';


	// Liberar el recurso y esperar otra query
	mysqli_next_result($conexion);
	@mysqli_free_result($resultado2);

	// Preparar consulta de los archivos publicados con éxito
	$query4 = "call getArchivosPublicados()";

	$resultado4 = mysqli_query($conexion, $query4);
	
	// Contar los resultados obtenidos
	$num4 = @mysqli_num_rows($resultado4);

	// Mostrar los anuncios no publicados
	if ($num4 > 0){

		//Tabla para mostrar los registros
		echo '<table>
				<thead>
					<tr>
						<th colspan="3">Archivos publicados</th>
					</tr>
					<tr>
						<th>id</th>
						<th colspan="2">Título</th>
					</tr>
				</thead>';

		// Recuperar y mostrar todos los registros
		while ($arp = mysqli_fetch_assoc($resultado4)){
			echo '<tbody>
					<tr>
						<td>'.$arp['id'].'</td>
						<td>'.$arp['titulo'].'</td>
						<td>
							<i class="buttona view"><a href="'.$arp['archivo'].'" target="_blank">Ver</a></i>
							<i class="buttona delete"><a href="eliminar_archivo_p.php?id='.$arp['id'].'">Eliminar</a></i>
						</td>
				  	</tr>
				  </tbody>';
		}
		echo "</table>";
	}
	else // No hubo registros
		echo '<p class="error">Actualmente no hay archivos publicados</p>';

	// Liberar el recurso
	@mysqli_free_result($resultado4);

	// Cerrar la conexión a la base de datos
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

