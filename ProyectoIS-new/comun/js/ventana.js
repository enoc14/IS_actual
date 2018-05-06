function flotante(tipo){
	
	if (tipo==1){
	//Si hacemos clic en abrir mostramos el fondo negro y el flotante
		$('#contenedor').show();
	    $('#flotante').animate({
	      marginTop: "-152px"
    	});
	}
	if (tipo==2){
		//Si hacemos clic en cerrar, deslizamos el flotante hacia arriba
	    $('#flotante').animate({
	      marginTop: "-756px"
	    });
		//Una vez ocultado el flotante cerramos el fondo negro
		setTimeout(function(){
		$('#contenedor').hide();
		},500)
	}
}