<?php

// JSON de referencia para implementación.
// Dado que JSON no admite comentarios ni cálculos a modo de ejemplo, se emplea PHP a tal fin.

// Definimos locale para correr correctamente funciones de PHP para ilustrar cómo generar datos:
setlocale(LC_TIME, 'es_ES');

// Definimos fechas para cálculos simples de ejemplo
$fechaInicial = new DateTime( "2017-01-01" ); //Formato ISO date. Fecha de inicio de la poliza.
$fechaUltimaActualizacion = new DateTime( "2019-05-01" ); //Formato ISO date. Fecha de ultima actualizacion de datos.
?>{

	<?php // receipts: cada JSON de datos entrega uno o más receipts (previsión para evitar roundtrip cuando los datos ya se recibieron). ?>
	"receipts":[
		"poliza"
	],
	
	"usuario":{
		"nombre":"Juan Carlos",
		"apellido":"Barrionuevo",
		"email":"juancarlos@example.com",
		"documentoTipo":"DNI",
		"documentoNumero":"25.999.122",
		"nombreUsuario":"jcbarrionuevo",
		"particularDomicilio":"Av. Juramento 1000, Piso 1, Dpto 100",
		"particualrCP":"1000, CABA",
		"particularTel":"11 4000-1000",
		"correspondienciaDomicilio":"Av. Juramento 2000, Piso 2, Dpto 201",
		"correspondienciaCP":"2000, CABA",
		"correspondienciaTel":"11 4000-2223"
	},
	
	"numero":"246777",
	"estado":"Vigente", <?php /*
		declarar según Definición de Negocio:
			"Estados de Pólizas hoy solo se ven estos estados (otros no):
			 - Activa (A)
			 - Saldada (C)
			 - Madurada (G)
			 - Madurada con aportes(GA)"
			*/ ?>

	"producto": "OPTON", <?php //como contingencia, zurichvida.js:gZpreprocessData() sustituye algunos strings según definición de Negocio, según definición de producto Y plan. ?>
	"plan": "EASYLF", <?php //como contingencia, zurichvida.js:gZpreprocessData() sustituye algunos strings según definición de Negocio, según definición de producto Y plan. ?>

	"tipo": "ahorro", <?php
			// "tipo" define qué template principal se empleará: ahorro / inversion / proteccion / error.
			// si "tipo" se declara como string vacío, la interfaz ( zurichvida.js:gZpreprocessData() ) intentará inferirlo. Si no es posible, se considerará tipo "error" (sólo se mostrarán Gestiones y Detalle de póliza). ?>


	<?php /*
		// "productor" y "agencia": como contingencia, zurichvida.js:gZpreprocessData() sustituye algunos strings según definición de Negocio:
			// Para "productor": se sustituyen por "Zurich" cualquiera de los siguientes strings: "EAGLE STAR (ARGENTINA)", "EAGLE STAR (CESIONES ELIZALDE)", "ZILSA (VENTA DIRECTA)", "ZURICH - 116", "ZURICH - 120", "ZURICH - 121", "ZURICH - 130", "ZURICH - 150", "ZURICH - 210", "ZURICH - 651", "ZURICH - 671"
			// Para "agencia": se sustituyen por "Zurich" cualquiera de los siguientes strings: "EAGLE STAR", "ZURICH - 116", "ZURICH - 120", "ZURICH - 121", "ZURICH - 130", "ZURICH - 150", "ZURICH - 210", "ZURICH - 651", "ZURICH - 671"
		// Considerarlo casos de contingencia y cuidar de entregar a la interfaz los datos literales que corresponde presentar. */ ?>
	"productor":"EAGLE STAR (ARGENTINA)",
	"agencia":"Amparo S.A.",

	
	"fechaUltimaActualizacion": "<?= $fechaUltimaActualizacion->format('Y-m-d') ?>", <?php // fecha de ultima actualizacion de datos. formato ISO date. Ej. "fechaUltimaActualizacion":"2019-05-01", ?>
	
	"fechaInicial": "<?= $fechaInicial->format('Y-m-d') ?>", <?php // formato ISO date. Ej: "fechaInicial":"2017-01-01", ?>
		<?php //zurichvida.js:gZpreprocessData() calcula la diferencia entre fechaInicial y fechaUltimaActualizacion, y la guarda en diasDesdeFechaInicial ?>
	"fechaFinaliza": "2023-01-02", <?php //fechaFinaliza: fecha ISO. ?>
	"fechaFinalizaString": "", <?php
	/* fechaFinalizaString: si se declara string vacío, la interfaz intenta inferirlo en base a las sustituciones para "producto" y "plan". Ello no contempla todos los casos y puede caer en el default (aplicando fechaFinaliza en formato dd/mm/yyyy). Por ello, si fechaFinalizaString debe ser "Vida Entera", declararlo de esa forma; considerar la inferencia como previsión de contingencia por parte de la interfaz.
	/* Reglas de Negocio para fechaFinalizaString:
		* Si Profile / Z Invest / Z University: "Vida Entera"
		* Si Options: "Vida Entera"
		* Si Options Primas Vanishing: "Vida Entera"
		* Si Frecuencia Unica (cualquier producto): "Vida Entera"
		* Si póliza con Error / Datacheck: No aparece campo (considerado en la interfaz cuando "tipo" está declarado o inferido como "error", dado que no se muestra dato en template).
		* Default (lo realiza la interfaz si no se declaró fechaFinalizaString, y no se la pudo inferir por casos de sustitución en producto & plan): se aplica fechaFinaliza, en formato dd/mm/yyyy.
	*/ ?>
	
	"graficosResumenMostrar": true, <?php //graficosResumenMostrar: Declara si se deben mostrar o no los gráficos resumen de Cuenta Individual y Pagos en Resumen y Cuenta Individual. En principio se supone que debería haber un mínimo de tres meses de datos. Para tomar la decisión deberán evaluarse con Negocio casos con datos reales y considerar riesgos que puedan manifestarse, así como situaciones de usabilidad.  ?>
	

	"desdeInicioMensual":[
		<?php // fechas para graficos "cuenta individual" y "pagos". Formato ISO date. Ultimo día de cada mes. No deben faltar fechas dentro del rango, ni haber más de un dato por mes, sólo el último día para cada mes. ?>
		"2017-01-31",
		"2017-02-28",		
		"2017-03-31",
		"2017-04-30",
		"2017-05-31",
		"2017-06-30",
		"2017-07-31",
		"2017-08-31",
		"2017-09-30",
		"2017-10-31",
		"2017-11-30",
		"2017-12-31",
		"2018-01-31",
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
		"2019-01-31",
		"2019-02-28",
		"2019-03-31",
		"2019-04-30"
	],
	
	"plazo":"", <?php /*
		"plazo": se muestra en Resumen como "Plazo", en Detalle de Póliza como "Plazo de pago de primas".
		
		Reglas de negocio a aplicar segun producto:
	
		* Si Enterprise / Oxford  (Prima  Regular):  declarar "Años Término"
		* Si Profile / Z Invest / Z University, Options EASY LIFE  (Prima Regular): declarar "Años PPP"
		* Si Options.: (declarar string vacío)
		* Si Options Primas Vanishing : declarar "Años Vanishing"
		* Si Frecuencia Unica (cualquier producto): (declarar string vacío)
		* Si póliza con Error / Datacheck: (declarar string vacío)
	*/ ?>
	
	"cotizacionVrus": 37.831099,
	"cotizacionVrusMostrar": true, <?php /*
		cotizacionVrusMostrar: declaramos si mostrar o no cotizacionVrus en Resumen.
			Alternativamente, la interfaz ( zurichvida.js:gZpreprocessData() ) fuerza cotizacionVrusMostrar a false si cotizacionVrus se evalúa como false (false, cero, o string vacío).

		Declarar según las siguientes reglas de negocio:
		* Si póliza renegociada Vru$s muestra: MOSTRAR
		* Si póliza en Dólares: No aparece Campo
		* Si póliza  No renegociada: No aparece Campo
		* Si póliza renegociada VAL muestra:  No aparece Campo
		* Si póliza renegociada CER muestra:  No aparece Campo
		* Si póliza con Error / Datacheck: No aparece campo
		* Si póliza  Saldada: No aparece Campo
		* Si póliza  Madurada: No aparece Campo
	*/ ?>
	
	"quitaPorRescate":3.14159269,
	
	"incrementoAutomatico": 5, <?php //Si la poliza NO tiene incremento automático, declarar false. Si tiene incremento automatico, declarar valor numerico. ?>
	"pagoPrimasSuspendido": true, <?php //pagoPrimasSuspendido: declarar true o false segun corresponda. ?>

	"beneficiosValorVrusMostrar": true, <?php //Declarar si debe mostrarse o no el "valorVrus" (Valor de Referencia del beneficio (VRU$S) ). Sólo aplicar "true" para mostrar este dato cuando la "Opción de Revalorización" de la póliza sea VRU$. Definición de Negocio: hay clientes con sumas aseguradas en VRU$S (la mayoría), algunos en Pesos, otros en USD; sólo se muestra valorVrus cuando esté en VRU$S ?>
	
	"asegurados":[
		<?php /* 
			"asegurados": array de asegurados. 
			
			Reglas de Negocio para construir la data: 
			- en el array asegurados.beneficiarios, sólo declarar los registros que NO tienen “Fecha Hasta”.
			
			- Separar los beneficios en incluidos o no incluidos según los beneficios que el cliente tiene o no vigentes. 
Respecto a los no incluidos, sólo poner aquellos que el cliente podría contratar (son los que no tienen edad o tienen una edad que es mayor a la edad del asegurado).
			El listado / contenido de los beneficios, está declarado en static.json >> "Coberturabeneficios".
			Los títulos (string "beneficio") de cada uno de los beneficios incluidos y no incluidos para cada asegurado, debe coincidir exactamente con los string "beneficio" declarados en static.json.
			*/ ?>
		{
			"nombre":"Abelardo Araoz",
			"aseguradoSuma": "12345", <?php // Si no esta definido, lo infiere la interfaz tomando el de asegurados.beneficiosIncluidos["beneficio":"Fallecimiento"].valorVrus para este asegurado ?>
			"aseguradoSumaMoneda": "vrus", <?php //aseguradoSumaMoneda: 'vrus', 'usd', 'pesos'. Hay clientes con sumas aseguradas en VRU$S (la mayoría), algunos en Pesos, otros en USD. ?>
			"aseguradoSumaEqPesos":"", <?php // Si no esta definido, lo infiere la interfaz tomando el valor de asegurados.beneficiosIncluidos["beneficio":"Fallecimiento"].montoPesos para este asegurado. ?>
						
			"beneficiarios":[
				{
					"nombre":"María Isabel Alvarado",
					"rol":"Madre",
					"vigencia":"2010-02-01",
					"porcentaje":57
				},
				{
					"nombre":"Carolina Barrionuevo",
					"rol":"Hermana",
					"vigencia":"2009-02-01",
					"porcentaje":43
				}
			],
			"beneficiosIncluidos":[
				{
					"beneficio":"Fallecimiento",
					"monto":1890000,
					"valorVrus":50000, <?php //en caso se muestre el monto Y su equivalencia en VRU$S, declarar el valor en VRU$S. ?>
					"edadMaxima":"Sin límite"
				},
				{
					"beneficio":"Enfermedad Terminal",
					"monto":41000,
					"valorVrus":800.11,
					"edadMaxima":"Sin límite"
				},
				{
					"beneficio":"Renta Familiar",
					"monto":42000,
					"valorVrus":900.12,
					"edadMaxima":"Máximo 25 años de contratación"
				},
				{
					"beneficio":"Enfermedad Grave",
					"monto":43000,
					"valorVrus":900.13,
					"edadMaxima":"Sin límite"
				},
				{
					"beneficio":"Exención del pago de primas",
					"monto":"Aplicable",
					"valorVrus":"Aplicable",
					"edadMaxima":"65"
				}
			],
			"beneficiosNoIncluidos":[
				{
					"beneficio":"Hospitalización"
				},
				{
					"beneficio":"Muerte Accidental"
				},
				{
					"beneficio":"Pérdida de miembros"
				},
				{
					"beneficio":"Accidente de aviación"
				},
				{
					"beneficio":"Invalidez total y permanente"
				}
			]
		}
		<?php /* */ ?>
		,
		{
			"nombre":"Belinda Báez",
			"aseguradoSuma":"",
			"aseguradoSumaMoneda": "pesos",
			"aseguradoSumaEqPesos":"3780000",
			"beneficiarios":[
				{
					"nombre":"Richardo Jorge Leiva",
					"rol":"Hermano",
					"vigencia":"2008-02-01",
					"porcentaje":100
				}
			],
			"beneficiosIncluidos":[
				{
					"beneficio":"Fallecimiento",
					"monto":3780000,
					"valorVrus":100000,
					"edadMaxima":"Sin límite"
				},
				{
					"beneficio":"Enfermedad Terminal",
					"monto":51000,
					"valorVrus":1100.11,
					"edadMaxima":"Sin límite"
				},
				{
					"beneficio":"Renta Familiar",
					"monto":52000,
					"valorVrus":1200.12,
					"edadMaxima":"Máximo 25 años de contratación"
				},
				{
					"beneficio":"Enfermedad Grave",
					"monto":53000,
					"valorVrus":1300.13,
					"edadMaxima":"Sin límite"
				},
				{
					"beneficio":"Exención del pago de primas",
					"monto":"Aplicable", <?php //Código Beneficio: 90 - Exención al Pago de Primas. NO deberá mostrar valores en las columnas  Monto$ y Monto VRU$S (si aplicara) del beneficio. En vez de montos en esas columnas deberá aparecer la palabra "Aplicable". ?>
					"valorVrus":"Aplicable", <?php //Código Beneficio: 90 - Exención al Pago de Primas. NO deberá mostrar valores en las columnas  Monto$ y Monto VRU$S (si aplicara) del beneficio. En vez de montos en esas columnas deberá aparecer la palabra "Aplicable". ?>
					"edadMaxima":"65"
				}
			],
			"beneficiosNoIncluidos":[
				{
					"beneficio":"Hospitalización"
				},
				{
					"beneficio":"Muerte Accidental"
				},
				{
					"beneficio":"Pérdida de miembros"
				},
				{
					"beneficio":"Accidente de aviación"
				},
				{
					"beneficio":"Invalidez total y permanente"
				}
			]
		}
		<?php /* */ ?>

	],
	"asistenciasIncluidas":[
		{
			"asistencia":"ZuriHelpYou",
			"link":"#"
		},
		{
			"asistencia":"ZuriHelp Mujer",
			"link":"#"
		}
	],
	"metodoDePago":{
		"metodo":"1°Pago y Sub. con Tarjeta",
		<?php /*
			metodoDePago.metodo: como contingencia, zurichvida.js:gZpreprocessData() sustituye algunos strings según definición de Negocio:			
				"1°Pago y Sub. con Tarjeta" --> "Tarjeta de Crédito"
				"Pagos Sub. con Tarjeta" --> "Tarjeta de Crédito"
				"Debito Directo x CBU" --> "Débito en Cuenta"
				"Transferencia NY" --> "Transferencia Exterior"
				"Pago directo" --> "Transferencia Exterior"
				"Prima Unica" --> "Boleta de Depósito
			// Considerarlo casos de contingencia y cuidar de entregar a la interfaz los datos literales que corresponde presentar.
			*/ ?>
		"marcaTarjeta":"Visa", <?php //marcaTarjeta: declarar string vacio si no debe mostrarse. ?>
		

		"marcaBanco": "11", <?php /*
		marcaBanco: Declarar string vacío si no debe presentarse este dato. Como contingencia, si la interfaz recibe un string no vacío de hasta tres caracteres, ( zurichvida.js:gZpreprocessData() ) trata de inferir y sustituir por nombre de banco según regla de Negocio:
			"5": "ABN AMRO BANK N. V.",
			"7": "BANCO DE GALICIA Y BUENOS AIRES S.A.",
			"11": "BANCO DE LA NACION ARGENTINA",
			"14": "BANCO DE LA PROVINCIA DE BUENOS AIRES",
			"15": "ICBC",
			"17": "BBVA BANCO FRANCES S.A.",
			"20": "BANCO DE LA PROVINCIA DE CORDOBA S.A.",
			"27": "BANCO SUPERVIELLE S.A.",
			"29": "BANCO DE LA CIUDAD DE BUENOS AIRES",
			"34": "BANCO PATAGONIA S.A.",
			"44": "BANCO HIPOTECARIO S.A.",
			"45": "BANCO DE SAN JUAN S.A.",
			"46": "BANCO DO BRASIL S.A.",
			"60": "BANCO DEL TUCUMAN S.A.",
			"65": "BANCO MUNICIPAL DE ROSARIO",
			"72": "BANCO SANTANDER RIO S.A.",
			"79": "BANCO REGIONAL DE CUYO S.A.",
			"83": "BANCO DEL CHUBUT S.A.",
			"86": "BANCO DE SANTA CRUZ S.A.",
			"93": "BANCO DE LA PAMPA SOCIEDAD DE ECONOMIA M",
			"94": "BANCO DE CORRIENTES S.A.",
			"97": "BANCO PROVINCIA DEL NEUQUEN SOCIEDAD ANO",
			"150": "HSBC BANK ARGENTINA S.A.",
			"191": "BANCO CREDICOOP COOPERATIVO LIMITADO",
			"198": "BANCO DE VALORES S.A.",
			"259": "BANCO ITAU ARGENTINA S.A.",
			"266": "BNP PARIBAS",
			"268": "BANCO PROVINCIA DE TIERRA DEL FUEGO",
			"269": "BANCO DE LA REPUBLICA ORIENTAL DEL URUGU",
			"277": "BANCO SAENZ S.A.",
			"285": "BANCO MACRO S.A.",
			"295": "AMERICAN EXPRESS BANK LTD. SOCIEDAD ANON",
			"299": "BANCO COMAFI SOCIEDAD ANONIMA",
			"300": "BANCO DE INVERSION Y COMERCIO EXTERIOR S",
			"301": "BANCO PIANO S.A.",
			"309": "NUEVO BANCO DE LA RIOJA SOCIEDAD ANONIMA",
			"311": "NUEVO BANCO DEL CHACO S. A.",
			"315": "BANCO DE FORMOSA SA",
			"321": "BANCO DE SANTIAGO DEL ESTERO S.A.",
			"330": "NUEVO BANCO DE SANTA FE SOCIEDAD ANONIMA",
			"386": "NUEVO BANCO DE ENTRE RIOS S.A.",
			"389": "BANCO COLUMBIA S.A."
			*/ ?>
		
		<?php /*
		"marcaBanco": "Santander Río",
		*/ ?>
		
		"nroTarjetaOrCBU":"2059", 
		"nroTarjetaString": "", <?php /* 
			nroTarjetaOrCBU y nroTarjetaString:
			
			nroTarjetaOrCBU: ultimos 4 digitos de la tarjeta, o codigo CBU
			declarar string vacío si no corresponde el dato. 
				* Si campo Marca Tarjeta / Banco toma valor EXC:  No aparece Campo
				* Si campo Método de Pago toma valor "Aviso de Renovación" / "Transferencia NY": No aparece Campo
				* Si campo en blanco: No aparece Campo
			
			nroTarjetaString:
			declarar literal a mostrar en la interfaz. En caso se declare string vacío, la interfaz trata de inferirlo en base a nroTarjeta no vacío: Si nroTarjeta es numérico y de cuatro digitos, le agrega asteriscos adelante. 
			
		*/ ?>
		
		"frecuencia":"Mensual"
	},
	"condicionesParticulares":"Valor de Rescate de su Póliza es el monto al que usted tendrá derecho en caso de optar por retirarse del plan (rescindir la Póliza) y es coincidente con el valor de la Cuenta Individual. No resulta de aplicación a los contratos de seguros denominados Zurich Invest Future ninguna quita por rescate (Resolución 27.285/00 de la Superintendencia de Seguros de la Nación).",
	
	"cuentaIndividual":{
	
		"monedaInversion": "pesos", <?php //cuentaIndividual.monedaInversion = "pesos" o "usd". Depende de este valor, qué texto de modal (static.json) se muestra para "Cómo se calcula el saldo de mi cuenta individual". ?>
	
		"rescateMostrarTxt": true, <?php //cuentaIndividual.rescateMostrarTxt: declara si debe mostrarse la leyenda definida en static.json>txt.cuentaIndividualRescate. Por regla de Negocio al día de hoy, sólo corresponde declarar "true" para mostrar en productos Enterprise y Advanced. ?>
		
		"evolucionMostrarNota": true, <?php /*
			cuentaIndividual.evolucionMostrarNota:
				Declara si debe mostrarse o no, nota explicativa respecto a que "Durante los primeros años el saldo de la cuenta individual del plan contratado suele ser inferior al total de los pagos acumulados.".
				Sólo afecta a template Ahorro: Resumen.
				La regla definida por Negocio es: Sólo declarar true si CI < Total Aportes && transcurrió menos del 70% del Plazo de pago de primas.
			*/ ?>
	
	
		"saldoPesos": 1234, <?php //saldoPesos: si es cero o negativo, no se muestra el campo en Resumen, ni la solapa "Cuenta Individual"  ?>
		"saldoEqUsd":39784, <?php /*
		saldoEqUsd: Equivalente en USD. Si es cero o negativo, no se muestra el campo en Resumen.
		En caso de Inversión en Pesos, declarar como cero para que no se muestre el campo.
*/  ?>
		"variacionMesesTiempo":"12",
		"variacionMesesDato":"+2,5%",
		"desdeInicio":{
			"pesos":[]
				<?php // cuentaIndividual.desdeInicio.pesos: valores de evolución mes a mes de la cuenta individual, para gráficos. Si se declara array vacío, la interfaz ( zurichvida.js:gZpreprocessData() ) se encarga de tomar los datos de evolucionCuentaIndividual[n].acumuladoPesos.   ?>
				
		}
	},
	
	"pagos":{
		"acumulado":1200000,
		"acumuladoEqUsd":30000,
		
		"ultimaPrimaFecha":"2019-03-02", <?php //Regla de Negocio para declarar el dato: Pagos de fecha acreditación menor o igual a la de la consulta WEB ?>
		"ultimaPrimaPesos":4283, <?php //Regla de Negocio para declarar el dato: * Pagos de fecha acreditación menor o igual a la de la consulta WEB. Si U$D convierte a PESOS ?>
		"ultimaPrimaVrus":110.08, <?php //declarar string vacío si por regla de Negocio no corresponde mostrar el dato ?>
		"tieneSPP":true,
		"proximaPrimaFecha":"2019-07-08", <?php //proximaPrimaFecha: declarar siempre. Si la poliza tiene Pago de primas suspendido, declarar "fecha hasta" ?>

		"desdeInicio":{
			"pesos":[
				95000,
				190000,
				285000,
				380000,
				475000,
				570000,
				665000,
				760000,
				855000,
				950000,
				1045000,
				1140000,
				1235000,
				1330000,
				1425000,
				1520000,
				1615000,
				1710000,
				1805000,
				1900000,
				1995000,
				2090000,
				2185000,
				2280000,
				2375000,
				2470000,
				2565000,
				2660000
			],
			"usd":[
				2080.5957074025,
				4161.1914148051,
				6241.7871222076,
				8322.3828296102,
				10402.978537013,
				12483.574244415,
				14564.169951818,
				16644.76565922,
				18725.361366623,
				20805.957074025,
				22886.552781428,
				24967.14848883,
				27047.744196233,
				29128.339903636,
				31208.935611038,
				33289.531318441,
				35370.127025843,
				37450.722733246,
				39531.318440648,
				41611.914148051,
				43692.509855453,
				45773.105562856,
				47853.701270258,
				49934.296977661,
				52014.892685064,
				54095.488392466,
				56176.084099869,
				58256.679807271
			]
		},
		"pagosIndividuales":{ 
			"fechas":[ <?php //estas fechas son las puntuales de cada pago. pueden diferir respecto a desdeInicioMensual ?>
				"2017-01-01",
				"2017-02-01",
				"2017-03-01",
				"2017-04-01",
				"2017-05-01",
				"2017-06-01",
				"2017-07-01",
				"2017-08-01",
				"2017-09-01",
				"2017-10-01",
				"2017-11-01",
				"2017-12-01",
				"2018-01-01",
				"2018-02-01",
				"2018-03-01",
				"2018-04-01",
				"2018-05-01",
				"2018-06-01",
				"2018-07-01",
				"2018-08-01",
				"2018-09-01",
				"2018-10-01",
				"2018-11-01",
				"2018-12-01",
				"2019-01-01",
				"2019-02-01",
				"2019-03-01",
				"2019-04-01"
			],
			"pesos":[ <?php //monto en pesos para cada fecha declarada en pagosIndividuales.fechas  ?>
				5000,
				5100,
				5200,
				5300,
				5400,
				5500,
				5600,
				5700,
				5800,
				5900,
				6000,
				6100,
				6200,
				6300,
				6400,
				6500,
				6600,
				6700,
				6800,
				6900,
				7000,
				7100,
				7200,
				7300,
				7400,
				7500,
				7600,
				7700
			],
			"vrus":[ <?php //valor en VRU$ para cada fecha declarada en pagosIndividuales.fechas  ?>
				121.15338017931,
				123.57644778289,
				125.99951538648,
				128.42258299007,
				130.84565059365,
				133.26871819724,
				135.69178580082,
				138.11485340441,
				140.537921008,
				142.96098861158,
				145.38405621517,
				147.80712381875,
				150.23019142234,
				152.65325902593,
				155.07632662951,
				157.4993942331,
				159.92246183669,
				162.34552944027,
				164.76859704386,
				167.19166464744,
				169.61473225103,
				172.03779985462,
				174.4608674582,
				176.88393506179,
				179.30700266537,
				181.73007026896,
				184.15313787255,
				186.57620547613
			]
		}
	},
	"aportes":{
		"acumulado":1200000,
		"acumuladoEqUsd":30000,
		"aporteItem":[
			<?php // aporteItem: array con fecha, monto y demás datos de cada aporte individual. Las fechas son puntuales y no necesitan corresponderse con desdeInicioMensual. ?>
			{
				"fecha":"2018-02-01",
				"montoPesos":"1000000",
				"montoEqDolares":6500,
				"cotizacionDolares":17.38,
				"unidades":35383,
				"detalle":[
					{
						"fondo":"Performance dolar II",
						"unidades":24.54,
						"precioUnidad":5.58,
						"monedaInversion":"USD",
						"porcientoAsignacion":"1,1",
						"total":164.81
					},
					{
						"fondo":"Income dolar II",
						"unidades":25000,
						"precioUnidad":0.92,
						"monedaInversion":"Pesos",
						"porcientoAsignacion":"2,1",
						"total":10088.98
					},
					{
						"fondo":"Secure dolar",
						"unidades":75000,
						"precioUnidad":17.26,
						"monedaInversion":"USD",
						"porcientoAsignacion":"3,1",
						"total":16765.00
					},
					{
						"fondo":"Lump Sum dolar",
						"unidades":50000,
						"precioUnidad":6.42,
						"monedaInversion":"Pesos",
						"porcientoAsignacion":"4,1",
						"total":11227.32
					}
				]
			},
			{
				"fecha":"2017-02-01",
				"montoPesos":"200000",
				"montoEqDolares":6500,
				"cotizacionDolares":17.39,
				"unidades":33278,
				"detalle":[
					{
						"fondo":"Performance dolar II",
						"unidades":24.54,
						"precioUnidad":5.58,
						"monedaInversion":"USD",
						"porcientoAsignacion":"10,1",
						"total":164.81
					},
					{
						"fondo":"Income dolar II",
						"unidades":25000,
						"precioUnidad":0.92,
						"monedaInversion":"Pesos",
						"porcientoAsignacion":"21,1",
						"total":10088.98
					},
					{
						"fondo":"Secure dolar",
						"unidades":75000,
						"precioUnidad":17.26,
						"monedaInversion":"USD",
						"porcientoAsignacion":"31,1",
						"total":16765.00
					},
					{
						"fondo":"Lump Sum dolar",
						"unidades":50000,
						"precioUnidad":6.42,
						"monedaInversion":"Pesos",
						"porcientoAsignacion":"41,1",
						"total":11227.32
					}
				]
			}
		],
		"pagosIndividuales":{
			"fechas":[
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
			"pesos":[
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
			"vrus":[
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
	"composicion":[
		{
			"nombre":"Performance dolar II",
			"asignacionPorcentual":"40",
			"unidades":24.54,
			"precioUnidadUsd":5.58,
			"totalUsd":164.81
		},
		{
			"nombre":"Income dolar II",
			"asignacionPorcentual":"30",
			"unidades":25000,
			"precioUnidadUsd":0.92,
			"totalUsd":10088.98
		},
		{
			"nombre":"Secure dolar",
			"asignacionPorcentual":"15",
			"unidades":75000,
			"precioUnidadUsd":17.26,
			"totalUsd":16765
		},
		{
			"nombre":"Lump Sum dolar",
			"asignacionPorcentual":"15",
			"unidades":50000,
			"precioUnidadUsd":16.42,
			"totalUsd":11227.32
		}
	],
	"composicionTotal":{
		"unidades":154024.24,
		"totalUsd":39784.11
	},

	"evolucionCuentaIndividual":[
		<?php // Sólo se declaran los valores mes a mes para cada fecha declarada en desdeInicioMensual, para presentar en tablas. La interfaz reaplica los valores de "acumuladoPesos" en cuentaIndividual.desdeinicio.pesos. ?>
		{
			"acumuladoPesos":0,
			"acumuladoDolar":0
		},
		{
			"acumuladoPesos":-1213,
			"acumuladoDolar":2.6888888888889
		},
		{
			"acumuladoPesos":-2426,
			"acumuladoDolar":5.3777777777778
		},
		{
			"acumuladoPesos":36390,
			"acumuladoDolar":8.0666666666667
		},
		{
			"acumuladoPesos":48520,
			"acumuladoDolar":10.755555555556
		},
		{
			"acumuladoPesos":60650,
			"acumuladoDolar":13.444444444444
		},
		{
			"acumuladoPesos":72780,
			"acumuladoDolar":16.133333333333
		},
		{
			"acumuladoPesos":84910,
			"acumuladoDolar":18.822222222222
		},
		{
			"acumuladoPesos":97040,
			"acumuladoDolar":21.511111111111
		},
		{
			"acumuladoPesos":109170,
			"acumuladoDolar":24.2
		},
		{
			"acumuladoPesos":121300,
			"acumuladoDolar":26.888888888889
		},
		{
			"acumuladoPesos":1334300,
			"acumuladoDolar":29.577777777778
		},
		{
			"acumuladoPesos":1455600,
			"acumuladoDolar":32.266666666667
		},
		{
			"acumuladoPesos":1576900,
			"acumuladoDolar":34.955555555556
		},
		{
			"acumuladoPesos":1698200,
			"acumuladoDolar":37.644444444444
		},
		{
			"acumuladoPesos":18195,
			"acumuladoDolar":40.333333333333
		},
		{
			"acumuladoPesos":1940800,
			"acumuladoDolar":43.022222222222
		},
		{
			"acumuladoPesos":2062100,
			"acumuladoDolar":45.711111111111
		},
		{
			"acumuladoPesos":2183400,
			"acumuladoDolar":48.4
		},
		{
			"acumuladoPesos":2304700,
			"acumuladoDolar":51.088888888889
		},
		{
			"acumuladoPesos":2426000,
			"acumuladoDolar":53.777777777778
		},
		{
			"acumuladoPesos":2547300,
			"acumuladoDolar":56.466666666667
		},
		{
			"acumuladoPesos":2668600,
			"acumuladoDolar":59.155555555556
		},
		{
			"acumuladoPesos":2789900,
			"acumuladoDolar":61.844444444444
		},
		{
			"acumuladoPesos":-29112,
			"acumuladoDolar":64.533333333333
		},
		{
			"acumuladoPesos":-30325,
			"acumuladoDolar":67.222222222222
		},
		{
			"acumuladoPesos":3153800,
			"acumuladoDolar":69.911111111111
		},
		{
			"acumuladoPesos":3100643,
			"acumuladoDolar":72.6
		}
		
	],
	"informacionFiscal":{
		"tenencias":[
			{
				<?php // aqui se declaran para información fiscal, datos anuales y mensuales. ?>
				"periodo":2018,
				"totalPagos":57396,
				"fechasEimportes":[
					{
						"fecha":"2018-12-31",
						"importe":4783
					},
					{
						"fecha":"2018-11-30",
						"importe":4773
					},
					{
						"fecha":"2018-10-31",
						"importe":4793
					},
					{
						"fecha":"2018-09-30",
						"importe":4783
					},
					{
						"fecha":"2018-08-31",
						"importe":4786
					},
					{
						"fecha":"2018-07-31",
						"importe":4783
					},
					{
						"fecha":"2018-06-30",
						"importe":4783
					},
					{
						"fecha":"2018-05-31",
						"importe":4783
					},
					{
						"fecha":"2018-04-30",
						"importe":4780
					},
					{
						"fecha":"2018-03-31",
						"importe":4783
					},
					{
						"fecha":"2018-02-28",
						"importe":4783
					},
					{
						"fecha":"2018-01-31",
						"importe":4783
					}
				],
				"totalTenencia":215970,
				"fondos":[
					{
						"nombre":"Performance dolar II",
						"importe":15900,
						"link":"https://zurich.com.ar/"
					},
					{
						"nombre":"Income Dolar II",
						"importe":15900,
						"link":"https://zurich.com.ar/"
					},
					{
						"nombre":"Secure Pesos",
						"importe":15900,
						"link":"https://zurich.com.ar/"
					},
					{
						"nombre":"Lump Sum Pesos",
						"importe":15900,
						"link":"https://zurich.com.ar/"
					}
				]
			},
			{
				"periodo":2017,
				"totalPagos":41234,
				"fechasEimportes":[
					{
						"fecha":"2017-12-31",
						"importe":3783
					},
					{
						"fecha":"2017-11-30",
						"importe":3773
					},
					{
						"fecha":"2017-10-31",
						"importe":3793
					},
					{
						"fecha":"2017-09-30",
						"importe":3783
					},
					{
						"fecha":"2017-08-31",
						"importe":3786
					},
					{
						"fecha":"2017-07-31",
						"importe":3783
					},
					{
						"fecha":"2017-06-30",
						"importe":3783
					},
					{
						"fecha":"2017-05-31",
						"importe":3783
					},
					{
						"fecha":"2017-04-30",
						"importe":3780
					},
					{
						"fecha":"2017-03-31",
						"importe":3783
					},
					{
						"fecha":"2017-02-28",
						"importe":3783
					},
					{
						"fecha":"2017-01-31",
						"importe":3783
					}
				],
				"totalTenencia":115970,
				"fondos":[
					{
						"nombre":"Performance dolar II",
						"importe":17201,
						"link":"https://zurich.com.ar/"
					},
					{
						"nombre":"Income Dolar II",
						"importe":17202,
						"link":"https://zurich.com.ar/"
					},
					{
						"nombre":"Secure Pesos",
						"importe":17203,
						"link":"https://zurich.com.ar/"
					},
					{
						"nombre":"Lump Sum Pesos",
						"importe":17204,
						"link":"https://zurich.com.ar/"
					}
				]
			}
		]
	},
	
	<?php /*
		MisFondosVigentes: fondos aplicados a la poliza
		OtrosFondosVigentes: otros fondos vigentes, no aplicados a la poliza.
		
		Dependen de la póliza según reglas de Negocio documentadas.
	
	*/ ?>
	
	"MisFondosVigentes":[
		{
			"nombre":"Performance Dolar*",
			"composicion":"Acciones, CEDEARs, indices y/u otros activos de renta variable relacionados con commodities (metales, granos y energia)",
			"rendimientoPonderado":1.7402546586191,
			"rendimientoConservador":0.1962476946396,
			"composicionUrl":"files/download.php?file=PerformanceDolar"
		},
		{
			"nombre":"Lorem Ipsum**",
			"composicion":"Intrumentos de money market nominados en dólares o con cobertura de tipo de cambio y títulos de deuda pública y provada de corto plazo, principalmente en Argentina",
			"rendimientoPonderado":1.7773781063861,
			"rendimientoConservador":0.53801226687525,
			"composicionUrl":"files/download.php?file=LoremIpsum"
		},
		{
			"nombre":"Secure dolar",
			"composicion":"Bonos del tesoro y obligaciones negociables privadas, argentinos.",
			"rendimientoPonderado":1.276684004011,
			"rendimientoConservador":1.3622066338371,
			"composicionUrl":"files/download.php?file=SecureDolar"
		},
		{
			"nombre":"Lump Sum dolar **",
			"composicion":"Bonos del tesoro y obligaciones negociables privadas, argentinos.",
			"rendimientoPonderado":0.73638495790604,
			"rendimientoConservador":0.14478905133195,
			"composicionUrl":"files/download.php?file=LumpSumDolar"
		}
	],
	"OtrosFondosVigentes":[
		{
			"nombre":"Commodities dolar",
			"composicion":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id neque aliquam vestibulum morbi blandit.",
			"rendimientoPonderado":0.2536683502857,
			"rendimientoConservador":0.37535791535646,
			"composicionUrl":"files/download.php?file=PerformanceDolar"
		},
		{
			"nombre":"Rainbow G dolar",
			"composicion":"Placerat vestibulum lectus mauris ultrices eros in cursus turpis massa.",
			"rendimientoPonderado":1.7230411128714,
			"rendimientoConservador":3.8754966174604,
			"composicionUrl":"files/download.php?file=LoremIpsum"
		},
		{
			"nombre":"Money dolar",
			"composicion":"Id diam vel quam elementum pulvinar etiam non quam lacus.",
			"rendimientoPonderado":0.29321614340563,
			"rendimientoConservador":0.072615190908599,
			"composicionUrl":"files/download.php?file=SecureDolar"
		},
		{
			"nombre":"Performance USA ST dolar",
			"composicion":"Massa eget egestas purus viverra accumsan in. Malesuada fames ac turpis egestas maecenas pharetra convallis.",
			"rendimientoPonderado":0.62410179042448,
			"rendimientoConservador":0.67327540864855,
			"composicionUrl":"files/download.php?file=LumpSumDolar"
		}
	]
}