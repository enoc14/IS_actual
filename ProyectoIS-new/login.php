<?php
	session_start();
	if(isset($_SESSION['tipo'])&&$_SESSION['tipo'] == 'admin1'){
		header("Location:crear.php");
	}
	$page_title = "Subir anuncio";

	if ($_SERVER['REQUEST_METHOD']=='POST') {
		// Conectar a la base de datos
		require ("../mysqli_connect_is.php");
		if (isset($_POST['password'])&&empty($_POST['password'])) {
			$error="Olvidó introducir la contraseña.";
		}
		else{
			$password = trim($_POST['password']);
        }
        
        $query = "call IdentificarUsr('$password')";
        $resultado = mysqli_query($conexion, $query);

        if ($resultado) {
            $num = mysqli_num_rows($resultado);
            if($num>0){

                while($fila = mysqli_fetch_array($resultado)){
                        $cuenta=$fila[0];
                }
				//Liberar el resultado
                mysqli_free_result($resultado);
				//Iniciar la sesión
                session_start();   
                $_SESSION['contraseña'] = $password;  

                if($cuenta=='admin1'){
                        $_SESSION['tipo'] = 'admin1';
                        header ("Location: crear.php");
                }
                elseif($cuenta=='admin2'){
                        $_SESSION['tipo'] = 'admin2';
                        header("Location: crear.php");
                }
                else{
                	$error = "Contraseña incorrecta, por favor intente de nuevo.";
                }
            }
            else{
                $error = "Usuario o contraseña equivocada";
            }
        }
        else{
            $error = "Por el momento no se puede iniciar sesión";
        }

	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Iniciar sesión</title>
		<link href="comun/css/estilo.css" rel="stylesheet" type="text/css">
		<link href="comun/css/menu.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<div class="container">
			
	      <div class="sidebar1">

	      </div>

		  <div class="content">
		  		<br>
		  		<form id="form" method="post"	action="login.php">
				<fieldset>
					<h1 class="titulo">Iniciar sesión</h1>
					<label for="password" class="txt">Contraseña:</label>  
					<input type="password" class="pw" id="password" name="password">
					<div>
						<span class="error">
							<?php
								echo (isset($error)) ? "$error" : "";
							?>
						</span>
					</div>
				<button class="boton">Enviar</button>
				<button class="boton" formaction="index.php">Regresar</button>
				</fieldset>
			</form>
		  </div>

	      <div class="sidebar2">
	      	
	      </div>
  		</div>
	</body>
</html>
