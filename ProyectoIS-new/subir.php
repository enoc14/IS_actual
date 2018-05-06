<?php 
	session_start();
	if($_SESSION['tipo'] != 'admin1'){
		header("Location:index.php");
	}
$page_title = "Subir anuncio";
include 'includes/menu.php'; 
if ($_SERVER['REQUEST_METHOD']=='POST') {

	// Conectar a la base de datos
	require ("../mysqli_connect_is.php");

	// Arreglo para almacenar mensajes de error
	$error = array();

	// Verificar que se proporcione el Título
	if (isset($_POST['titulo'])&&empty($_POST['titulo']))
		$error[]="Olvidó introducir el Título.";
	else{
		$titulo = mysqli_real_escape_string($conexion,$_POST['titulo']);
		$titulo = trim($titulo);
	}
	if (!empty($_FILES['archivo'])){
			if (is_uploaded_file($_FILES['archivo']['tmp_name'])){
				// Datos del fichero
				$ruta = $_FILES['archivo']['tmp_name']; //ruta del archivo
				$name = $_FILES['archivo']['name'];	// nombre del archivo
				$tamaño = $_FILES['archivo']['size']; //tamaño del archivo
				$nruta = 'files/'.$name;	//nueva direccion
				$array = explode('.', $name); //split con .
				$ext = end($array);	// Obtenemos la extensión el archivo
				$jpg = 'jpg';
                		$png = 'png';

				if ($ext == $jpg || $ext == $png){
					$archivo = $nruta;
				}
				else{
					$error[] = 'Asegúrese de subir un archivo tipo JPG o PNG';
				}

				if ($tamaño>2097152) { //2MB=1024*1024*2
					$error[] = "La imagen debe ser menor de 2 MB";
				}

			}
			else{
				$error[] = 'Olvidó introducir el Archivo';
			}
	}
    //Una opcion para revisar
    if (empty($error)){

			// Preparar consulta
			$query = "call guardarArchivo ('$archivo','$titulo')";

			// Ejecutar consulta
			$resultado = mysqli_query($conexion, $query);

			// Si el resultado tuvo éxito
			if ($resultado){
				if(move_uploaded_file($ruta, $archivo)){// mover a nueva dirección
                	echo '<script>alert("¡Gracias! Archivo enviado")</script>';
                	echo "<script>location.href='subir.php'</script>";
                }	
				else{
                    $errores [] = "El archivo no pudo ser guardado correctamente";
					unlink($rutaC);
                }
			}
			else{
				echo '<h2 class="error">¡Error del sistema!</h2>';
				echo '<p>Lo sentimos el servidor está en mantenimiento, intente más tarde</p>';

				// Debuggin message:
				echo '<p>'.mysqli_error($conexion).'<br>Query: '.$query.'</p>';
			}
		}
}

?>
		<form enctype="multipart/form-data" id="form" method="post"	action="subir.php">
			<fieldset>
				<label for="titulo" class="txt">Título:</label>
				<input type="text" class="pw lab" id="titulo" name="titulo" required="required" value="<?php if(isset($_POST['titulo'])) echo $_POST['titulo']; ?>"><br><br>
				<div class="centrado">
					<input type="file" name="archivo" class="inputFile centrado" required="required">
				</div>
				<div class="boton_centrado">
                    <label><strong>Solo archivos en formato jpg o png. Máximo: 2MB</strong></label>
				</div>
				<div class="centrado">
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
			<div class=boton_centrado>
				<button class="boton">Guardar</button>
				<button class="boton" type="reset">Limpiar</button>
			</div>
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
