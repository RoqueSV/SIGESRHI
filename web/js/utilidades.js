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
              $('form').bValidator(opcionesVal);

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

    $('.datenr').datepicker({ 
              dateFormat: 'dd-mm-yy',  
              changeMonth: true,
              changeYear: true,
              yearRange: "-100:+2",});

  /***** Validaciones de máscara ****/
    $(".telefono").mask("99999999",{placeholder:""});
    $(".isss").mask("999999999",{placeholder:""});
    $(".nup").mask("999999999999",{placeholder:""});
    $(".nip").mask("9999999",{placeholder:""});
    $(".dui").mask("999999999",{placeholder:""});
    $(".nit").mask("99999999999999",{placeholder:""});
    
    
/******** Validacion con MaskMoney ***************/
    $(".dinero").maskMoney({thousands:'', decimal:'.'});
  


  /**** Ayuda *******/
    var opcioneshelp = {
        show: false,  // Mostrar sólo por medio del boton
        keyboard: false  // Desactivar el evento ESC del teclado
    };
    $('#help').modal(opcioneshelp) 



    
});


/** Funcion confirmar cancelar ***/
function cancelar() {

 var decision= confirm('Si cancela perder\xE1 los datos del formulario actual.\n\xbfEst\xE1 seguro de cancelar?');
    if(decision){
      window.history.back(1);
    }
}

/****** Funciones predefinidas Formularios embebidos ************/
function addTagForm(collectionHolder, $newLinkLi) {
    // Obtiene los datos del prototipo explicado anteriormente
    var prototype = collectionHolder.data('prototype');

    // Consigue el nuevo índice
    var index = collectionHolder.data('index');

    // Sustituye el '__name__' en el prototipo HTML para que
    // en su lugar sea un número basado en cuántos elementos hay
    var newForm = prototype.replace(/__name__/g, index);

    // Incrementa en uno el índice para el siguiente elemento
    collectionHolder.data('index', index + 1);

    // Muestra el formulario en la página en un elemento li,
    // antes del enlace 'Agregar una etiqueta'
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);

     // Añade un enlace eliminar el nuevo formulario
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#" style="padding-left: 40px;">Eliminar</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // evita crear el enlace con una "#" en la URL
        e.preventDefault();

        // quita el li de la etiqueta del formulario
        $tagFormLi.remove();
    });

/** Validaciones en embebidos */
//calendario

$(function() {
$('.date').datepicker({ 
              dateFormat: 'dd-mm-yy',  
              changeMonth: true,
              changeYear: true,
              yearRange: "-100:+0",});

$(".telefono").mask("99999999",{placeholder:" "});
$(".dinero").maskMoney({thousands:'', decimal:'.'});
});

}


/***** Menu seccion ******/

$(document).ready(function(){
  $("#accordian h3").click(function(){
    //slide up all the link lists
    $("#accordian ul ul").slideUp();
    //slide down the link list below the h3 clicked - only if its closed
    if(!$(this).next().is(":visible"))
    {
      $(this).next().slideDown();
    }
  })
})

/** Funciones para calcula los dias de 2 fechas *******************/
function calculadias(fechaf,fechai){
  var fecha1 = new fecha( fechaf )
  var fecha2 = new fecha( fechai )
  var miFecha1 = new Date( fecha1.anio, fecha1.mes, fecha1.dia )
  var miFecha2 = new Date( fecha2.anio, fecha2.mes, fecha2.dia )

  var diferencia = miFecha1.getTime() - miFecha2.getTime()
  var dias = Math.floor(diferencia / (1000 * 60 * 60 * 24))
  //var segundos = Math.floor(diferencia / 1000) 
  return dias
}
function fecha( cadena ) {
    //Separador para la introduccion de las fechas
    var separador = "-"
    //Separa por dia, mes y año
    if ( cadena.indexOf( separador ) != -1 ) {
        var posi1 = 0
        var posi2 = cadena.indexOf( separador, posi1 + 1 )
        var posi3 = cadena.indexOf( separador, posi2 + 1 )
        this.dia = cadena.substring( posi1, posi2 )
        this.mes = cadena.substring( posi2 + 1, posi3 )
        this.anio = cadena.substring( posi3 + 1, cadena.length )
    } else {
        this.dia = 0
        this.mes = 0
        this.anio = 0
    }
}
/** Funcion para calcular resta de horas ************************/
function calcular(v1,v2)
{
    horas1=v1.split(":"); /*Mediante la función split separamos el string por ":" y lo convertimos en array. */
    horas2=v2.split(":");
    horatotale=new Array();
    for(a=0;a<3;a++) /*bucle para tratar la hora, los minutos y los segundos*/
    {

        horas1[a]=(isNaN(parseInt(horas1[a])))?0:parseInt(horas1[a]) /*si horas1[a] es NaN lo convertimos a 0, sino convertimos el valor en entero*/
        horas2[a]=(isNaN(parseInt(horas2[a])))?0:parseInt(horas2[a])
        horatotale[a]=(horas1[a]-horas2[a]);/* insertamos la resta dentro del array horatotale[a].*/
    }
    horatotal=new Date()  /*Instanciamos horatotal con la clase Date de javascript para manipular las horas*/
    horatotal.setHours(horatotale[0]); /* En horatotal insertamos las horas, minutos y segundos calculados en el bucle*/
    horatotal.setMinutes(horatotale[1]);
    horatotal.setSeconds(horatotale[2]);
    return horatotal.getHours()+":"+horatotal.getMinutes()+":"+
    horatotal.getSeconds();
    /*Devolvemos el valor calculado en el formato hh:mm:ss*/
}
