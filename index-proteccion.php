<!doctype html>
<html lang="es">
<?php include('_includes/_htmlhead.php'); ?>

<body>

<div id="main-spinner" class="spinnerwrapper">
	<?php include '_includes/spinner.php'; ?>
</div>

<header class="header" id="zurich-header"></header>
<main role="main"> 
<div class="tab-content" id="myTabContent">
	<div class="tab-pane fade show active" id="panel-resumen" role="tabpanel" aria-labelledby="panel-resumen-tab">
		<div class="main panel"></div>
	</div>
	<div class="tab-pane fade" id="panel-coberturas" role="tabpanel" aria-labelledby="panel-coberturas-tab">
		<div class="main panel"></div>
	</div>
	<div class="tab-pane fade" id="panel-pagos" role="tabpanel" aria-labelledby="panel-pagos-tab">
		<div class="main panel"><?php // include '_includes/spinner.php'; ?></div>
	</div>
	<div class="tab-pane fade" id="panel-gestiones" role="tabpanel" aria-labelledby="panel-gestiones-tab">
		<div class="main panel"><?php // include '_includes/spinner.php'; ?></div>
	</div>
	<div class="tab-pane fade" id="panel-informacion-fiscal" role="tabpanel" aria-labelledby="panel-informacion-fiscal-tab">
		<div class="main panel"><?php // include '_includes/spinner.php'; ?></div>
	</div>
	<div class="tab-pane fade" id="panel-detalle-de-poliza" role="tabpanel" aria-labelledby="panel-detalle-de-poliza-tab">
		<div class="main panel"><?php // include '_includes/spinner.php'; ?></div>
	</div>
	<div class="tab-pane fade" id="panel-perfil" role="tabpanel" aria-labelledby="panelperfil-tab">
		<div class="main panel"><?php // include '_includes/spinner.php'; ?></div>
	</div>
	<div class="tab-pane fade" id="panel-fondos-vigentes" role="tabpanel" aria-labelledby="panelfondos-vigentes-tab">
		<div class="main panel"><?php // include '_includes/spinner.php'; ?></div>
	</div>
</div>
</main> 
<footer id="zurich-footer"></footer>

<?php include '_includes/modal-default.php'; ?>
<?php include '_includes/modal-editar-email.php'; ?>
<?php include '_includes/modal-cambiar-clave.php'; ?>
<?php include '_includes/modal-cambiaste-clave.php'; ?>

<?php include '_includes/scripts.php'; ?>

<script>
$(function(){
	gZinit([
		["get","static","json/static.json"],
		["get","poliza","json/poliza.php"],
		
		["spinner", ".7"],
		
		["tpl","#zurich-header", "header-proteccion.htm"],
		["tpl", "#zurich-footer", "footer.htm"],
		["tpl","#panel-resumen>.main.panel", "01-proteccion-resumen.htm"],
		
		["spinner", "-1"],
		
		["tpl","#panel-coberturas>.main.panel", "02-proteccion-cobertura.htm"],
		["tpl","#panel-pagos>.main.panel", "03-proteccion-pagos.htm"],
		["tpl","#panel-gestiones>.main.panel", "gestiones.htm"],
		["tpl","#panel-informacion-fiscal>.main.panel", "05-proteccion-informacion-fiscal.htm"],
		["tpl","#panel-detalle-de-poliza>.main.panel", "06-proteccion-detalle-de-poliza.htm"],
		["tpl","#panel-perfil>.main.panel", "perfil.htm"]
		]);
	});

</script>
</body>
</html>