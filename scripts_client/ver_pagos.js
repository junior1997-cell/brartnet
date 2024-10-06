
$(function () {


  $.post( "ajax_client/ver_pagos.php?op=ver_pagos_cliente", {},  function (e) {
    e = JSON.parse(e); console.log(e);			
    if (e.status) {
     	
      $('.list_data_pagos').html(e.data);
      
    } else {
      ver_errores(e);
    }
    
  }).fail( function(e) { ver_errores(e);  }); 

  filtro_pagos_year ();
  filtro_pagos_month ();

});

function filtro_pagos_year (){
  $.post( "ajax_client/ver_pagos.php?op=filtro_pagos_year", {},  function (e) {
    e = JSON.parse(e); console.log(e);	
    if (e.status) {
    			
      $('.list_year').html(e.data);
      
    } else {
      ver_errores(e);
    }
    
  }).fail( function(e) { 
    ver_errores(e);
  }); 

}

function filtro_pagos_month (){

    $.post( "ajax_client/ver_pagos.php?op=filtro_pagos_month", {},  function (e) {
      e = JSON.parse(e); console.log(e);	
      if (e.status) {
      			
      $('.list_month').html(e.data);
      
    } else {
      ver_errores(e);
    }
    
  }).fail( function(e) { 
    ver_errores(e);
  }); 

}