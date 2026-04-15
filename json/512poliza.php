<?php
	setlocale(LC_TIME, 'es_ES');
//	echo strftime('%B %d, %Y', strtotime('2012-09-22 11:21:53'));
?>{
	"receipts":[
		 "poliza" <?php //, "alldata", "fondos" ?>
		],

	"usuario": {
		"nombre": "Juan Carlos",
		"apellido": "Barrionuevo",
		"email": "juancarlos@example.com",
		"documentoTipo": "DNI",
		"documentoNumero":"25.999.122",
		"nombreUsuario": "jcbarrionuevo",
		"particularDomicilio": "Av. Juramento 1000, Piso 1, Dpto 100",
		"particualrCP": "1000, CABA",
		"particularTel": "11 4000-1000",
		"correspondienciaDomicilio": "Av. Juramento 2000, Piso 2, Dpto 201",
		"correspondienciaCP": "2000, CABA",
		"correspondienciaTel": "11 4000-2223"
	},


	"nombre": "Zurich Invest",
	"numero": "246777",
	"estado": "Vigente",
	"tipo": "ahorro",

<?php
	$fechaInicial = new DateTime( "2017-01-01" ); //ISO date
	$fechaUltimaActualizacion = new DateTime( "2019-05-01" ); //ISO date
	?>

	"fechaInicial": "<?= $fechaInicial->format('Y-m-d') ?>", 
	"fechaFinaliza": "2023-01-02",
	"fechaUltimaActualizacion": "<?= $fechaUltimaActualizacion->format('Y-m-d') ?>",  <?php // ultima fecha procesada ('fecha actual') ?>

	"ultimos12mesesFechas": [
		"2018-02-28",
		"2018-03-31",
		"2018-04-30",
		"2018-05-31",
		"2018-06-30",
		"2018-07-31",
		"2018-08-31",
		"2018-09-30",
		"2018-10-31",
		"2018-11-30",
		"2018-12-31",
		"2019-01-31"
	],
	
	"desdeInicioFechas": [
		<?php
			
			$mesesDesdeInicio = 0;
			
			$start    = $fechaInicial; 
			// $start->modify('last day of this month');
			$end      = $fechaUltimaActualizacion; 
			// $end->modify('last day of this month');
			
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);
			
			$first = true;

			foreach ($period as $dt) {
				if( !$first ){ echo( " , "); };
				echo '"' .
					$dt->format('Y-m-d') .
					'" ';
				$first = false;
				$mesesDesdeInicio ++; //lo guardamos para despues generar N datos de prueba.
			};
		?>
		],
	
	"plazo": "10 años",
	"cotizacionVrus": 37.831099, 
	"quitaPorRescate": 3.14159269, 

	"productoZurich": "Zurich Invest",
	"plan": "Invest",
	"agencia": "Amparo S.A.",
	"productor": "Muñoz Benitez Alicia",
		"asegurados":[
			{
				"nombre": "Maximiliano Echeverría",
				"aseguradaSuma": "50000", <?php // Este valor sale de beneficiosIncluidosmontoPesos.valorVrus ?>
				"aseguradoSumaEqPesos": "1890000", <?php // Este valor sale de beneficiosIncluidosmontoPesos.montoPesos ?>
				"beneficiarios":[
					{
						"nombre": "María Isabel Alvarado",
						"rol": "Madre",
						"vigencia": "2010-02-01",
						"porcentaje": 57
					},
					{
						"nombre": "Carolina Barrionuevo",
						"rol": "Hermana",
						"vigencia": "2009-02-01",
						"porcentaje": 43
					}
				],
				
				<?php /* los nombres de los "beneficiosIncluidos" deben coincidir con los de static_ctnt: Coberturabeneficios, para que el apartado "Detalle de beneficios incluidos" los detalle correctamente. Los items de "beneficiosIncluidos" cuyos nombres no coincidan con static_ctnt: Coberturabeneficios, se presentarán como parte del detalle "Beneficios NO incluidos"  */ ?>
				"beneficiosIncluidos": [
					{"beneficio":"Fallecimiento", "montoPesos":1890000, "valorVrus":50000, "edadMaxima":"Sin límite"},
					{"beneficio":"Enfermedad Terminal", "montoPesos":41000, "valorVrus":800.11, "edadMaxima":"Sin límite"} ,
					{"beneficio":"Renta Familiar", "montoPesos":42000, "valorVrus":900.12, "edadMaxima":"Máximo 25 años de contratación"},
					{"beneficio":"Enfermedad Grave", "montoPesos":43000, "valorVrus":900.13, "edadMaxima":"Sin límite"},
					{"beneficio":"Exención del pago de primas", "montoPesos":43000, "valorVrus":900.13, "edadMaxima":"65"}
				],
				"beneficiosNoIncluidos": [
					{"beneficio":"Hospitalización"},
					{"beneficio":"Muerte Accidental"},
					{"beneficio":"Pérdida de miembros"},
					{"beneficio":"Accidente de aviación"},
					{"beneficio":"Invalidez total y permanente"}
				]
			},
			{
				"nombre": "Mariangeles Barrionuevo",
				"aseguradaSuma": "100000",
				"aseguradoSumaEqPesos": "3780000",
				"beneficiarios":[
					{
						"nombre": "Richardo Jorge Leiva",
						"rol": "Hermano",
						"vigencia": "2008-02-01",
						"porcentaje": 100
					}
				],
				"beneficiosIncluidos": [
					{"beneficio":"Fallecimiento", "montoPesos":3780000, "valorVrus":100000, "edadMaxima":"Sin límite"},
					{"beneficio":"Enfermedad Terminal", "montoPesos":51000, "valorVrus":1100.11, "edadMaxima":"Sin límite"} ,
					{"beneficio":"Renta Familiar", "montoPesos":52000, "valorVrus":1200.12, "edadMaxima":"Máximo 25 años de contratación"},
					{"beneficio":"Enfermedad Grave", "montoPesos":53000, "valorVrus":1300.13, "edadMaxima":"Sin límite"},
					{"beneficio":"Exención del pago de primas", "montoPesos":53000, "valorVrus":1300.13, "edadMaxima":"65"}
				],
				"beneficiosNoIncluidos": [
					{"beneficio":"Hospitalización"},
					{"beneficio":"Muerte Accidental"},
					{"beneficio":"Pérdida de miembros"},
					{"beneficio":"Accidente de aviación"},
					{"beneficio":"Invalidez total y permanente"}
				]
			}
			],

		"asistenciasIncluidas": [
			{"asistencia":"ZuriHelpYou", "link": "#"},
			{"asistencia":"ZuriHelp Mujer", "link": "#"}
		],
	

	"metodoDePago": {
		"metodo": "Tarjeta de crédito",
		"marcaTarjeta": "Visa",
		"marcaBanco": "Santander Río",
		"nroTarjeta": "2059",
		"frecuencia": "Mensual"
	},

	"condicionesParticulares": "Valor de Rescate de su Póliza es el monto al que usted tendrá derecho en caso de optar por retirarse del plan (rescindir la Póliza) y es coincidente con el valor de la Cuenta Individual. No resulta de aplicación a los contratos de seguros denominados Zurich Invest Future ninguna quita por rescate (Resolución 27.285/00 de la Superintendencia de Seguros de la Nación).",


	"cuentaIndividual": {
		"saldoPesos": 1511793,
		"saldoEqUsd": 39784,
		"variacionMesesTiempo": "12",
		"variacionMesesDato": "+2,5%",
		
		"desdeInicio":{
			"pesos": [
			<?php 
				for ($i = 0; $i < $mesesDesdeInicio; $i++) {
					echo($i*125900+113193+rand(100000,20000));
					if($i< ($mesesDesdeInicio - 1) ){ echo(","); }
				}
				?>
			]
		}
			
	},

	"pagos": {
		"acumulado": 1200000,
		"acumuladoEqUsd": 30000,
		"ultimaPrimaFecha": "2019-03-02",
		"ultimaPrimaPesos": 4283,
		"ultimaPrimaVrus": 110.08,

		"tieneSPP": true,
		"proximaPrimaFecha": "2019-07-08",
		
		"ultimos12meses":{
			"pesos": [
				<?php 
					for ($i = 0; $i < 12; $i++) {
						echo($i*95000+95000);
						if($i<11){ echo(","); }
					}
					?>
				],
			"usd": [
				<?php 
					for ($i = 0; $i < 12; $i++) {
						echo( ($i*95000+95000) / 42.84 );
						if($i<11){ echo(","); }
					}
					?>
				]
			},
		
		
		"desdeInicio":{
			"pesos": [
				<?php 
					for ($i = 0; $i < $mesesDesdeInicio; $i++) {
						echo($i*95000+95000);
						if($i<$mesesDesdeInicio-1){ echo(","); }
					}
					?>
				],
			"usd": [
				<?php 
					for ($i = 0; $i < $mesesDesdeInicio; $i++) {
						echo( ($i*95000+95000) / 45.66 );
						if($i<$mesesDesdeInicio-1){ echo(","); }
					}
					?>
				]
			},
		
		
		
		"pagosIndividuales": {
			<?php
			
			$pagosIndividualesFechas = "";
			$pagosIndividualesPesos = "";
			$pagosIndividualesVrus = "";
			
			$start    = $fechaInicial; 
			$start->modify('first day of this month');
			$end      = $fechaUltimaActualizacion; 
			
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);
			
			$first = true;
			$i = 0;

			foreach ($period as $dt) {
				if( !$first ){
					$pagosIndividualesFechas .= ( " , "); 
					$pagosIndividualesPesos .= ( " , ");
					$pagosIndividualesVrus .= ( " , ");
					};
				$pagosIndividualesFechas .= '"' . $dt->format('Y-m-d') . '" ';
				$pagosIndividualesPesos .= 5000 + $i * 100;
				$pagosIndividualesVrus .= ( 5000 + $i * 100 ) / 41.27 ;
				
				$first = false;
				$i ++;
				
			};
			
			?>
			"fechas": [ <?= $pagosIndividualesFechas ?> ],
			"pesos": [ <?= $pagosIndividualesPesos ?> ],
			"vrus": [ <?= $pagosIndividualesVrus ?> ] <?php //se usa este dato? ?>
			
			<?php
			/* sample output:
			
				    "pagosIndividuales": {
					  "fechas": [
						"2019-02-5",
						"2018-12-18",
						"2018-11-21",
						"2018-10-23",
						"2018-09-19",
						"2018-08-22",
						"2018-07-19",
						"2018-06-19",
						"2018-05-22",
						"2018-04-17",
						"2018-03-21",
						"2018-02-20"
					  ],
					  "pesos": [
						4110.5,
						4110.5,
						4110.5,
						4110.5,
						4110.5,
						4121,
						4184,
						4184,
						4184,
						4190,
						4203,
						4283
					  ],
					  "vrus": [
						30.75,
						31.03,
						32.15,
						33.15,
						33.15,
						34.76,
						34.95,
						35.15,
						35.15,
						37.83,
						37.83,
						37.83
					  ]
					},
			*/ 
			?>
		}
		
		<?php //se calcula por JavaScript:
		// , "totalPagosIndividuales":57396
		?>

	},

	"aportes": { <?php // Solamente para inversión ?>
		"acumulado": 1200000,
		"acumuladoEqUsd": 30000,
		"aporteItem":[
				{
				"fecha": "2018-02-01",
				"montoPesos": "1000000",
				"montoEqDolares": 6500,
				"cotizacionDolares": 17.38,
				"unidades": 35383,
				"detalle":[
						{
							"fondo": "Performance dolar II",
							"unidades": 24.54,
							"precioUnidad": 5.58,
							"monedaInversion": "USD",
							"porcientoAsignacion": "1,1",
							"total": 164.81
						},
						{
							"fondo": "Income dolar II",
							"unidades": 25000,
							"precioUnidad": 0.92,
							"monedaInversion": "Pesos",
							"porcientoAsignacion": "2,1",
							"total": 10088.98
						},
						{
							"fondo": "Secure dolar",
							"unidades": 75000,
							"precioUnidad": 17.26,
							"monedaInversion": "USD",
							"porcientoAsignacion": "3,1",
							"total": 16765.00
						},
						{
							"fondo": "Lump Sum dolar",
							"unidades": 50000,
							"precioUnidad": 6.42,
							"monedaInversion": "Pesos",
							"porcientoAsignacion": "4,1",
							"total": 11227.32
						}
					]
				},
				{
				"fecha": "2017-02-01",
				"montoPesos": "200000",
				"montoEqDolares": 6500,
				"cotizacionDolares": 17.39,
				"unidades": 33278,
				"detalle":[
						{
							"fondo": "Performance dolar II",
							"unidades": 24.54,
							"precioUnidad": 5.58,
							"monedaInversion": "USD",
							"porcientoAsignacion": "10,1",
							"total": 164.81
						},
						{
							"fondo": "Income dolar II",
							"unidades": 25000,
							"precioUnidad": 0.92,
							"monedaInversion": "Pesos",
							"porcientoAsignacion": "21,1",
							"total": 10088.98
						},
						{
							"fondo": "Secure dolar",
							"unidades": 75000,
							"precioUnidad": 17.26,
							"monedaInversion": "USD",
							"porcientoAsignacion": "31,1",
							"total": 16765.00
						},
						{
							"fondo": "Lump Sum dolar",
							"unidades": 50000,
							"precioUnidad": 6.42,
							"monedaInversion": "Pesos",
							"porcientoAsignacion": "41,1",
							"total": 11227.32
						}
					]
				}
			],
		
		"pagosIndividuales": { <?php // REVISAR ?>
			"fechas": [
				"2019-02-5",
				"2018-12-18",
				"2018-11-21",
				"2018-10-23",
				"2018-09-19",
				"2018-08-22",
				"2018-07-19",
				"2018-06-19",
				"2018-05-22",
				"2018-04-17",
				"2018-03-21",
				"2018-02-20"
			],
			"pesos": [
				4110.5,
				4110.5,
				4110.5,
				4110.5,
				4110.5,
				4121,
				4184,
				4184,
				4184,
				4190,
				4203,
				4283
			],
			"vrus": [
				30.75,
				31.03,
				32.15,
				33.15,
				33.15,
				34.76,
				34.95,
				35.15,
				35.15,
				37.83,
				37.83,
				37.83
			]
		}
	},

	"composicion": [
		{
			"nombre": "Performance dolar II",
			"asignacionPorcentual": "40",
			"unidades": 24.54,
			"precioUnidadUsd": 5.58,
			"totalUsd": 164.81
		},
		{
			"nombre": "Income dolar II",
			"asignacionPorcentual": "30",
			"unidades": 25000,
			"precioUnidadUsd": 0.92,
			"totalUsd": 10088.98
		},
		{
			"nombre": "Secure dolar",
			"asignacionPorcentual": "15",
			"unidades": 75000,
			"precioUnidadUsd": 17.26,
			"totalUsd": 16765
		},
		{
			"nombre": "Lump Sum dolar",
			"asignacionPorcentual": "15",
			"unidades": 50000,
			"precioUnidadUsd": 16.42,
			"totalUsd": 11227.32
		}

	],
	
	"composicionTotal": {
		"unidades": 154024.24,
		"totalUsd": 39784.11
	},

	"evolucionCuentaIndividual": [

		<?php /*
			//sample output:
			{"fecha":"2017-01-31", "acumuladoPesos": 204772, "acumuladoDolar": 4530.35398230089 },
			{"fecha":"2017-03-03", "acumuladoPesos": 281231, "acumuladoDolar": 6221.92477876106 },
			{"fecha":"2017-04-03", "acumuladoPesos": 453351, "acumuladoDolar": 10029.889380531 },
			{"fecha":"2017-05-03", "acumuladoPesos": 547156, "acumuladoDolar": 12105.2212389381 },
			{"fecha":"2017-06-03", "acumuladoPesos": 662965, "acumuladoDolar": 14667.3672566372 },
			{"fecha":"2017-07-03", "acumuladoPesos": 789020, "acumuladoDolar": 17456.1946902655 },
			{"fecha":"2017-08-03", "acumuladoPesos": 911359, "acumuladoDolar": 20162.8097345133 },
			{"fecha":"2017-09-03", "acumuladoPesos": 1053502, "acumuladoDolar": 23307.5663716814 },
			{"fecha":"2017-10-03", "acumuladoPesos": 1176490, "acumuladoDolar": 26028.5398230088 },
			{"fecha":"2017-11-03", "acumuladoPesos": 1267007, "acumuladoDolar": 28031.1283185841 },
			{"fecha":"2017-12-03", "acumuladoPesos": 1406510, "acumuladoDolar": 31117.4778761062 },
			{"fecha":"2018-01-03", "acumuladoPesos": 1562607, "acumuladoDolar": 34570.9513274336 },
			{"fecha":"2018-02-03", "acumuladoPesos": 1688249, "acumuladoDolar": 37350.6415929204 },
			{"fecha":"2018-03-03", "acumuladoPesos": 1840369, "acumuladoDolar": 40716.1283185841 },
			{"fecha":"2018-04-03", "acumuladoPesos": 1919508, "acumuladoDolar": 42466.9911504425 },
			{"fecha":"2018-05-03", "acumuladoPesos": 2046200, "acumuladoDolar": 45269.9115044248 },
			{"fecha":"2018-06-03", "acumuladoPesos": 2179715, "acumuladoDolar": 48223.7831858407 },
			{"fecha":"2018-07-03", "acumuladoPesos": 2281347, "acumuladoDolar": 50472.2787610619 },
			{"fecha":"2018-08-03", "acumuladoPesos": 2408879, "acumuladoDolar": 53293.7831858407 },
			{"fecha":"2018-09-03", "acumuladoPesos": 2562233, "acumuladoDolar": 56686.5707964602 },
			{"fecha":"2018-10-03", "acumuladoPesos": 2658226, "acumuladoDolar": 58810.3097345133 },
			{"fecha":"2018-11-03", "acumuladoPesos": 2778762, "acumuladoDolar": 61477.0353982301 },
			{"fecha":"2018-12-03", "acumuladoPesos": 2948212, "acumuladoDolar": 65225.9292035398 },
			{"fecha":"2019-01-03", "acumuladoPesos": 3036245, "acumuladoDolar": 67173.5619469027 },
			{"fecha":"2019-02-03", "acumuladoPesos": 3166963, "acumuladoDolar": 70065.5530973451 },
			{"fecha":"2019-03-03", "acumuladoPesos": 3338740, "acumuladoDolar": 73865.9292035398 },
			{"fecha":"2019-04-03", "acumuladoPesos": 3471153, "acumuladoDolar": 76795.4203539823 },
			{"fecha":"2019-05-03", "acumuladoPesos": 3579153, "acumuladoDolar": 79184.8008849558 }
		*/ ?>

		<?php
					
			$start    = $fechaInicial; 
			$end      = $fechaUltimaActualizacion; 
			
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);
			
			$first = true;
			
			$i = 0;
			foreach ($period as $dt) {
				if( !$first ){ echo( " , "); };
				echo ( '{"fecha":' ) ;
				echo '"' .
					$dt->format('Y-m-d') .
					'" ';
				echo( ', "acumuladoPesos": ' . $i * 1213 . ', "acumuladoDolar": ' . $i * 121 / 45 . ' }' );
				$i++;
				$first = false;
			};
		?>
		
	],

<?php /*
	"fondos": {
	
		"maxValue": 60, <?php // mayor valor de las series, usado como valor maximo para los graficos de todos los fondos ?>
		
		"misFondos": [
			{
			"nombre": "Performance dolar II",
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
			"nombre": "Income dolar II",
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
			"nombre": "Performance USA ST dolar",
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
	},

*/ ?>


<?php ////////INFORMACION FISCAL. Contiene la misma información que composición. Pero los datos vienen filtrados por período. /////// 

		////////INVERSIÓN. Para inversión, las fechas de pagos corresponden a los aportes.
?>

	"informacionFiscal": {
		"tenencias": [			<?php // Se armó como un array pero se muestra solo una opción (año) ?>
			{
			"periodo": 2018,
			"totalPagos": 57396,
			"fechasEimportes": [
				{"fecha": "2018-12-31","importe": 4783},
				{"fecha": "2018-11-30","importe": 4773},
				{"fecha": "2018-10-31","importe": 4793},
				{"fecha": "2018-09-30","importe": 4783},
				{"fecha": "2018-08-31","importe": 4786},
				{"fecha": "2018-07-31","importe": 4783},
				{"fecha": "2018-06-30","importe": 4783},
				{"fecha": "2018-05-31","importe": 4783},
				{"fecha": "2018-04-30","importe": 4780},
				{"fecha": "2018-03-31","importe": 4783},
				{"fecha": "2018-02-28","importe": 4783},
				{"fecha": "2018-01-31","importe": 4783}	
				],
			"totalTenencia": 215970,
			"fondos": [
					{
						"nombre": "Performance dolar II",
						"importe": 15900,
						"link": "https://zurich.com.ar/" <?php // Link al archivo ?>
					},
					{
						"nombre": "Income Dolar II",
						"importe": 15900,
						"link": "https://zurich.com.ar/"
					},
					{
						"nombre": "Secure Pesos",
						"importe": 15900,
						"link": "https://zurich.com.ar/"
					},
					{
						"nombre": "Lump Sum Pesos",
						"importe": 15900,
						"link": "https://zurich.com.ar/"
					}
				] <?php //end fodos ?>

			} <?php //end item tenencia ?>
			,

		{
			"periodo": 2017,
			"totalPagos": 41234,
			"fechasEimportes": [
				{"fecha": "2017-12-31","importe": 3783},
				{"fecha": "2017-11-30","importe": 3773},
				{"fecha": "2017-10-31","importe": 3793},
				{"fecha": "2017-09-30","importe": 3783},
				{"fecha": "2017-08-31","importe": 3786},
				{"fecha": "2017-07-31","importe": 3783},
				{"fecha": "2017-06-30","importe": 3783},
				{"fecha": "2017-05-31","importe": 3783},
				{"fecha": "2017-04-30","importe": 3780},
				{"fecha": "2017-03-31","importe": 3783},
				{"fecha": "2017-02-28","importe": 3783},
				{"fecha": "2017-01-31","importe": 3783}	
				],
			"totalTenencia": 115970,
			"fondos": [
					{
						"nombre": "Performance dolar II",
						"importe": 17201,
						"link": "https://zurich.com.ar/" <?php // Link al archivo ?>
					},
					{
						"nombre": "Income Dolar II",
						"importe": 17202,
						"link": "https://zurich.com.ar/"
					},
					{
						"nombre": "Secure Pesos",
						"importe": 17203,
						"link": "https://zurich.com.ar/"
					},
					{
						"nombre": "Lump Sum Pesos",
						"importe": 17204,
						"link": "https://zurich.com.ar/"
					}
				] <?php //end fodos ?>

			} <?php //end item tenencia ?>


			
		
		] <?php //end array tenencias ?>
		
	},

	"MisFondosVigentes":[
			{
			"nombre": "Performance Dolar*",
			"composicion": "Acciones, CEDEARs, indices y/u otros activos de renta variable relacionados con commodities (metales, granos y energia)",
			"rendimientoPonderado": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"rendimientoConservador": <?= mt_rand() / mt_getrandmax() *5 ?>,
			"composicionUrl": "files/download.php?file=PerformanceDolar"
			},
			{
			"nombre": "Lorem Ipsum**",
			"composicion": "Intrumentos de money market nominados en dólares o con cobertura de tipo de cambio y títulos de deuda pública y provada de corto plazo, principalmente en Argentina",
			"rendimientoPonderado": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"rendimientoConservador": <?= mt_rand() / mt_getrandmax() *5 ?>,
			"composicionUrl": "files/download.php?file=LoremIpsum"
			},
			{
			"nombre": "Secure dolar",
			"composicion": "Bonos del tesoro y obligaciones negociables privadas, argentinos.",
			"rendimientoPonderado": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"rendimientoConservador": <?= mt_rand() / mt_getrandmax() *5 ?>,
			"composicionUrl": "files/download.php?file=SecureDolar"
			},
			{
			"nombre": "Lump Sum dolar **",
			"composicion": "Bonos del tesoro y obligaciones negociables privadas, argentinos.",
			"rendimientoPonderado": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"rendimientoConservador": <?= mt_rand() / mt_getrandmax() *5 ?>,
			"composicionUrl": "files/download.php?file=LumpSumDolar"
			}
		],

		"OtrosFondosVigentes":[
			{
			"nombre": "Commodities dolar",
			"composicion": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id neque aliquam vestibulum morbi blandit.",
			"rendimientoPonderado": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"rendimientoConservador": <?= mt_rand() / mt_getrandmax() *5 ?>,
			"composicionUrl": "files/download.php?file=PerformanceDolar"
			},
			{
			"nombre": "Rainbow G dolar",
			"composicion": "Placerat vestibulum lectus mauris ultrices eros in cursus turpis massa.",
			"rendimientoPonderado": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"rendimientoConservador": <?= mt_rand() / mt_getrandmax() *5 ?>,
			"composicionUrl": "files/download.php?file=LoremIpsum"
			},
			{
			"nombre": "Money dolar",
			"composicion": "Id diam vel quam elementum pulvinar etiam non quam lacus.",
			"rendimientoPonderado": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"rendimientoConservador": <?= mt_rand() / mt_getrandmax() *5 ?>,
			"composicionUrl": "files/download.php?file=SecureDolar"
			},
			{
			"nombre": "Performance USA ST dolar",
			"composicion": "Massa eget egestas purus viverra accumsan in. Malesuada fames ac turpis egestas maecenas pharetra convallis.",
			"rendimientoPonderado": <?= mt_rand() / mt_getrandmax() *3 ?>,
			"rendimientoConservador": <?= mt_rand() / mt_getrandmax() *5 ?>,
			"composicionUrl": "files/download.php?file=LumpSumDolar"
			}
		]
}