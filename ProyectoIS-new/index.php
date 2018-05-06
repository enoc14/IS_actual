<?php
	$query = "";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>NOTIFITEC</title>
		<link href="comun/css/estilo.css" rel="stylesheet" type="text/css">
		<link href="comun/css/menu.css" rel="stylesheet" type="text/css">
		<link href="comun/css/sl.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<div class="container">
			
	      <div class="sidebar1">

	      </div>

		  <div class="content">

		  	<div class="man">
		  		
		  		<div class="slides">
		  			<?php
		  				require ("../mysqli_connect_is.php");
		  				// procedimiento almacenado para guardar info
						$query = "call getAnunciosPublicados()";
						// Ejecutar el procedimiento almacenado
						$resultado = mysqli_query($conexion, $query);

						if($resultado){
							while ($row = mysqli_fetch_assoc($resultado)) {
								$ruta = $row['ruta'];
								echo '<img src="'.$ruta.'">';
							}
						}
						else{
							echo '<h2 class="error">¡Error del sistema!</h2>';
							echo '<p>Lo sentimos el servidor está en mantenimiento, intente más tarde</p>';

							// Debuggin message:
							echo '<p>'.mysqli_error($conexion).'<br>Query: '.$query1.'</p>';
						}
						mysqli_next_result($conexion);
						mysqli_free_result($resultado);
						
						$query1 = "call getArchivosPublicados()";
						// Ejecutar el procedimiento almacenado
						$resultado1 = mysqli_query($conexion, $query1);

						if($resultado1){
							while ($row = mysqli_fetch_assoc($resultado1)) {
								$ruta = $row['archivo'];
								echo '<img src="'.$ruta.'">';
							}
						}
						else{
							echo '<h2 class="error">¡Error del sistema!</h2>';
							echo '<p>Lo sentimos el servidor está en mantenimiento, intente más tarde</p>';

							// Debuggin message:
							echo '<p>'.mysqli_error($conexion).'<br>Query: '.$query1.'</p>';
						}

						mysqli_free_result($resultado1);
						mysqli_close($conexion);
		  			?>	
		  		</div>

		  	</div>

		  </div>

	      <div class="sidebar2">
	      	<a href="login.php">
				<img src="comun/imagenes/login.png" width="80%">
			</a>
	      </div>
  		</div>
  		<script type="text/javascript" src="comun/js/jquery.js"></script>
  		<script type="text/javascript" src="comun/js/jquery.slides.js"></script>
  		<script type="text/javascript">
  			$(function(){
  				$(".slides").slidesjs({
    				play: {
	      				active: true,
	        			// [boolean] Generate the play and stop buttons.
	        			// You cannot use your own buttons. Sorry.
	      				effect: "slide",
	        			// [string] Can be either "slide" or "fade".
				      	interval: 10000,
	        			// [number] Time spent on each slide in milliseconds.
	      				auto: true,
	        			// [boolean] Start playing the slideshow on load.
	      				swap: true,
	        			// [boolean] show/hide stop and play buttons
	      				pauseOnHover: false,
	        			// [boolean] pause a playing slideshow on hover
	      				restartDelay: 2500
	        			// [number] restart delay on inactive slideshow
    				}
  				});
			});
  		</script>
	</body>
</html>
