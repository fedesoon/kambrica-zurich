/*
called from html:
$(document).ready(function(){
	gZinit( // pasamos aqui lista de templates );
});
*/


/////////////////// variables globales  ///////////////////

// locales para representación de números y fechas
numeral.locale('es');
moment.locale('es');


/////////////////// gZ global cache / obj template ///////////////////
var gZ = { //objeto global / graphic templates y json cache
//	staticCtnt:{},
	jsoncache:{
		"receipts":[] //cada JSON de datos entrega uno o más receipts (previsión para evitar roundtrip cuando los datos ya se recibieron). Inicializamos el array para referencia.
		//… y sobre gZ.jsoncache también se cargarán (merge) sus datos.
		},
	gfx:{
		//definimos todos los colores que se emplearán para gráficos, en orden (según manual de marca):
		colors:[ "#000066","#D5CEB5","#003399","#4F90C8","#E7ECEB","#A89F96","#009EE0","#007396","#00BFB3","#E0E27C","#F69C00","#EA635C" ],
		
		//opciones por default para gráficos de linea
		line:{
			options:{

				"scales": {
					xAxes : [{
						ticks: {
    						fontFamily: "frutiger55_roman"
                		},
						gridLines : {
							display : false
						},
					} ],
					yAxes : [{
						ticks: {
							min: 0,
    						fontFamily: "frutiger55_roman",
							callback: function(label, index, labels) {
								// return '$'+label/1000+'M';
								return '$'+ ( zHelper_f( label, "123")  ); // label/1000+'M';
							},
						},
					} ]
				},

				"animation": { "duration": 0 },
				legend: { display: false },
				gridlines: { display: false },
				tooltips: {
					mode: 'index',
					bodyFontColor:'#3E3E3E',
					titleFontColor:'#3E3E3E',
					intersect: false,
					borderWidth:'1',
					backgroundColor:'rgba(250, 251, 251, 1)',
					borderColor:'rgba(240, 239, 237, 1)'
					,
					callbacks: {
						label: function(tooltipItem, data) {
							var label = data.datasets[tooltipItem.datasetIndex].label || '';
							if (label) { label += ': '; }
							label += zHelper_f( tooltipItem.yLabel, "pesos" , "$ ") ; 
							return label;
							} //label: function
						} //callbacks 

					} //tooltips
				}, //line options
			},

		//opciones por default para gráficos de torta
		pie:{
			options: {
				"scales": {},
				legend: { display: false },
				tooltips: { enabled: false },
				events: false,
				animation: { //draw values on animation onComplete function
					duration: 500,
					easing: "easeOutQuart",
					onComplete: function() {
						var ctx = this.chart.ctx;
						// ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
						ctx.font = "bold 16px frutiger55_roman"; ctx.textAlign = 'center'; ctx.textBaseline = 'bottom';
						this.data.datasets.forEach(function(dataset) {
							for (var i = 0; i < dataset.data.length; i++) {
								var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
									total = dataset._meta[Object.keys(dataset._meta)[0]].total,
									mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius) / 2,
									start_angle = model.startAngle,
									end_angle = model.endAngle,
									mid_angle = start_angle + (end_angle - start_angle) / 2;

								var x = mid_radius * Math.cos(mid_angle);
								var y = mid_radius * Math.sin(mid_angle);

								ctx.fillStyle = '#fff';
								if (i == 4) { // Darker text color for lighter background
									ctx.fillStyle = '#444';
								}
								var percent = String(Math.round(dataset.data[i] / total * 100)) + "%";
								//Don't Display If Legend is hide or value is 0
								if (dataset.data[i] != 0 /* && dataset._meta[0].data[i].hidden != true */ ) {
									// Display data:
									// ctx.fillText(dataset.data[i], model.x + x, model.y + y);
									// Display percent in another line, line break doesn't work for fillText
									// ctx.fillText(percent, model.x + x, model.y + y + 15);
									ctx.fillText(percent, model.x + x, model.y + y);
								}
							}//for i dataset.data.length
						});//this.data.datasets.forEach
					}//onComplete
				}//animation

			}//pie.options
		}//pie
	}//gfx
}; //gZ



function gZinit( tpls ){ //procesamos recursivamente el array de cosas a inicializar (obtener datos JSON, render templates, etc)
/*
	- Las fuentes de datos JSON "traban" el procesamiento hasta que carguen.
	- Se deben cargar datos JSON antes de ejecutar los templates que consumen esos datos.
	
	//usage:
	gZinit([
		["get","receipt1","file.json"], //guardar en gZ.jsoncache datos de file.json con receipt "receipt1"
		["spinner", ".7"], //reducir a .7 opacidad de fondo de spinner general
		
		["tpl", "#zurich-header", "header-inversion.htm"], //ejecutar template
		["tpl", "#panel-resumen>.main.panel", "01-inversion-resumen.htm"], //ejecutar template

		["spinner", "-1"], // spinner.hide()				
		["spinner", "-1"]  // spinner.remove()

		]);
	
*/
	var arg = tpls[0];

	var date = new Date(); var timestamp = date.getTime();
	
	switch (arg[0]){
		case "get":
		case "json":
			gZget( //gZget carga data en gZ.jsoncache
				arg[1], //receipt to test if data was already received
				arg[2], //src
				function( data ){ //callback on success
					gZnext( tpls );
						} //end callback
					);//end gZget
			break;

		case "tpl":
			$.get("templates/" + arg[2] + "?t=" + timestamp , function(value) {
				theTemplate = $.templates(value);
				var html = theTemplate.render( gZ.jsoncache ); //got html after render (no callback needed)
				$( arg[1] ).find( ".spinner,.spinnerwrapper" ).remove(); //si hay spinner, lo eliminamos
				var appendedHtml = $( arg[1] ).append( html );
				gZdrawGfx( appendedHtml ); //draw template's gfx
				gZnext( tpls );
			}); //end getFn
			break;
			
		case "spinner":
			if( arg[1] > 0){
				$('#main-spinner').css('background-color', 'rgba(255,255,255,'+ arg[1] + ')');
			}else if ( arg[1]==0 ){
				$('#main-spinner').hide();
			}else{ // arg[1] < 0
				$('#main-spinner').remove();
			}
			gZnext( tpls )
			break;

		default:
			console.log('gZinit: could not process argument [' + arg.toString() + ']' )
			gZnext( tpls )
			break;
	}

	function gZnext( tpls ){
		tpls.shift(); // removemos primer item del array
		if( tpls.length > 0 ){//quedan items por procesar
			gZinit( tpls );
		}else{
			gZinitUI(); //ya terminamos de procesar, inicializar interfaz
		}
	}

} //end gZinit





/////////////////// gZget / JSON & caching ///////////////////

function gZget( receipt, src, callback ){

	if( gZ.jsoncache.receipts[ receipt ] ){ //si ya tenemos el objeto en el cache gZ…
		callback( gZ.jsoncache ); //…ejecutamos callback sin volver a pedir data.
		
	}else{ //Si no tenemos el objeto, debemos obtenerlo por Ajax
	
		var date = new Date(); var timestamp = date.getTime();
		if(src.indexOf("?")==-1){ //agregamos timestamp
				src += ( "?gZgetTimestamp=" + timestamp );
			}else{
				src += ( "&gZgetTimestamp=" + timestamp );
			}
			
		$.getJSON( src, function( data ) { //success
		})
		  .done(function( data ) { //second success
		  
		  	data = gZpreprocessData( data ); //preprocesamos data apenas la recibimos
		  
			$.extend( true, gZ.jsoncache , data ); // Merge data into gZ.jsoncache, recursively
			// gZ.jsoncache[ receipt ] = data; //guardamos data en cache.obj
			callback( gZ.jsoncache ); //ejecutamos callback
		  })
		  .fail(function( data ) { //error
			console.log( "error" , data );
		  });
		//end $.getJSON
		
	}//else obtener obj por json

}//end gZget()



/////////////////// preprocesamos data. Esta función es llamada cada vez que se recibe un JSON de datos (fondos, poliza) ///////////////////
function gZpreprocessData( data ){


	// cuentaIndividual.desdeInicio: valores de evolución mes a mes de la cuenta individual, para gráficos. Si se declara array vacío, la interfaz ( zurichvida.js:gZpreprocessData() ) se encarga de tomar los datos de evolucionCuentaIndividual[n].acumuladoPesos.
	// Caso de contingencia: por regla de Negocio, si un valor es menor a cero, se muestra cero.
	if (
		//Barebones JS: to access deeply nested data we have to explicitly check the path:
		data["evolucionCuentaIndividual"] &&
		data["cuentaIndividual"] &&
		data["cuentaIndividual"]["desdeInicio"] && 
		data["cuentaIndividual"]["desdeInicio"]["pesos"]
		&& //Si el path es accionable, evaluamos la condición:
		data["evolucionCuentaIndividual"].length > 0 && data["cuentaIndividual"]["desdeInicio"]["pesos"].length==0 ){ //Aplicar valores de evolucionCuentaIndividual[n].acumuladoPesos a cuentaIndividual.desdeInicio
		
		//fastest way to loop through a javascript array / may 2019, Chrome: http://jsben.ch/mXh5O
		var l = data["evolucionCuentaIndividual"].length;
		for (var x = 0; x < l; x++) {
			var valor = Math.max( 0, data["evolucionCuentaIndividual"][x]["acumuladoPesos"] ); //Siempre que un valor sea menor a 0 se debe mostrar 0.
			data["evolucionCuentaIndividual"][x]["acumuladoPesos"] = valor; //reaplicamos valor con cero como mínimo en evolucionCuentaIndividual
			data["cuentaIndividual"]["desdeInicio"]["pesos"][x] = valor; //aplicamos valor en cuentaIndividual
		}//end for in data.desdeInicioMensual
		
	}//end if data["evolucionCuentaIndividual"]


	// si tenemos fechaUltimaActualizacion y fechaInicial, seteamos "diasDesdeFechaInicial" para no mostrar "Variación de mi cuenta individual en los últimos 12 meses" si la poliza no tiene al menos 1 año de antigüedad.
	if( data["fechaUltimaActualizacion"] && data["fechaInicial"] ){
	
		var now = moment( data["fechaUltimaActualizacion"] );
		var end = moment( data["fechaInicial"] ); // another date
		var duration = moment.duration(now.diff(end));
		var days = duration.asDays();
		
		data["diasDesdeFechaInicial"] = days;
	}
	//end if( data["fechaUltimaActualizacion"] && data["fechaInicial"] )



	//// Casos de contingencia: inferir tipo / producto / plan
	if ( typeof( data["tipo"] ) == "string" && !data["tipo"] ){ //si recibimos empty string para este dato, tratamos de inferirlo.
		var result = getFromCodProdPlan();
		if(!result){ //no se pudo inferir el dato
			data["tipo"] = "error";
		}else{ //dato inferido
			data["tipo"] = result[0];
		}
	}//end if data["tipo"] is empty string

	if ( data["producto"] && data["plan"] ){ //Aplicar sustitucion si corresponde
		var result = getFromCodProdPlan();
		data["producto"] = result[1];
		data["plan"] = result[2];
	}//end if data["plan"] is empty string


	//nested helper function
	function getFromCodProdPlan(){
		if ( ! data["producto"] || ! data["plan"] ) { //si no tenemos estos datos, no podemos inferir
			return false;
		}
		var codProdPlan = ( data["producto"] + "_" + data["plan"] ).toUpperCase();
		var codProdPlanTable = {
			//equivalencias codProdPlan >> 0.tipo , 1.producto, 2.plan, 3. fechaFinalizaString (solo si debe ser distinto a fechaFinaliza(d/m/a)
			"ENTPR_VIP": ["ahorro","Enterprise","Edición Limitada", false ],
			"ENTP2_JOVEN": ["ahorro","Enterprise","Joven", false ],
			"ENTPR_JOVEN": ["ahorro","Enterprise","Joven", false],
			
			"INVST_JOVEN": ["ahorro","Zurich Invest","Joven", "Vida Entera"],
			"INVST_PINVFJ": ["ahorro","Zurich Invest","Future Joven", "Vida Entera"],
			"UNIVR_PUNIV": ["ahorro","Zurich University","University", "Vida Entera"],
			"INVST_AFFENG": ["ahorro","Zurich Invest","AFFINITY ENARGAS", "Vida Entera"],
			"INVST_PINVC": ["ahorro","Zurich Invest","Classic", "Vida Entera"],
			"INVST_PINVF": ["ahorro","Zurich Invest","Future", "Vida Entera"],
			"INVST_PINVS": ["inversion","Zurich Invest","Advanced STF", "Vida Entera"],
			"INVST_PINVA": ["inversion","Zurich Invest","Advanced LT", "Vida Entera"],
			"INVST_PINVO": ["inversion","Zurich Invest","Advanced ST", "Vida Entera"],
			"OPTON_MUJER": ["proteccion","Options","Mujer", "Vida Entera"],
			"OPTON_EASYLF": ["proteccion","Options","Easy Life", "Vida Entera"],
			"OPTON_POPTN": ["proteccion","Options","Options", "Vida Entera"]

			} //end codProdPlanTable



		if( codProdPlanTable[ codProdPlan ] ){
			//si se puede hacer inferencia o sustitucion, devolvemos resultado:
			return ( codProdPlanTable[ codProdPlan ] );
		}else{
			//si no se puede hacer inferencia o sustitucion, devolvemos lo ya definido:
			return [ data["tipo"], data["producto"], data["plan"] ];
		}//end if codProdPlanTable[ codProdPlan ]
	}//end getFromCodProdPlan

	//// end Casos de contingencia: inferir tipo / producto / plan
	

	//// construir fechaFinalizaString a partir de fechaFinaliza, si aún no la tenemos
	if( data["metodoDePago"] && data["metodoDePago"]["nroTarjetaOrCBU"] && !data["metodoDePago"]["nroTarjetaString"] ){	
		if( $.isNumeric( data["metodoDePago"]["nroTarjetaOrCBU"] ) && data["metodoDePago"]["nroTarjetaOrCBU"].toString().length == 4 ){ 
			data["metodoDePago"]["nroTarjetaString"] = "**** **** " + data["metodoDePago"]["nroTarjetaOrCBU"] ;
		}else{
			data["metodoDePago"]["nroTarjetaString"] = data["metodoDePago"]["nroTarjetaOrCBU"] ;
		}
	}//end if data["fechaFinaliza"] 
	
	//// Casos de contingencia: inferir banco si marcaBanco.length es tres caracteres o menos 
	if ( data["metodoDePago"] && data["metodoDePago"]["marcaBanco"] && data["metodoDePago"]["marcaBanco"].toString().length <= 3 ){
		var result = getFromCodBanco();
		if(!result){ //no se pudo inferir el dato
			//lo dejamos como está
		}else{ //dato inferido
			data["metodoDePago"]["marcaBanco"] = result;
			//* Si campo Marca Banco toma valor por sustitucion :  No aparece N° de Tarjeta
			data["nroTarjeta"] = "";
		}
	}//end if data["plan"] is empty string
	
	//nested helper function
	function getFromCodBanco(){
		if ( ! data["metodoDePago"]["marcaBanco"] ) { //si no tenemos codigoProductoZurich y codigoPlan, no podemos inferir el dato
			return false;
		}
		var codBanco = ( data["metodoDePago"]["marcaBanco"] );
		var codBancoTable = { //equivalencias codigoBanco >> marcaBanco
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
			};
		if( codBancoTable[ codBanco ] ){
			return ( codBancoTable[ codBanco ] );
		}else{
			return false;
		}//end if	
	
	}//end getFromCodBanco
	
	//// end Casos de contingencia: inferir banco
	

	//// Casos de contingencia: inferir asegurados[n].aseguradoSuma, asegurados[n].aseguradoSumaEqPesos
	if( data["asegurados"] && data["asegurados"][0] && data["asegurados"][0]["beneficiosIncluidos"] ){
	
		//iteramos sobre cada asegurado (data.asegurados)
		//fastest way to loop through a javascript array / may 2019, Chrome: http://jsben.ch/mXh5O
		var aseguradosLen = data["asegurados"].length;
		for (var aseguradoIx = 0; aseguradoIx < aseguradosLen; aseguradoIx++) {
			var asegurado = data["asegurados"][aseguradoIx];
			
			//iteramos por cada beneficio incluido del asegurado
			var beneficiosLen = data["asegurados"][aseguradoIx]["beneficiosIncluidos"].length;
			for (var beneficioIx = 0; beneficioIx < beneficiosLen; beneficioIx++) {
			var beneficioObj = data["asegurados"][aseguradoIx]["beneficiosIncluidos"][beneficioIx];
				// beneficioObj es un elemento del array beneficiosIncluidos para cada asegurado. Ejemplo:
				// 	{
				// 		"beneficio":"Fallecimiento",
				// 		"montoPesos":1890000,
				// 		"valorVrus":50000,
				// 		"edadMaxima":"Sin límite"
				// 	}
			if( beneficioObj["beneficio"] && beneficioObj["beneficio"].toLowerCase() == "fallecimiento" ){

			//Si es necesario, aplicamos los montos de asegurados.beneficiosIncluidos["beneficio":"Fallecimiento"] a asegurados.aseguradoSuma, asegurados.aseguradoSumaEqPesos
				if( !data["asegurados"][aseguradoIx]["aseguradoSuma"] ){
					data["asegurados"][aseguradoIx]["aseguradoSuma"] = beneficioObj["valorVrus"];
				}
				if( !data["asegurados"][aseguradoIx]["aseguradoSumaEqPesos"] ){
					data["asegurados"][aseguradoIx]["aseguradoSumaEqPesos"] = beneficioObj["monto"];
				}			
			break; //una vez que encontramos asegurados.beneficiosIncluidos["beneficio":"Fallecimiento"], no necesitamos seguir buscando para este asegurado
		}//end beneficioObj.beneficio == "fallecimiento"
				
			
			}// end for in data["asegurados"][aseguradoIx]["beneficiosIncluidos"]
			
		}//end for in data["asegurados"]
		
	}//end if data.asegurados
	
	//// end Casos de contingencia: inferir asegurados.aseguradoSuma, asegurados.aseguradoSumaEqPesos
	



	//// construir fechaFinalizaString a partir de fechaFinaliza, si aún no la tenemos
	if( data["fechaFinaliza"] && !data["fechaFinalizaString"] ){	
		if( moment( data["fechaFinaliza"] ).isValid() ){ //si podemos parsear la fecha, aplicamos formato
			data["fechaFinalizaString"] = moment( data["fechaFinaliza"] ).format('D/M/Y');
		}else{ //si no podemos parsear la fecha, usamos el dato que recibimos como literal
			data["fechaFinalizaString"] = data["fechaFinaliza"];
		}
	}//end if data["fechaFinaliza"] 
	

	//// Caso de contingencia: forzamos cotizacionVrusMostrar a false si cotizacionVrus está definido pero evalúa como false (false, 0 o string vacío).
	if ( typeof( data["cotizacionVrus"] ) != "undefined" && ! data["cotizacionVrus"] ){
		data["cotizacionVrusMostrar"] = false;
	}//end if forzamos cotizacionVrusMostrar a false





	//// Casos de contingencia: sustituciones strings
	if( data["metodoDePago"] && data["metodoDePago"]["metodo"] ){ //En caso necesario, aplicamos sustituciones a string recibido.
		var needle = data["metodoDePago"]["metodo"].toLowerCase();
		var metodoDePagoTable = {
			"1°pago y sub. con tarjeta": "Tarjeta de Crédito",
			"pagos sub. con tarjeta": "Tarjeta de Crédito",
			"debito directo x cbu": "Débito en Cuenta",
			"transferencia ny": "Transferencia Exterior",
			"pago directo": "Transferencia Exterior",
			"prima unica": "Boleta de Depósito"
			}; //end metodoDePagoTable
		
		if( metodoDePagoTable[ needle ] ){
			data["metodoDePago"]["metodo"] = metodoDePagoTable[ needle ];
		}
		
	}// end if( data["metodoDePago"]["metodo"] )

		
		
	if( data["productor"] ){ //En caso necesario, aplicamos sustituciones a string recibido.
		var needle = "|" + data["productor"].toUpperCase() + "|";
		var haystack = "|EAGLE STAR (ARGENTINA)|EAGLE STAR (CESIONES ELIZALDE)|ZILSA (VENTA DIRECTA)|ZURICH - 116|ZURICH - 120|ZURICH - 121|ZURICH - 130|ZURICH - 150|ZURICH - 210|ZURICH - 651|ZURICH - 671|";
		if( haystack.indexOf( needle ) > -1 ){ data["productor"] = "Zurich"; }
	}//end if productor

	if( data["agencia"] ){ //En caso necesario, aplicamos sustituciones a string recibido.
		var needle = "|" + data["agencia"].toUpperCase() + "|";
		var haystack = "|EAGLE STAR|ZURICH - 116|ZURICH - 120|ZURICH - 121|ZURICH - 130|ZURICH - 150|ZURICH - 210|ZURICH - 651|ZURICH - 671|";
		if( haystack.indexOf( needle ) > -1 ){ data["agencia"] = "Zurich"; }
	}//end if agencia

	//// end Casos de contingencia: sustituciones strings


	//si recibimos desdeInicioMensual pero no desdeInicioMesesLabels, construimos desdeInicioMesesLabels para presentar como label de graficos
	if( data["desdeInicioMensual"] && !data["desdeInicioMesesLabels"] ){
		data["desdeInicioMesesLabels"] = [];
		
		//fastest way to loop through a javascript array / may 2019, Chrome: http://jsben.ch/mXh5O
		var l = data["desdeInicioMensual"].length;
		for (var x = 0; x < l; x++) {
			var fecha = data["desdeInicioMensual"][x];
			data["desdeInicioMesesLabels"][x] = moment( fecha ).format('DD/M/YYYY');
		}//end for in data.desdeInicioMensual
	} //end if desdeInicioMensual && !desdeInicioMesesLabels
	

	//si recibimos evolucionCuentaIndividual, aplicamos fechas de desdeInicioMensual
	if(
		( data["evolucionCuentaIndividual"] && data["desdeInicioMensual"] ) //caso 1> recibimos ambas en el mismo JSON
		|| 
		( data["evolucionCuentaIndividual"] && gZ.jsoncache["desdeInicioMensual"] ) //caso 2> recibimos evolucionCuentaIndividual ahora, desdeInicioMensual antes
		||
		( gZ.jsoncache["evolucionCuentaIndividual"] && data["desdeInicioMensual"] ) //caso 3> recibimos evolucionCuentaIndividual antes, desdeInicioMensual ahora
		){
		//fastest way to loop through a javascript array / may 2019, Chrome: http://jsben.ch/mXh5O
		var l = data["evolucionCuentaIndividual"].length;
		for (var x = 0; x < l; x++) {
			var fecha = data["desdeInicioMensual"][x];
			data["evolucionCuentaIndividual"][x]["fecha"] = fecha;
		}//end for in data.desdeInicioMensual		
	} //end if desdeInicioMensual: aplicar a evolucionCuentaIndividual
	

	

	return data;
}//end gZpreprocessData



/////////////////// draw graphics & tables ///////////////////

function gZdrawGfx(target, data) {
	// target: elemento del DOM que contiene los CANVAS cuyo class indicará qué gráfico dibujar
	// data: opcional; si no se declara usamos gZ.jsoncache

	data = data ? data : gZ.jsoncache;
	
	//////////////////////////////////////////////////////////////////////
	//draw pie chart: resumen-composicion-pie
	//////////////////////////////////////////////////////////////////////


	$.each($(target).find('CANVAS.gfx-holder.resumen-composicion-pie'), function(index, value) {

		// build from data or gZ.jsoncache
		var chartData = {
			"labels": [],
			"datasets": [{
				"type": "pie",
				"data": [],
				"backgroundColor": gZ.gfx.colors,
				"borderColor": gZ.gfx.colors
				}]
			};
	
		$.each(data.composicion, function(index, value) { //get labels from data.composicion
			chartData.labels.push(value.nombre);
			});

		$.each(data.composicion, function(index, value) { //get data from data.composicion
			chartData.datasets[0].data.push(value.asignacionPorcentual);
			});

		//draw chart
		var ctx = value.getContext('2d');
		var chart = new Chart(ctx, {
			type: 'pie', data: chartData, options: gZ.gfx.pie.options
		}); //end new Chart
		
		$(this)[0].chart = chart;

	}); //end each pie

	//resumen-composicion-pie

	
	
	//////////////////////////////////////////////////////////////////////
	//draw line chart: resumen-saldoypagos-line
	//////////////////////////////////////////////////////////////////////
	
	$.each($(target).find('CANVAS.gfx-holder.resumen-saldoypagos-line'), function(index, value) {
			
		var chartData = {
		"labels": data.desdeInicioMesesLabels,
		"datasets": [
				{
				"data": data.cuentaIndividual.desdeInicio.pesos, // data.cuentaIndividual.ultimos12meses.pesos,
				"label": "Saldo",
				"backgroundColor": gZ.gfx.colors[0],
				"borderColor": gZ.gfx.colors[0],
				"fill": false,
				"pointRadius": 4,
				"lineTension": 0,
				"type": "line"
				},
				{
				"data": data.pagos.desdeInicio.pesos, //data.pagos.ultimos12meses.pesos,
				"label": "Mis pagos",
				"backgroundColor": gZ.gfx.colors[1],
				"borderColor": gZ.gfx.colors[1],
				"fill": false,
				"pointRadius": 4,
				"lineTension": 0,
				"steppedLine": "before",
				"type": "line"
				}
			]//datasets

		}; //chartData
		
		var ctx = value.getContext('2d');
		var chart = new Chart(ctx, {
			type: 'line', data: chartData, options: gZ.gfx.line.options
		}); //end new Chart
		
		$(this)[0].chart = chart;

	}); //end each pie



	//////////////////////////////////////////////////////////////////////
	//draw line chart: resumen-saldo-line
	//////////////////////////////////////////////////////////////////////
	
	$.each($(target).find('CANVAS.gfx-holder.resumen-saldo-line'), function(index, value) {

		var chartData = {
			"labels": data.desdeInicioMesesLabels,
			"datasets": [
					{
					"data": data.cuentaIndividual.desdeInicio.pesos, // data.cuentaIndividual.ultimos12meses.pesos,
					"label": "Saldo",
					"backgroundColor": gZ.gfx.colors[0],
					"borderColor": gZ.gfx.colors[0],
					"fill": false,
					"pointRadius": 4,
					"lineTension": 0,
					"type": "line"
					}
				]//datasets

			}; //chartData
			
		var ctx = value.getContext('2d');
		var chart = new Chart(ctx, {
			type: 'line', data: chartData, options: gZ.gfx.line.options
		}); //end new Chart
		
		$(this)[0].chart = chart;

	}); //end each pie


	//////////////////////////////////////////////////////////////////////
	//draw line chart: resumen-pagos-line
	//////////////////////////////////////////////////////////////////////
	
	$.each($(target).find('CANVAS.gfx-holder.resumen-pagos-line'), function(index, value) {

		var chartData = {
		"labels": data.desdeInicioMesesLabels,
		"datasets": [
				{
				"data": data.pagos.desdeInicio.pesos, //data.pagos.ultimos12meses.pesos,
				"label": "Mis pagos",
				"backgroundColor": gZ.gfx.colors[1],
				"borderColor": gZ.gfx.colors[1],
				"fill": false,
				"pointRadius": 4,
				"lineTension": 0,
				"steppedLine": "before",
				"type": "line"
				}
			]//datasets

		}; //chartData

			
		var ctx = value.getContext('2d');
		var chart = new Chart(ctx, {
			type: 'line', data: chartData, options: gZ.gfx.line.options
		}); //end new Chart
		
		$(this)[0].chart = chart;

	}); //end each pie



	

	//////////////////////////////////////////////////////////////////////
	//draw line chart: cuentaindividual-line
	//////////////////////////////////////////////////////////////////////
	
	$.each($(target).find('CANVAS.gfx-holder.cuentaindividual-line'), function(index, value) {
	
		if( $(this)[0].chart ){ //clean up any references previously stored to the chart object within Chart.js
			$(this)[0].chart.destroy();
		}
	
		//primero vemos qué rango nos piden
		var dataRangeOption = $(this).closest(".container").find(".date-options-group.buttonselectgroup-wrapper BUTTON.active").attr('value');
		// dataRangeOption can be: ultimos12, thisyear, desdeinicio, otrafecha
		
		var fecha1 = moment(data.fechaInicial);
		var fecha2 = moment(data.fechaUltimaActualizacion);
		var validRange = true;
		
		switch ( dataRangeOption ){
			case "ultimos12":
				var fecha2year = ( fecha2 ).year();
				var fechaUltimos12 = moment(  ( fecha2year - 1 ) + fecha2.format( "-MM-DD" )  ); 
					// fechaUltimos12 = moment( fecha2 ).subtract(1, 'years'); 
				if( fechaUltimos12 >= fecha1 ){ //solo aplicamos fechaUltimos12 como fecha1 si es mayor o igual (la fecha inicial solicitada está dentro del rango de los datos)
					fecha1 = fechaUltimos12;
				}
				break;
			case "thisyear":
				var fecha1thisYear = moment( ( fecha2 ).year() + "-01-01" ); //fecha1 solicitada = primero de enero del año en curso 
				if( fecha1thisYear >= fecha1 ){ //solo aplicamos lo solicitado como fecha1, si es mayor o igual a fecha1 (inicio de datos)
					fecha1 = fecha1thisYear;
				}
				break;
			case "otrafecha":
						
				var fecha1form = moment (
					$("#cuenta-individual-custom-desde-y").val() + "-" +
					$("#cuenta-individual-custom-desde-m").val() + "-" +
					$("#cuenta-individual-custom-desde-d").val()
					);
				if( ! fecha1form.isValid() ){ validRange = false; break; }
				
				var fecha2form = moment (
					$("#cuenta-individual-custom-hasta-y").val() + "-" +
					$("#cuenta-individual-custom-hasta-m").val() + "-" +
					$("#cuenta-individual-custom-hasta-d").val()
					);
				if( ! fecha2form.isValid() ){ validRange = false; break; }
				
				if( fecha1form >= fecha1 ){ //solo aplicamos fecha1form como fecha1 si es mayor o igual (la fecha inicial solicitada está dentro del rango de los datos)
					fecha1 = fecha1form;
					}
				if( fecha2form <= fecha2 ){ //solo aplicamos fecha2form como fecha2 si es menor o igual (la fecha final solicitada está dentro del rango de los datos)
					fecha2 = fecha2form;
					}
				
				break;
				
			case "desdeinicio":
			default:
				break;
		}
		
		var dataLabels = [];
		var dataValues = [];
		
		//iteramos desdeInicioMensual para encontrar las fechas solicitadas.
		//En el proceso, mostramos u ocultamos los TRs de la tabla.
		
		$("#cuenta-individual-table TR[data-fecha]").addClass("hide");
		
		//fastest way to loop through a javascript array / may 2019, Chrome: http://jsben.ch/mXh5O
		var l = data["evolucionCuentaIndividual"].length;		
		for (var x = 0; x < l; x++) {
			var fecha = moment ( data["evolucionCuentaIndividual"][x]["fecha"] );
			
			if( fecha2 < fecha ){ 
				//si ya nos pasamos de la fecha2, terminamos
				break ;
				
			}else if( fecha1 <= fecha ){
				//si fecha está dentro del rango, la procesamos
				dataLabels.push( moment( fecha ).format('DD/M/YYYY') ); //en este caso, no podemos usar data.desdeInicioMesesLabels, por lo que debemos reprocesar la fecha en el formato a emplear en el grafico
				dataValues.push( data.cuentaIndividual.desdeInicio.pesos[x] );
				
				$("#cuenta-individual-table TR[data-fecha='"+ fecha.format("YYYY-MM-DD") +"']").removeClass("hide");
				
			} //else{ // esperando llegar a fecha1…. }
			
		}//end for in data.desdeInicioMensual
	
		if(validRange){ //solo procesamos el grafico si los valores son correctos
		
			var chartData = {
				"labels": dataLabels, //data.desdeInicioMesesLabels,
				"datasets": [
						{
						"data": dataValues, //data.cuentaIndividual.desdeInicio.pesos, 
						"label": "Saldo",
						"backgroundColor": gZ.gfx.colors[0],
						"borderColor": gZ.gfx.colors[0],
						"fill": false,
						"pointRadius": 4,
						"lineTension": 0,
						"type": "line"
						}
					]//datasets

				}; //chartData


			var ctx = value.getContext('2d');

			var chart = new Chart(ctx, {
					type: 'line',
					data: chartData,
					options: gZ.gfx.line.options
				}); //end new Chart
			
			$(this)[0].chart = chart;

		}//end if validRange

	}); //end each pie



	//////////////////////////////////////////////////////////////////////
	//draw line chart: evolucionfondos-line
	//////////////////////////////////////////////////////////////////////
		
	$.each($(target).find('CANVAS.gfx-holder.evolucionfondos-line'), function(index, value) {
	
		if( $(this)[0].chart ){ //clean up any references previously stored to the chart object within Chart.js
			$(this)[0].chart.destroy();
		}


		var queFondosSelected = $( ".secondary-navigation.evolucion-fondos A.active" ).data("source");
		var queFondos = queFondosSelected ? queFondosSelected : "misFondos";

		var fecha1 = moment(
			$( this ).closest( ".container" ).find( '[data-toggle="datepicker-fondos-desde"]' ).val() ,
			"DD/MM/YYYY"
			);
		if ( ! fecha1.isValid() ){
			fecha1 = moment(data.fechaInicial);
			}
			
		var fecha2 = moment(
			$( this ).closest( ".container" ).find( '[data-toggle="datepicker-hasta"]' ).val() ,
			"DD/MM/YYYY"
			);
		if ( ! fecha2.isValid() ){
			fecha2 = moment(data.fechaUltimaActualizacion);
			}
		
		//buscamos los indices dentro del array de fechas, que corresponderan a todos los arrays
		var ixFecha1 = null; //data.desdeInicioMesesLabels.length - 1;
		var ixFecha2 = data.desdeInicioMesesLabels.length;

		var l = data["desdeInicioMensual"].length;
		for (var x = 0; x < l; x++) {
			var fecha = moment ( data["desdeInicioMensual"][x] );
			
			if( fecha2 <= fecha ){
				//si ya nos pasamos de la fecha2, terminamos
				ixFecha2 = x ;
				break ;
				
			}else if( fecha1 <= fecha ){
				//si fecha está dentro del rango, la aplicamos
				if( ixFecha1 === null ){ ixFecha1 = x; }
								
			} //else{ // esperando llegar a fecha1…. }
			
		}//end for in data.desdeInicioMensual
		
		var chartData = {
		"labels":  data.desdeInicioMesesLabels.slice( ixFecha1, ixFecha2 ),
		"datasets": []
		}; //chartData

		var fondosCheckboxes = $("#evolucion-fondos-secondary-nav-panels .tab-pane.active UL LI :checkbox");
		for( var i=0; i<data.fondos[queFondos].length; i++ ){
		
			chartData.datasets.push( 
			{
				//"data": data.fondos.[queFondos][ i ].evolucionMisUnidades,
				"data": data.fondos[queFondos][ i ].evolucionPrecioUnidad.slice( ixFecha1, ixFecha2 ),
				"label": data.fondos[queFondos][ i ].nombre,
				"backgroundColor": gZ.gfx.colors[ i ],
				"borderColor": gZ.gfx.colors[ i ],
				"fill": false,
				"pointRadius": 4,
				"lineTension": 0,
				"type": "line",
				hidden: !( $(fondosCheckboxes[ i ]).prop( "checked" ) )
				}
			); //end push
		}//end for i > data.fondos.[queFondos]
		
		var ctxOptions = $.extend( true, {} , gZ.gfx.line.options ); // Merge data into gZ.jsoncache, recursively
	
		var ctx = value.getContext('2d');
		var chart = new Chart(ctx, {
			type: 'line',
			data: chartData,
			options: ctxOptions
		}); //end new Chart
		
		$(this)[0].chart = chart;

	}); //end each pie


	//////////////////////////////////////////////////////////////////////
	//update table: pagosindividuales
	//////////////////////////////////////////////////////////////////////
	
	$.each($(target).find('TABLE.tabla-pagosindividuales'), function(index, value) {

		var fecha1 = moment(
			$( this ).closest( ".container" ).find( '[data-toggle="datepicker-pagos-desde"]' ).val() ,
			"DD/MM/YYYY"
			);
		if ( ! fecha1.isValid() ){
			fecha1 = moment(data.fechaInicial);
			}
			
		var fecha2 = moment(
			$( this ).closest( ".container" ).find( '[data-toggle="datepicker-hasta"]' ).val() ,
			"DD/MM/YYYY"
			);
		if ( ! fecha2.isValid() ){
			fecha2 = moment(data.fechaUltimaActualizacion);
			}
		
		
		

		$(".tabla-pagosindividuales TR[data-fecha]").addClass("hide");		
		
		var sumPesos = 0; //var sumVrus = 0;
		var l = data.pagos.pagosIndividuales.fechas.length;
		for (var x = 0; x < l; x++) {
			var fecha = moment ( data.pagos.pagosIndividuales.fechas[x] );
			
			if( fecha2 <= fecha ){
				//si ya nos pasamos de la fecha2, terminamos
				break ;
				
			}else if( fecha1 <= fecha ){
				//si fecha está dentro del rango, la mostramos
				$(".tabla-pagosindividuales TR[data-fecha='"+ fecha.format("YYYY-MM-DD") +"']").removeClass("hide");
				
				//acumulamos en sum
				sumPesos += data.pagos.pagosIndividuales.pesos[x] ;
				//sumVrus += data.pagos.pagosIndividuales.vrus[x] ;
				
								
			} //else{ // esperando llegar a fecha1…. }
			
		}//end for in data.desdeInicioMensual
		
		$("#pagos-individuales-sumpesos").text( "$" + zHelper_f( sumPesos, "pesos" ) );


	}); //end each table pagosindividuales
	
	
	//////////////////////////////////////////////////////////////////////


} //gfx-holder 




/////////////////////////////////////// save Excel files ///////////////////////////////////////

 function exportArrayToCSV(args) {
 /*
	//source: 
	//	https://halistechnology.com/2015/05/28/use-javascript-to-export-your-data-as-csv/
	//	https://code-maven.com/create-and-download-csv-with-javascript
	//usage:
	//array de key/value pairs
		exportArrayToCSV(
			{
			filename: "stock-data.csv",
			data: [{Symbol: "AAPL",Company: "Apple Inc.",Price: "132.54"},{Symbol: "INTC",Company: "Intel Corporation",Price: "33.45"}]
			}
		);
	//array de arrays
	exportArrayToCSV(
			{
			filename: "foo-data.csv",
			data:  [ ['Foo', 'programmer'], ['Bar', 'bus driver'], ['Moo', 'Reindeer Hunter'] ]
			}
		);
*/
    	//usage: downloadCSV({ })
        var filename, columnDelimiter, lineDelimiter, csv;
        columnDelimiter = args.columnDelimiter || ',';
        lineDelimiter = args.lineDelimiter || '\n';

		if(args.data){
			if( typeof ( args.data[0][0] ) == "number" || typeof ( args.data[0][0] ) == "string" ){
			//tenemos un array de arrays, ej. [ ['Foo', 'programmer'], ['Bar', 'bus driver'], ['Moo', 'Reindeer Hunter'] ];
			csv = 'sep='+ columnDelimiter + lineDelimiter; //'Name,Title\n';
			// https://code-maven.com/create-and-download-csv-with-javascript
				args.data.forEach(function(row) {
						csv += row.join( columnDelimiter );
						csv += lineDelimiter ;
				});
	        
	        }else{
	        //suponemos un array de key/value pairs, ej: [{Symbol: "AAPL",Company: "Apple Inc.",Price: "132.54"},{Symbol: "INTC",Company: "Intel Corporation",Price: "33.45"}]
	        	csv = convertArrayOfObjectsToCSV({ data: args.data, columnDelimiter: columnDelimiter, lineDelimiter: lineDelimiter });
	        	
	        	if (csv == null){
	        	console.log('downloadCSV: process to csv resulted in null');
	        	return;
	        	}
	        }
	        
        }else{
        	console.log('downloadCSV: no data');
        }

        filename = args.filename || 'export.csv';
        
        downloadCSV( csv, filename );
        
    }

//	https://halistechnology.com/2015/05/28/use-javascript-to-export-your-data-as-csv/
function convertArrayOfObjectsToCSV(args) {
        var result, ctr, keys, columnDelimiter, lineDelimiter, data;

        data = args.data || null;
        if (data == null || !data.length) {
            return null;
        }

        columnDelimiter = args.columnDelimiter || ',';
        lineDelimiter = args.lineDelimiter || '\n';

        keys = Object.keys(data[0]);

		// result = '';
		result = 'sep='+ columnDelimiter + lineDelimiter;
        result += keys.join(columnDelimiter);
        result += lineDelimiter;

        data.forEach(function(item) {
            ctr = 0;
            keys.forEach(function(key) {
                if (ctr > 0) result += columnDelimiter;

                result += item[key];
                ctr++;
            });
            result += lineDelimiter;
        });

        return result;
    }



function exportTablesToCSV ( obj, filename ) {
/* usage:
	//obj: una o mas TABLAS (jquery). Si hay mas de una, se concatenan los datos.
	//filename: nombre de archivo a generar, incluyendo extension (ej. "datos.csv" )
*/
    
    var clean_text = function(text){
        text = text.replace(/"/g, '""');
        return '"'+text+'"';
    };
    
    var csv = 'sep=,\n';
    
	$(obj).each(function(){
			var title = [];
			var rows = [];

			$(this).find('TR:not(.skip-from-csv)').each(function(){ //salteamos TFOOTs
				// if( $(this).hasClass('skip-from-csv') ){ return true; } //salteamos los TRs .skip-from-csv
				var data = [];
				/*
				$(this).find('th').each(function(){
                    var text = clean_text($(this).text());
					title.push(text);
					});
					*/
				$(this).find('th:not(.skip-from-csv),td:not(.skip-from-csv)').each(function(){
                    var text = clean_text($(this).text());
					data.push(text);
					});
				data = data.join(",");
				rows.push(data);
				});
			title = title.join(",");
			rows = rows.join("\n");

			csv += title + rows + ("\n");
		});
	
	downloadCSV( csv, filename );
    
}

function downloadCSV( csvString, filename ){
//https://stackoverflow.com/questions/42462764/javascript-export-csv-encoding-utf-8-issue
	/*
	if (!csv.match(/^data:text\/csv/i)) {
		csv = 'data:text/csv;charset=utf-8,' + csv;
	}
	*/
	//data = encodeURI(csv);
	
	csvString = stripDiacritics( csvString ); //eliminamos acentos, dado que Excel no toma UTF
	
	//var universalBOM = "\uFEFF";
	var universalBOM = "";
	var link = document.createElement('a');
	link.setAttribute('href', 'data:text/csv; charset=utf-8,' + encodeURIComponent(universalBOM+csvString));
	link.setAttribute('download', filename);
	link.click();
}




/////////////////////////////////////// end save Excel files ///////////////////////////////////////



//se ejecuta esta funcion despues de parsear los templates:
function gZinitUI() {

	//habilitar procesamiento de links en boton modales
	$(".modal-content").on('click',"a[href!='']", function() {
		window.open($(this).attr('href')); 
		return false; 
	});
	
	////////////
	//datepicker: fondos y pagos
	
	var fechaInicial = new Date( gZ.jsoncache["fechaInicial"] );
	var fechaMin12 = new Date(new Date().setFullYear(new Date().getFullYear() - 1));
	var fechaHoy = new Date();

	//Ahorro-pagos
	$('[data-toggle="datepicker-pagos-desde"]').datepicker({ // Calcular 1 año atras
		date: Math.max( fechaMin12, fechaInicial ),
		autoPick: 'true', //Pick the initial date automatically when initialized
		startDate: fechaInicial,
		endDate: fechaHoy,
		language: 'es-ES',
		autoHide: true,
		zIndex: 2048,
		autoShow: true,
		inline:true,
		container:"#datepicker-pagos-desde"
	});

	//inicialmente, para Pagos mostramos los últimos 12 meses. 
	//A menos que la póliza se haya iniciado más recientemente, en cuyo caso aplicamos desde la fecha de inicio de la póliza hasta hoy.

	$('[data-toggle="datepicker-fondos-desde"]').datepicker({
		date: fechaInicial,
		autoPick: 'true', //Pick the initial date automatically when initialized
		startDate: fechaInicial, //null, //All the dates before this date will be disabled
		endDate: fechaHoy, //All the dates after this date will be disabled
		language: 'es-ES',
		autoHide: true,
		zIndex: 2048
	});

	$('[data-toggle="datepicker-hasta"]').datepicker({
		date: null, //use current date by default
		autoPick: 'true', //Pick the initial date automatically when initialized
		startDate: fechaInicial,
		endDate: fechaHoy, //All the dates after this date will be disabled
		language: 'es-ES',
		autoHide: true,
		zIndex: 2048
	});

	//Con las fechas ya aplicadas, inicializamos filtrado de tabla de pagos.
	//Si bien debería haber un solo item para la expresión, usamos each() por las dudas.
	$('[data-toggle="datepicker-pagos-desde"]').each(function( index ) {
		gZdrawGfx( $( this ).closest( ".container" ) );
	});

	$('MAIN').on('change', "[data-toggle*='datepicker']", function( e ) { //procesar cambios de fecha datepicker
		gZdrawGfx( $( this ).closest( ".container" ) ); //actualizar graficos
	}); //end links con cambio de tab
	

	



/* Vuelve sccrolleable las tablas */

  $(".resumen-table").each(function() {
    $(this).clone(true).appendTo('.resumen-table-scroll').addClass('clone');
  });

// Cuenta indivisual

  $(".cuenta-individual-table").each(function() {
    $(this).clone(true).appendTo('.cuenta-individual-table-scroll').addClass('clone');
  });

// Aportes


   $(".aportes-table-1").clone(true).appendTo('.aportes-table-scroll-1').addClass('clone');


  $(".aportes-table-2").each(function() {
    $(this).clone(true).appendTo('.aportes-table-scroll-2').addClass('clone');
  });

// fondos
  $(".fondos-table-op1-1").each(function() {
    $(this).clone(true).appendTo('.fondos-table-scroll-op1-1').addClass('clone');
  });
  $(".fondos-table-op1-2").each(function() {
    $(this).clone(true).appendTo('.fondos-table-scroll-op1-2').addClass('clone');
  });
  $(".fondos-table-op1-3").each(function() {
    $(this).clone(true).appendTo('.fondos-table-scroll-op1-3').addClass('clone');
  });
  $(".fondos-table-op1-4").each(function() {
    $(this).clone(true).appendTo('.fondos-table-scroll-op1-4').addClass('clone');
  });
  $(".fondos-table-op2-1").each(function() {
    $(this).clone(true).appendTo('.fondos-table-scroll-op2-1').addClass('clone');
  });
  $(".fondos-table-op2-2").each(function() {
    $(this).clone(true).appendTo('.fondos-table-scroll-op2-2').addClass('clone');
  });
  $(".fondos-table-op2-3").each(function() {
    $(this).clone(true).appendTo('.fondos-table-scroll-op2-3').addClass('clone');
  });
  $(".fondos-table-op2-4").each(function() {
    $(this).clone(true).appendTo('.fondos-table-scroll-op2-4').addClass('clone');
  });

  $(".beneficios-table").each(function() {
    $(this).clone(true).appendTo('.beneficios-table-scroll').addClass('clone');
  });

/* End clone tables */






  //$('#main-nav-tabs a[href="#panel2"]').tab('show');

    /* Cambia el ancho de las columnas en ahorro resumen */
  $('#myTab-graph-view a.tab1').on('click', function (e) {
    e.preventDefault();
    $('.resume-change-col-1').addClass('col-lg-4').removeClass('col-lg-6');
    $('.resume-change-col-2').addClass('col-lg-8').removeClass('col-lg-6');
  });
  $('#myTab-graph-view a.tab2').on('click', function (e) {
    e.preventDefault();
    $('.resume-change-col-1').addClass('col-lg-6').removeClass('col-lg-4');
    $('.resume-change-col-2').addClass('col-lg-6').removeClass('col-lg-8');
  });

  // Hace visible el formulario de OTRAS FECHAS
  // TODO: hacerlo generico por clases en lugar de por IDs
  $( "#btn-otras-fechas" ).on('click', function (e) {
    $( "#form-otras-fechas" ).toggle();
  });
  $( ".close-form-dates" ).on('click', function (e) {
    $( "#form-otras-fechas" ).toggle();
  });

  $( "#btn-otras-fechas-fondos" ).on('click', function (e) {
    $( "#form-otras-fechas-fondos" ).toggle();
  });

  $( "#btn-otras-fechas2" ).on('click', function (e) {
    $( "#form-otras-fechas2" ).toggle();
  });
  $( "#btn-otras-fechas-fondos2" ).on('click', function (e) {
    $( "#form-otras-fechas-fondos2" ).toggle();
  });


  // Button group mantiene seleccionado el botón activo 
  $(".btn-group > .btn").on('click', function (e) {
    $(".btn-group > .btn").removeClass("active");
    $(this).addClass("active");
  });


  // Collapse ver mas y cambiar el texto
  // TODO: hacerlo generico por clases en lugar de por IDs
  /*

  $('.crop-text-see-more').on('hidden.bs.collapse', function () {
    $('#crop-text-see-more span').text('Ver más');
  });
  $('.crop-text-see-more').on('shown.bs.collapse', function () {
    $('#crop-text-see-more span').text('Ver más');
  });
  $('.crop-text-read-more').on('hidden.bs.collapse', function () {
    $('#crop-text-read-more span').text('Leer más');
  });
  $('.crop-text-read-more').on('shown.bs.collapse', function () {
    $('#crop-text-read-more span').text('Leer más');
  });
  $('.crop-text-1').on('hidden.bs.collapse', function () {
    $('#crop-text-1 span').text('Leer más');
  });
  $('.crop-text-1').on('shown.bs.collapse', function () {
    $('#crop-text-1 span').text('Leer más');
  });
*/


//contenido en Modal
$('HTML').on('click', '[data-modalcontent]', function( e ) { 
	var modalcontent = gZ.jsoncache.modal[ $( this ).data('modalcontent') ];
	var modalobj = $( this ).data('target'); // data-target="#modal-default" 
	
	$(modalobj).find('.modal-title').html( modalcontent.titulo );
	$(modalobj).find('.modal-body').html( modalcontent.body );
  $(modalobj).find('.modal-footer').html( modalcontent.footer );
  }); //end links con cambio de tab
  
  

  // links con cambio de tab
  $('MAIN').on('click', '[data-toggle="tab"]', function( e ) { //solo aplica a contenido, la barra de navegacion esta en header y no es afectada

  	$(this).removeClass('active'); //evitamos que el link se convierta en activo y por ende, no se pueda volver a clickear
	$('HEADER .main-navigation #main-nav-tabs A.active').removeClass('active'); //evitamos que quede activo punto de menú anterior

    var chref = $(this).attr('href'); //atributo href al que se le hizo click
    var menuitem = $('HEADER .main-navigation [href$="' + chref + '"]'); //menu item con mismo href


    if(menuitem.length>0){ //existe el menu item
		$(menuitem).addClass('active');
		scrollTo($("BODY"), 1);
		// scrollTo(menuitem, 1);
    }else{
    	// scrollTo( $('main'), 1 );
    }



  }); //end links con cambio de tab


  //"click outside" events
  $('body').on('click', function (e) {
  //https://jsfiddle.net/mattdlockyer/C5GBU/2/
    //cerrar popovers on click outside
    $('[data-toggle="popover"]').each(function () {
      //the 'is' for buttons that trigger popups
      //the 'has' for icons within a button that triggers a popup
      if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
        $(this).popover('hide');
      }
    }); //end $('[data-toggle="popover"]').each
  
    //cerrar card fechas on click outside

  //     $('#form-otras-fechas').each(function () {
  //      $target = $(e.target);      
  //      if( !$target.closest($(this)).length && 
  //          !$target.closest($('#btn-otras-fechas')).length &&
  //        $( this ).is(":visible")) {
  //        $( this ).hide();
  //      }
  //     }); //end $('.card-form-dates').each

    //  $('#form-otras-fechas').each(function () {
    // TODO: hacer generico por clases
        if( ! $(e.target).closest($('#form-otras-fechas')).length && 
          !$(e.target).closest($('#btn-otras-fechas')).length &&
          $( '#form-otras-fechas' ).is(":visible")) {
          $( '#form-otras-fechas' ).hide();
          $('.btn-dropdown-icon').removeClass('open-icon', true); //Roman
        }
    //  }); //end $('.card-form-dates').each
  
  });//end $('body').on('click')


//sync button group seleccion fechas >> select
//  $('.buttonselectgroup-wrapper .buttonselectgroup-buttons button').on('click', function (e) {
$('MAIN').on('click', '.buttonselectgroup-wrapper .buttonselectgroup-buttons button', function (e) {
    var wrapper = $(this).closest('.buttonselectgroup-wrapper');
    var value = ( $( this ).attr('value') );
      $(wrapper).find('.btn-group button').removeClass('active');
      $(this).addClass('active');
    $(wrapper).find('select option[value="' + value + '"]').prop('selected', true);
    $(wrapper).find('.btn-dropdown-icon').addClass('open-icon', true); 
    $(wrapper).find( ".buttonselectgroup-form" ).toggle( ( value == 'otrafecha' ) );
    
    if( value != "otrafecha" ){
	    gZdrawGfx( $( this ).closest( ".container" ) ); //actualizar graficos
	    }
  });

//  $('.buttonselectgroup-wrapper .buttonselectgroup-select').on('change', function (e) {
  $("MAIN").on('change', '.buttonselectgroup-wrapper .buttonselectgroup-select', function (e) {
    var wrapper = $(this).closest('.buttonselectgroup-wrapper');
    var value = ( $( this ).val() );
    $(wrapper).find('.btn-group button').removeClass('active').filter('[value="' + value + '"]').addClass('active');
    //$(wrapper).find('.btn-group button[value="' + value + '"]').addClass('active');
    
    //abrir o cerrar box otras fechas
//    var verOtrasFechas = ( value == 'otrafecha' );
    //$( "#form-otras-fechas" ).toggle( ( value == 'otrafecha' ) );
    $(wrapper).find( ".buttonselectgroup-form" ).toggle( ( value == 'otrafecha' ) );

	if( value != "otrafecha" ){
		gZdrawGfx( $( this ).closest( ".container" ) ); //actualizar graficos
	    }
  });

//al hacer click en submit de subform "otra fecha" actualizar graficos y cerrar form
$('MAIN').on('click', '#cuenta-individual-custom-submit', function (e) {
	$(this).closest( ".buttonselectgroup-form" ).toggle( );
	gZdrawGfx( $( this ).closest( ".container" ) ); //actualizar graficos
  });


//mostrar evolucion fiscal por periodo
$("MAIN").on('change', '#informacion-fiscal-periodo-select', function (e) {
	var periodo = ( $(this).val() );
	$("DIV.informacion-fiscal-periodo[data-year='" + periodo + "']").show();
	$("DIV.informacion-fiscal-periodo[data-year!='" + periodo + "']").hide();
});

//evolucion fondos: reprocesar graficos al cambiar source (misFondos / otrosFondos ) o checks
/*
$(document).on("click touchend", ".class1, .class2, .class3", function () {
$('MAIN').on('click', '#cuenta-individual-custom-submit', function (e) {
$.each($(target).find('CANVAS.gfx-holder.evolucionfondos-line'), function(index, value) {

secondary-navigation evolucion-fondos
tab-content evolucion-fondos
*/
//$('MAIN').on('click', '.secondary-navigation.evolucion-fondos A, .tab-content.evolucion-fondos :checkbox', function (e) {
$('MAIN').on('click', '.tab-content.evolucion-fondos :checkbox', function (e) {
	gZdrawGfx( $( this ).closest( ".container" ) ); //actualizar graficos
  });

$('#evolucion-fondos-secondary-nav-tabs a').on('shown.bs.tab', function(event){
	gZdrawGfx( $( this ).closest( ".container" ) ); //actualizar graficos
});



//links "descargar excel"
$('MAIN').on('click', '[data-savefile]', function (e) {
	e.preventDefault();
	var filename = $( this ).data("savefile");
	var saveobj = $( this ).data("saveobj");
	var obj;
	
	switch( saveobj ){
		case "cuentaindividual":
			obj = $("#cuenta-individual-table"); //(this).closest("container").find("")
			exportTablesToCSV( obj, filename );
			break;
		case "historialpagos":
			obj = $(".tabla-pagosindividuales");
			exportTablesToCSV( obj, filename );
			break;
		case "informacionfiscal":
			obj = $(".tabla-informacion-fiscal:visible"); //bajamos la unica tabla visible
			filename = filename.replace("YYYY", $("#informacion-fiscal-periodo-select").val() );
			exportTablesToCSV( obj, filename );
			break;
		case "evolucionfondos":
//			var data = [ ['Foo', 'programmer'], ['Bar', 'bus driver'], ['Moo', 'Reindeer Hunter'] ];

			var data = [];
			
			//construimos header rows
			
			//header row1: Mis Fondos vs. Otros Fondos
			var dataRow = [ "", "Mis Fondos" ] ;
			var fl = gZ.jsoncache.fondos.misFondos.length - 1;
				for (var y = 0; y < fl; y++) { //for y in misFondos
					dataRow.push( "" );
				}; //end y in misFondos
			dataRow.push("", "Otros Fondos"); //separamos misFondos de otrosFondos
			var fl = gZ.jsoncache.fondos.otrosFondos.length -1;
				for (var y = 0; y < fl; y++) { //for y in misFondos
					dataRow.push( "" );
				}; //end y in misFondos
			data.push( dataRow );
			
			//header row 2: nombre de cada fondo	
			var dataRow = [ "fecha" ] ;
			var fl = gZ.jsoncache.fondos.misFondos.length;
				for (var y = 0; y < fl; y++) { //for y in misFondos
					dataRow.push( gZ.jsoncache.fondos.misFondos[y].nombre );
				}; //end y in misFondos			
			dataRow.push(""); //separamos misFondos de otrosFondos
			var fl = gZ.jsoncache.fondos.otrosFondos.length;
				for (var y = 0; y < fl; y++) { //for y in misFondos
					dataRow.push( gZ.jsoncache.fondos.otrosFondos[y].nombre );
				}; //end y in misFondos
			data.push( dataRow );
			
			//construimos data rows
			var l = gZ.jsoncache["desdeInicioMensual"].length;
			for (var x = 0; x < l; x++) {
				var dataRow = [ gZ.jsoncache["desdeInicioMensual"][x] ] ;
				
				var fl = gZ.jsoncache.fondos.misFondos.length;
				for (var y = 0; y < fl; y++) { //for y in misFondos
					var valor = gZ.jsoncache.fondos.misFondos[y].evolucionPrecioUnidad[x];
					if(typeof(valor)=="undefined"){ valor = "-"; }
					dataRow.push( valor );
				}; //end y in misFondos
				
				dataRow.push(""); //separamos misFondos de otrosFondos
				
				var fl = gZ.jsoncache.fondos.otrosFondos.length;
				for (var y = 0; y < fl; y++) { //for y in misFondos
					var valor = gZ.jsoncache.fondos.otrosFondos[y].evolucionPrecioUnidad[x];
					if(typeof(valor)=="undefined"){ valor = "-"; }
					dataRow.push( valor );
				}; //end y in otrosFondos
				
				data.push( dataRow );
			
			}//end for in data.desdeInicioMensual


			exportArrayToCSV( {
				filename: filename,
				data: data
				}
				);
			break;

/*

	exportArrayToCSV(
			{
			filename: "foo-data.csv",
			data:  [ ['Foo', 'programmer'], ['Bar', 'bus driver'], ['Moo', 'Reindeer Hunter'] ]
			}
		);


*/

		case "":
		default:
			break;
	}
	
  });
  

//form modal cambiar email de usuario
//$(document).on('submit','#usuario-nuevo-email',function(){
$("#usuario-nuevo-email BUTTON").on("click", function(e) {
console.log('submit #usuario-nuevo-email');
e.preventDefault();
	var targetURL = "json/cambiaremail.php";
	$.ajax({
	   type: "POST",
	   url: targetURL,
	   async: false,
	   data: JSON.stringify($(this).find('FORM').serializeArray()),
	   success: function(data){
			if(data=="" || data=="OK"){
				//OK, ocultamos modal
				$('#usuario-nuevo-email').modal('hide');
			}else{
				//Error, dejamos modal abierto (return false al final de la funcion)
				console.log( 'err', this, data );
				$('#usuario-nuevo-email .error').text( data );
			return false;
			}
	   
		  console.log('success', data);
		  return true;
	   },
	   complete: function() {},
	   error: function(xhr, textStatus, errorThrown) {
		 console.log('ajax loading error...');
		 return false;
	   }
	});

});



  // Inicializar popovers
  $('[data-toggle="popover"]').popover();

  // Activa el scroll con flechas
  //makeTablesScrollable();

	horizontalMenuInit( ('.horizontal-menu-wrapper') );

// Solamente en movil (no desktop achicado), mostrar table-scroll-shadow agregandolo a los .table-scroll
// OK aplicar esta propiedad siempre que sea touch
if( true ){ // is_touch_device() ){
// if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ){ 
 $('body').find('.table-scroll').addClass('table-scroll-shadow');}


if( is_touch_device() ){
	$('body').find('.table-scroll').addClass('table-scroll-shadow');
}


} //end gZinitUI


/////////////////// jsRender helpers ///////////////////

var myHelpers = {
	f: zHelper_f,
	bgColor: zHelper_bgColor
	};
$.views.helpers(myHelpers);

function zHelper_bgColor( ix ){
	return ( gZ.gfx.colors[ix] );
}//zHelper_bgColor

function zHelper_f( value, format, optionalBefore, optionalAfter, ifNotNumeric ) {
	var a = optionalBefore ? optionalBefore : "";
	var z = optionalAfter ? optionalAfter : "";
	var ifNotNumeric = ifNotNumeric ? ifNotNumeric : value ;
	
	// si "a" (optionalBefore) == "format", inferimos legend a mostrar en base a "format".
	if(a=="format"){
		switch( format ){
			case "pesos":
				a = "$ ";
				break;
			case "usd":
				a = "USD ";
				break;
			case "vrus":
				a = "VRU$S ";
				break;
			default:
				console.log ("zHelper_f: no se pudo inferir optionalBefore para 'format' (" + format + ")", value, format, optionalBefore );
				a = "";
		}//switch( format )
	}//if(a=="format")
	
	// if( !jQuery.isNumeric(value) ){ //isNumeric devuelve false para fechas ISO…
	if( ! ( /^[\d|\.|-]+$/g.test( value ) ) ){//…así que aplicamos regex
		return ifNotNumeric;
	}
	
	switch( format ){
		case "pesos":
		case "123":
			return ( a + numeral( value ).format('0,0') + z );
			break;
		case "usd":
		case "vrus":
		case "123.45":
			return ( a + numeral( value ).format('0,0.00') + z );
			break;
		case "123.4567":
			return ( a + numeral( value ).format('0,0.0000') + z );
			break;
		case "123.456":
			return ( a + numeral( value ).format('0,0.000') + z );
			break;
		
		case "d/m/a":
			return ( a + moment( value ).format('D/M/Y') + z );
			break;
		case "m/a":
			return ( a + moment( value ).format('M/Y') + z );
			break;
		case "d mmm a": //31 Mar 2018
			return ( a + moment( value ).format('D MMM Y') + z );
			break;
		case "d mmmm a": //31 Marzo 2018
			return ( a + moment( value ).format('D MMMM Y') + z );
			break;
						
		default:
			return ( value );
  	} //switch( format )
}//zHelper_f


// utility functions

function is_touch_device() {
  var prefixes = ' -webkit- -moz- -o- -ms- '.split(' ');
  var mq = function(query) {
    return window.matchMedia(query).matches;
  };

  if (('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
    return true;
  }

  // include the 'heartz' as a way to have a non matching MQ to help terminate the join
  // https://git.io/vznFH
  var query = ['(', prefixes.join('touch-enabled),('), 'heartz', ')'].join('');
  return mq(query);
}

function scrollTo(elm, msecs ){
	msecs = msecs ? msecs : 0;
  $('html, body').animate({
    scrollTop: ($(elm).offset().top)
  },msecs);
}


function stripDiacritics( replaceString ){
	var regex;
	var find = "áéíóúüñÁÉÍÓÚÜÑ";
	var replace = "aeiouunAEIOUUN";//[ "&lt;", "&gt;", "<br/>" ];
	for (var i = 0; i < find.length; i++) {
		regex = new RegExp(find[i], "g");
		replaceString = replaceString.replace(regex, replace[i]);
		}
	return replaceString;
}

/////////////////// detect if ie  ///////////////////

if (navigator.appVersion.indexOf('MSIE 10') !== -1) {
  $('body').addClass('ie-css');
}
if (window.MSInputMethodContext && !!document.documentMode) {
  $('body').addClass('ie-css');
}