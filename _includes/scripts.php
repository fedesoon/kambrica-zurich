<?php /*

//librerias JavaScript en local:


<script src="js/jquery-3.3.1.min.js"></script>

<script src="js/bootstrap.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/jsrender/jsrender.min.js"></script>
<script src="js/numeral/numeral.min.js"></script>
<script src="js/numeral/numeral_locale.es.min.js"></script>

<script src="js/moment/moment-with-locale-es.min.js"></script> // version custom, con moment.locale.es-z.min.js
//unbundled:
	//<script src="js/moment/moment.min.js "></script>
	//<script src="js/moment/moment.locale.es-z.js"></script>
	
<script src="js/chartjs/Chart.min.js"></script>


//////////////////////////////////////////////////////////////////////

//version consolidada de jsdelivr.net / riesgo de que no tenga suficientes requests para que funcione el cache del cdn.
<script src="https://cdn.jsdelivr.net/combine/npm/jquery@3.4.1,npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js,npm/jsrender@1.0.3,npm/numeral@2.0.6,npm/numeral@2.0.6/locales/es.min.js,npm/moment@2.24.0,npm/chart.js@2.8.0"></script>

//solo jquery, popper, bootstrap consolidados:
//<script src="https://cdn.jsdelivr.net/combine/npm/jquery@3.4.1,npm/popper.js@1.15.0,npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>

//////////////////////////////////////////////////////////////////////


//version NO consolidada de jsdelivr.net:
*/
?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jsrender@1.0.3/jsrender.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/numeral@2.0.6/numeral.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/numeral@2.0.6/locales/es.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>

<script src="js/moment/moment-with-locale-es.min.js"></script>


<?php // scripts propios o fuera de CDN: ?>

<script src="js/datepicker-bundle.es.min.js"></script>
<script src="js/kmb-horizontal-scrollable-menu.min.js"></script>

<script src="js/zurichvida.js?time=<?= time() ?>"></script>
