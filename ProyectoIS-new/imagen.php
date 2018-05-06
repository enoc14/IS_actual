<?php
    Header("Content-type: image/jpeg");

    if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) && (isset($_GET['plan'])) && (is_numeric($_GET['plan']))){ // desde paginas.php
		$id = $_GET['id'];
		$p = $_GET['plan'];
	}
	else { // ID inválido, salir del script
		echo '<p class="error">Esta página se intentó acceder por error</p>';
		exit();
	}

	// Conectar a la base de datos
	require ("../mysqli_connect_is.php");

	// Estructurar el Procedimiento Almacenado y Ejecutarlo
	$query = "call r_img($id)";
	$resultado = mysqli_query($conexion, $query);

    $font = "comun/fonts/Verdana.ttf";
    $font_size = 10;
    $font_color = 0x000000;
	
	$im = imagecreatefromjpeg("comun/imagenes/plantilla_".$p.".jpg"); // trabajar sobre una imagen
    $negro = imagecolorallocate ($im, 0, 0, 0); // establecer color negro

    while ($row = mysqli_fetch_assoc($resultado)) {    
	    $txt = $row['informacion'];
	    $lines = explode('|', wordwrap($txt, 115, '|'));
	    $y = 240;
	    imagettftext($im, 15, 0, 14, 210, $font_color, $font, utf8_decode($row['titulo']));
	    foreach ($lines as $line){
		    imagettftext($im, $font_size, 0, 14, $y, $font_color, $font, utf8_decode($line));
		    // Increment Y so the next line is below the previous line
		    $y += 23;
		}
	}
    Imagejpeg($im, 'files/anuncio_'.$id.'.jpg');
   	Imagedestroy($im);
?>