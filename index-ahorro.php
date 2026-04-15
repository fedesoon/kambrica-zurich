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
	<div class="tab-pane fade show active" id="panel-resumen" role="tabpanel" aria-labelledby="panel-ahorro-resumen-tab">
		<div class="main panel"></div>
	</div>
	<div class="tab-pane fade" id="panel-cuenta-individual" role="tabpanel" aria-labelledby="panel-cuenta-individual-tab">
		<div class="main panel"></div>
	</div>
	<div class="tab-pane fade" id="panel-pagos" role="tabpanel" aria-labelledby="panel-pagos-tab">
		<div class="main panel"><?php // include '_includes/spinner.php'; ?></div>
	</div>
	<div class="tab-pane fade" id="panel-fondos" role="tabpanel" aria-labelledby="panel-fondos-tab">
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
	<div class="tab-pane fade" id="panel-perfil" role="tabpanel" aria-labelledby="panel-perfil-tab">
		<div class="main panel"><?php // include '_includes/spinner.php'; ?></div>
	</div>
	<div class="tab-pane fade" id="panel-mis-fondos-vigentes" role="tabpanel" aria-labelledby="panel-fondos-vigentes-tab">
		<div class="main panel"><?php // include '_includes/spinner.php'; ?></div>
	</div>
	<div class="tab-pane fade" id="panel-otros-fondos-vigentes" role="tabpanel" aria-labelledby="panel-fondos-vigentes-tab">
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
		
		["tpl", "#zurich-header", "header-ahorro.htm"],
		["tpl", "#zurich-footer", "footer.htm"],
		["tpl","#panel-resumen>.main.panel", "01-ahorro-resumen.htm"],
		
		["spinner", "-1"],
		
		["tpl","#panel-cuenta-individual>.main.panel", "02-ahorro-cuenta-individual.htm"],
		["tpl","#panel-pagos>.main.panel", "03-ahorro-pagos.htm"],
		["tpl","#panel-gestiones>.main.panel", "gestiones.htm"],
		["tpl","#panel-informacion-fiscal>.main.panel", "06-ahorro-informacion-fiscal.htm"],
		["tpl","#panel-detalle-de-poliza>.main.panel", "07-ahorro-detalle-de-poliza.htm"],
		["tpl","#panel-mis-fondos-vigentes>.main.panel", "mis-fondos-vigentes.htm"],
		["tpl","#panel-otros-fondos-vigentes>.main.panel", "otros-fondos-vigentes.htm"],
		["tpl","#panel-perfil>.main.panel", "perfil.htm"],

		["get","poliza","json/fondos.php"],
		["tpl","#panel-fondos>.main.panel", "04-ahorro-fondos.htm"]
		]);
	});
</script>
</body>
</html>