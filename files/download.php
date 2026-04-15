<?php

$filename = "archivo.txt";
if( $_GET['file']){
	$filename = $_GET['file'];
	if( ! strpos( $filename, "." ) ){ //agregar extension .txt por default si no se la declaro
		$filename .= ".txt";
	}

}
header('Content-Type: '.$type.'; charset=utf-8');
header('Content-Disposition: attachment; filename="'.$filename.'"');

?>///// ARCHIVO PARA TESTEAR DESCARGAS // FILE DOWNLOAD TEST /////

<?php
//var_dump de GET recibido:
//var_dump( $_GET );
?>
Listado de valores obtenidos en link (argumentos GET después de "?" en URL):
<?php
foreach ($_GET as $key => $value) {
    echo "\t" . $key . ' => ' . $value . "\xA";
}
?>

// final archivo