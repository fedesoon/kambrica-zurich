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
	<div class="tab-pane fade show active" id="panel-gestiones" role="tabpanel" aria-labelledby="panel-gestiones-tab">
		<div class="main panel"><?php // include '_includes/spinner.php'; ?></div>
	</div>
	<div class="tab-pane fade" id="panel-detalle-de-poliza" role="tabpanel" aria-labelledby="panel-detalle-de-poliza-tab">
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
		
		["tpl", "#zurich-header", "header-error.htm"],
		["tpl", "#zurich-footer", "footer.htm"],
		["tpl","#panel-resumen>.main.panel", "01-ahorro-resumen.htm"],
		
		["spinner", "-1"],
		
		["tpl","#panel-gestiones>.main.panel", "gestiones.htm"],
		["tpl","#panel-detalle-de-poliza>.main.panel", "error-detalle-de-poliza.htm"],

		["tpl","#panel-perfil>.main.panel", "perfil.htm"],

		["get","poliza","json/fondos.php"],
		["tpl","#panel-fondos>.main.panel", "04-ahorro-fondos.htm"]
		]);
	});
</script>
</body>
</html>