<?php
// Verificar si se inició sesión
session_start();
if($_SESSION['tipo'] != 'admin1'){
	header("Location:index.php");
}

$page_title = "Configuracion"; 	// Nombre de la pestaña
include 'includes/menu.php'; // incluir en diseño del menú a la página

if ($_SERVER['REQUEST_METHOD']=='POST') {
	require '../mysqli_connect_is.php';
	$error = array();
	if(empty($_POST['oldPass'])){
		$error[] = "Olvidó ingresar la contraseña actual";
	}
	else{
		$oldPass = $_POST['oldPass'];
	}
	if(empty($_POST['newPass'])){
		$error[] = "Olvidó ingresar la contraseña nueva";
	}
	else{
		$newPass = $_POST['newPass'];
	}

	$query = "call IdentificarUsr('$oldPass')";
	$resul = mysqli_query($conexion,$query);
	if($resul){
		$num = mysqli_num_rows($resul);
        if($num>0){
            while($fila = mysqli_fetch_array($resul)){
                $cuenta=$fila[0];
            }
            mysqli_next_result($conexion);
            mysqli_free_result($resul);
            if($cuenta==$_SESSION['tipo']){
            	$query = "call CambContraseña('".$_SESSION['tipo']."', '$newPass')";
            	$resul = mysqli_query($conexion,$query);
            	if($resul){
            		mysqli_next_result($conexion);
            		mysqli_free_result($resul);
            		echo '<script>alert("La contraseña fue cambiada exitosamente")</script>';
                	echo "<script>location.href='configuracion.php'</script>";
            	}
            	else{
            		$error[] = "No se pudo cambiar su contraseña. Intente mas tarde.";
            		echo '<p>'.mysqli_error($conexion).'<br>Query: '.$query.'</p>';
            	}
            }
            else{
				$error[] = "Contraseña actual equivocada";
			}
        }

	}
	else{
		$error[] = "No se pudo validar su contraseña actual. Intente mas tarde.";
		echo '<p>'.mysqli_error($conexion).'<br>Query: '.$query.'</p>';
	}

}
?>
	<form id="form" method="post" action="configuracion.php">
			<fieldset class="centrado">
				<label for="titulo" class="label titulo centrado">CAMBIAR CONTRASEÑA</label>
				<br><br>
				<label for="info" class="txt area">Contraseña:</label>
				<input type="text" id="info" class="pw lab info" name="info" value="<?php if(isset($_POST['info'])) echo $_POST['info']; ?>">
                <label for="info" class="txt area">Nueva contraseña:</label>
                <input type="text" id="info" class="pw lab info" name="info" value="<?php if(isset($_POST['info'])) echo $_POST['info']; ?>">
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
				</div><br>
				
					<button class="boton">Guardar</button>
					<button class="boton" type="reset">Limpiar</button>
				</center>
			</fieldset>
		</form>
	</div>
	<div class="sidebar2">
      		<a href="logout.php">
			<img src="comun/imagenes/logout.png" width="80%">
		</a>
        </div>
</body>
</html>
