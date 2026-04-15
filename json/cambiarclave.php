<?php

// Placeholder de interfaz backend/JSON para cambio de clave.
// El presente código tiene como único fin testear las funciones de la interfaz.

$clave = $_POST['clave'] ?? ''; //Tomamos valor enviado por POST. Si no se envió nada, aplicamos default ('').

if( strlen( $clave ) > 4 ){
	// Para este placeholder, tomamos como válido cualquier string de más de 4 caracteres.
	// Al devolver "OK", habilitamos la interfaz a procesar por su parte (ocultar cuadro modal, etc).
	// Cualquier mensaje de éxito corresponderá a la interfaz.
	echo("OK");
	
}else{
	// Para este placeholder, tomamos como INVALIDO valor vacío.
	echo("La clave debe tener al menos 8 caracteres, y [describir demás reglas de seguridad]");

};

?>