/* VALIDACIONES Y UTILIDADES : SIGESRHI */

$(document).ready(function(){

/***** Tooltip ******/
    var opcionestool = {
        placement: "right",  // Posicionado a la derecha
        delay: 200  // Tiempo de espera 200 milésimas de segundo
    };
    
    // Se seleccionan los elementos con clase tool
    $(".tool").tooltip(opcionestool);

/***** Validador *****/
     var opcionesVal = {lang:'es'};
              $('#seguro_form').bValidator(opcionesVal);

/***** Calendario ****/
    $('.date').datepicker({ 
              dateFormat: 'dd-mm-yy',  
              changeMonth: true,
              changeYear: true,
              yearRange: "-100:+0",});
              
              jQuery(function($){
              $.datepicker.regional['es'] = {
              closeText: 'Cerrar',
              prevText: '&#x3c;Ant',
              nextText: 'Sig&#x3e;',
              currentText: 'Hoy',
              monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
              'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
              monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
              'Jul','Ago','Sep','Oct','Nov','Dic'],
              dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
              dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
              dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
              weekHeader: 'Sm',
              dateFormat: 'dd/mm/yy',
              firstDay: 1,
              isRTL: false,
              showMonthAfterYear: false,
              yearSuffix: ''};
              $.datepicker.setDefaults($.datepicker.regional['es']);
              });

  /***** Telefono ****/
    jQuery(function ($) {
         $(".telefono").mask("99999999",{placeholder:" "});
    });

});




