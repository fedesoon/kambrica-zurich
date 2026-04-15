//kmb-horizontal-scrollable-menu.js

function horizontalMenuInit( menuULwrapper ){

	$( menuULwrapper ).find('.horizontal-menu-control-back').click(function(event) {
		event.preventDefault();
		horizontalMenuScroll( $(this), -1);
		});
	$( menuULwrapper ).find('.horizontal-menu-control-next').click(function(event) {
		event.preventDefault();
		horizontalMenuScroll( $(this).parent(), 1 );
		});

	$( menuULwrapper ).find("UL").scrollStopped(function(ev){
		horizontalMenuScrollControlsUpdate( menuULwrapper );
		});
	$(window).on('resize', function(){
		horizontalMenuScrollControlsUpdate( menuULwrapper );
		});

	//init 
	horizontalMenuScrollControlsUpdate( menuULwrapper );

}//end horizontalMenuInit


function horizontalMenuScrollControlsUpdate( context ){
	//Arguments:
	// context: wrapper DIV, or item from which to find it upwards in the DOM

	var menuULwrapper = $( context ).closest('.horizontal-menu-wrapper'); //traverse up to reach wrapper DIV
	var menuCtrlNext = $(menuULwrapper).find('.horizontal-menu-control-next');
	var menuCtrlBack = $(menuULwrapper).find('.horizontal-menu-control-back');
	
	var menuUL = $(menuULwrapper).find('.horizontal-menu');//traverse down to reach UL
	var menuLIs = $(menuUL).children("LI");
	
	var hasHorizontalMenuControls = false;

	$(menuULwrapper).removeClass( "has-horizontal-menu-controls");
	
	var menuLIsFirst = $( menuLIs ).first();
	var menuLIsLast = $( menuLIs ).last();
	
	//control "Back": ocultar si el primer LI no está completamente visible
	if( $(menuLIsFirst).offset().left >= 0 ){
		$( menuCtrlBack ).hide();
		$(menuULwrapper).removeClass('has-horizontal-menu-control-back');
	}else{
		$( menuCtrlBack ).show();
		$(menuULwrapper).addClass(' has-horizontal-menu-control-back');
		hasHorizontalMenuControls = true;
	}

	//control "Next": ocultar si el ultimo LI está completamente visible
	if( $(menuLIsLast).offset().left + $(menuLIsLast).width() <= /* ultimo pixel X del ultimo LI */
		$(menuUL).width() + $( menuUL ).offset().left + 1 /* ultimo pixel X del UL , +1 para problemas de redondeo de px. */
		){
		$( menuCtrlNext ).hide();
		$(menuULwrapper).removeClass('has-horizontal-menu-control-next');
	}else{	
		$( menuCtrlNext ).show();
		$(menuULwrapper).addClass(' has-horizontal-menu-control-next');
		hasHorizontalMenuControls = true;
	}

	$(menuULwrapper).toggleClass('has-horizontal-menu-controls', hasHorizontalMenuControls )
	
}//end horizontalMenuScrollControlsUpdate()


function horizontalMenuScroll( context, where ){

	//Procesar scroll relativo (next/back) o a un item particular dentro de un menú horizontal (overflow-x).

	//Arguments:
	// context: wrapper DIV, or item from which to find it upwards in the DOM
	// where: element to jump, OR number (1 | -1) for next/back from currently displayed. Si no esta definido, tomamos context.
	
	//Expected HTML structure:
	// wrapper . . . . . DIV.horizontal-menu-wrapper
	// > menu . . . . . . UL.horizontal-menu
	// >> menu items . . . LI
	
	//situaciones de contexto testeadas a considerar en caso de cambios:
	//- scroll-snap puede o no estar aplicado (por no estar el class, o no ser interpretado por el browser…) en cualquier caso el comportamiento del scroll debe ser razonable (ej. cuando medio item es visible por la izquierda)
	
	var where = where || context; // conditional operator

	var menuULwrapper = $( context ).closest('.horizontal-menu-wrapper'); //traverse up to reach wrapper DIV
	var menuUL = $(menuULwrapper).find('.horizontal-menu');//traverse down to reach UL
	
	var menuULscrollPaddingLeft = parseFloat ( $( menuUL ).css('scroll-padding-left') );
	if( !menuULscrollPaddingLeft ){ menuULscrollPaddingLeft = 0; }
	
	//has CSS scroll snapping?
	var menuULscrollSnap = $(menuUL).hasClass('scroll-snap-md') ? 'scroll-snap-md' : '';
	
	
	//valor actual
	var menuULscrollLeft = $(menuUL).scrollLeft(); 

	
	var menuULoffsetLeft = $( menuUL ).offset().left;
	
	var targetLI = null;

	if( typeof( where ) == "number" ){
	//si where es numero, entonces el scroll es relativo (1: proximo, -1: anterior)
		
		//buscamos proximo elemento visible ("pivot" para el scroll), 
		var pivotLI = null;
		$( menuUL ).children().each(function() {

			if ($(this).offset().left > ( menuULoffsetLeft + where*10 + menuULscrollPaddingLeft ) ) { //es el pivot! Aquí usamos el valor de "where" para resolver problemas de redondeo del valor de offsetLeft.
				pivotLI = $(this);
				return false; // breaks $.each
			}
		});
			
		if( pivotLI ){ //el elemento es valido
			targetLI = ( where == 1 ? pivotLI : pivotLI.prev() ); //para el caso de prev(), evaluaremos targetLI más adelante, don't worry
		}//end if pivotLI

	}else{
	//si where no es numero, puede ser objeto, o string… en cualquier caso intentaremos usarlo como target.
		targetLI = $(where); //evaluaremos targetLI más adelante, don't worry
	}
	
	if( $(targetLI).length == 1){ //aqui evaluamos que targetLI sea valido, y sólo avanzamos si lo es
	
		$(menuUL).
			removeClass( menuULscrollSnap ). //disable CSS scroll snapping for animation to work
			animate({
			scrollLeft: ( 
				targetLI.offset().left - menuULoffsetLeft + menuULscrollLeft - menuULscrollPaddingLeft
				 )
		}, 500, function() {
				// Animation complete.
				if( menuULscrollSnap ){ //restore CSS scroll snapping if necessary
					$(this).addClass( menuULscrollSnap );
					}
				//ocultar / mostrar prev y next según corresponda, esta asignado al evento scrollStopped.
				//si no fuera asi, corresponderia ahora: horizontalMenuScrollControlsUpdate( menuULwrapper );

			} //end fn after animation complete
		); //end .animate
	
	} //end target valido
	
	
}


// **************************************************** //

//Utility functions
//fn.scrollStopped
//http://jsfiddle.net/wtRrV/256/
$.fn.scrollStopped = function(callback) {
  var that = this, $this = $(that);
  $this.scroll(function(ev) {
    clearTimeout($this.data('scrollTimeout'));
    $this.data('scrollTimeout', setTimeout(callback.bind(that), 250, ev));
  });
};

