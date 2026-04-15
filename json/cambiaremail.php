<?php

// Placeholder de interfaz backend/JSON para cambio de email.
// El presente código tiene como único fin testear las funciones de la interfaz.

$email = $_POST['email'] ?? ''; //Tomamos valor enviado por POST. Si no se envió nada, aplicamos default ('').

if( strlen( $email ) > 4 ){
	// Para este placeholder, tomamos como válido cualquier string de más de 4 caracteres.
	// Al devolver "OK", habilitamos la interfaz a procesar por su parte (ocultar cuadro modal, etc).
	// Cualquier mensaje de éxito corresponderá a la interfaz.
	echo("OK");
	
}else{
	// Para este placeholder, tomamos como INVALIDO cualquier string de 4 o menos caracteres.
	// Al devolver cualquier string que no sea "OK", la interfaz mantiene a la vista el cuadro modal, presentando el string que devolvemos como mensaje de error:
	echo("La dirección ingresada no es válida.");

};


?>