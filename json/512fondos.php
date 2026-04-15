<?php
	setlocale(LC_TIME, 'es_ES');
//	echo strftime('%B %d, %Y', strtotime('2012-09-22 11:21:53'));

$mesesDesdeInicio = 28;
?>{
	"receipts":[
		"fondos"
		],

	"fondos": {
		"rendimientoPlazo": 12,
		"fechaPrecio": "2019-06-01",
		"maxValue": 60, <?php // mayor valor de las series, usado como valor maximo para los graficos de todos los fondos ?>
		
		"misFondos": [
			{
			"nombre": "Performance dolar II",
			"urlComposicion": "files/download.php?file=Composicion Fondo - Performance dolar II",
			"precioUnidadUsd": <?= mt_rand() / mt_getrandmax() *6 ?>,
			"rendimientoAnual": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"evolucionPrecioUnidad": [ 
				<?php 
					for ($i = 0; $i < $mesesDesdeInicio; $i++) {
						echo($i*1.2+20+rand(.1,1));
						if($i<$mesesDesdeInicio-1){ echo(","); }
					}
					?> ],
			"evolucionRendimiento":[
				{
					"anio": "2018",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 5.33, 5.33, 5.18, 5.18, 5.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2017",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 6.33, 6.33, 6.18, 6.18, 6.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2016",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 7.33, 7.33, 5.18, 7.18, 7.18, 6.32, 7.33, 8.58, 7.33, 5.31, 5.30, 5.29 ]
				}
				]	
			},
			{
			"nombre": "Income dolar II",
			"urlComposicion": "files/download.php?file=Composicion Fondo - Income dolar II",
			"precioUnidadUsd": <?= mt_rand() / mt_getrandmax() *6 ?>,
			"rendimientoAnual": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"evolucionPrecioUnidad": [ <?php 
					for ($i = 0; $i < $mesesDesdeInicio; $i++) {
						echo($i*1.1+15+rand(.1,1.2));
						if($i<$mesesDesdeInicio-1){ echo(","); }
					}
					?> ],
			"evolucionRendimiento":[
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 5.33, 5.33, 5.18, 5.18, 5.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 6.33, 6.33, 6.18, 6.18, 6.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 7.33, 7.33, 5.18, 7.18, 7.18, 6.32, 7.33, 8.58, 7.33, 5.31, 5.30, 5.29 ]
				}
				]	
			},
			{
			"nombre": "Secure dolar",
			"urlComposicion": "files/download.php?file=Composicion Fondo - Secure dolar",
			"precioUnidadUsd": <?= mt_rand() / mt_getrandmax() *6 ?>,
			"rendimientoAnual": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"evolucionPrecioUnidad": [ <?php 
					for ($i = 0; $i < $mesesDesdeInicio; $i++) {
						echo($i*0.7+15+rand(.1,1));
						if($i<$mesesDesdeInicio-1){ echo(","); }
					}
					?> ],
			"evolucionRendimiento":[
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 5.33, 5.33, 5.18, 5.18, 5.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 6.33, 6.33, 6.18, 6.18, 6.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 7.33, 7.33, 5.18, 7.18, 7.18, 6.32, 7.33, 8.58, 7.33, 5.31, 5.30, 5.29 ]
				}
				]	
			},
			{
			"nombre": "Lump Sum dolar",
			"urlComposicion": "files/download.php?file=Composicion Fondo - Lump Sum dolar",
			"precioUnidadUsd": <?= mt_rand() / mt_getrandmax() *6 ?>,
			"rendimientoAnual": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"evolucionPrecioUnidad": [ <?php 
					for ($i = 0; $i < $mesesDesdeInicio; $i++) {
						echo($i*0.5+14+rand(.1,2));
						if($i<$mesesDesdeInicio-1){ echo(","); }
					}
					?> ],
			"evolucionRendimiento":[
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 5.33, 5.33, 5.18, 5.18, 5.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 6.33, 6.33, 6.18, 6.18, 6.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 7.33, 7.33, 5.18, 7.18, 7.18, 6.32, 7.33, 8.58, 7.33, 5.31, 5.30, 5.29 ]
				}
				]	
			}
		],
		"otrosFondos": [
			{
			"nombre": "Commodities dolar",
			"urlComposicion": "files/download.php?file=Composicion Fondo - Commodities dolar",
			"precioUnidadUsd": <?= mt_rand() / mt_getrandmax() *6 ?>,
			"rendimientoAnual": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"evolucionPrecioUnidad": [ 
				<?php 
					for ($i = 0; $i < $mesesDesdeInicio; $i++) {
						echo($i*0.7+10+rand(.1,1));
						if($i<$mesesDesdeInicio-1){ echo(","); }
					}
					?> ],
			"evolucionRendimiento":[
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 5.33, 5.33, 5.18, 5.18, 5.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 6.33, 6.33, 6.18, 6.18, 6.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 7.33, 7.33, 5.18, 7.18, 7.18, 6.32, 7.33, 8.58, 7.33, 5.31, 5.30, 5.29 ]
				}
				]	
			},
			{
			"nombre": "Rainbow G dolar",
			"urlComposicion": "files/download.php?file=Composicion Fondo - Rainbow G dolar",
			"precioUnidadUsd": <?= mt_rand() / mt_getrandmax() *6 ?>,
			"rendimientoAnual": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"evolucionPrecioUnidad": [ 
				<?php 
					for ($i = 0; $i < $mesesDesdeInicio; $i++) {
						echo($i*0.5+10+rand(.1,1));
						if($i<$mesesDesdeInicio-1){ echo(","); }
					}
					?> ],
			"evolucionRendimiento":[
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 5.33, 5.33, 5.18, 5.18, 5.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 6.33, 6.33, 6.18, 6.18, 6.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 7.33, 7.33, 5.18, 7.18, 7.18, 6.32, 7.33, 8.58, 7.33, 5.31, 5.30, 5.29 ]
				}
				]	
			},
			{
			"nombre": "Money dolar",
			"urlComposicion": "files/download.php?file=Composicion Fondo - Money dolar",
			"precioUnidadUsd": <?= mt_rand() / mt_getrandmax() *6 ?>,
			"rendimientoAnual": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"evolucionPrecioUnidad": [ 
				<?php 
					for ($i = 0; $i < $mesesDesdeInicio; $i++) {
						echo($i*0.3+10+rand(.1,1));
						if($i<$mesesDesdeInicio-1){ echo(","); }
					}
					?> ],
			"evolucionRendimiento":[
				{
					"anio": "2018",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 5.33, 5.33, 5.18, 5.18, 5.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2017",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 6.33, 6.33, 6.18, 6.18, 6.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2016",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 7.33, 7.33, 5.18, 7.18, 7.18, 6.32, 7.33, 8.58, 7.33, 5.31, 5.30, 5.29 ]
				}
				]	
			},
			{
			"nombre": "Performance USA ST dolar",
			"urlComposicion": "files/download.php?file=Composicion Fondo - Performance USA ST dolar",
			"precioUnidadUsd": <?= mt_rand() / mt_getrandmax() *6 ?>,
			"rendimientoAnual": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"evolucionPrecioUnidad": [ 
				<?php 
					for ($i = 0; $i < $mesesDesdeInicio; $i++) {
						echo($i*0.2+10+rand(.1,1));
						if($i<$mesesDesdeInicio-1){ echo(","); }
					}
					?> ],
			"evolucionRendimiento":[
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 5.33, 5.33, 5.18, 5.18, 5.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 6.33, 6.33, 6.18, 6.18, 6.18, 6.32, 5.33, 8.58, 5.33, 5.31, 5.30, 5.29 ]
				},
				{
					"anio": "2015",
					"rendimiento": <?= mt_rand() / mt_getrandmax() *3 ?>,
					"evolucionPrecioUnidad": [ 7.33, 7.33, 5.18, 7.18, 7.18, 6.32, 7.33, 8.58, 7.33, 5.31, 5.30, 5.29 ]
				}
				]	
			}
		]
	}
	
}