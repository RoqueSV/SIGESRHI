$(document).ready(function(){  
    //alert("ready"); 
     tableToGrid("#listado_expedientes");
       
    });
    jQuery("#listado_estudiantes").jqGrid('sortGrid',"Id",false);
    jQuery("#listado_estudiantes").jqGrid('navGrid','#pagerEstudiantes', {
        edit:false, 
        add:false, 
        del:false,
        search:true,
        reload:true
    });
});<