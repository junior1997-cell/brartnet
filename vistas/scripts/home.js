

function init(){

  mostrar_tecnico_redes();
  mostrar_planes();
  

}

//  :::::::::::::::: T R A B A J A D O R -- T E C N I C O   R E D E S   :::::::::::::::: 

function mostrar_tecnico_redes() {
  
  $.post("ajax/home.php?op=mostrar_tecnico_redes",  function(e, status){
    e = JSON.parse(e); console.log(e);
    if (e.status == true){

      $('#tecnico_redes').html(''); //limpiar el div

      e.data.forEach((val, key)=> {

        var codigoHTML = `<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mx-auto">
          <div class="card custom-card text-center team-card ">
            <div class="card-body p-5">
              <span class="avatar avatar-xxl avatar-rounded mb-3 team-avatar">
                <img src="assets/modulo/persona/perfil/${val.foto_perfil}" alt="">
              </span>
              <p class="fw-semibold fs-15 mb-0 text-default">${val.nombre} ${val.apellidos}</p>
              <span class="text-muted fs-12 text-primary fw-semibold">${val.cargo}</span>
              <p class="text-muted mt-2 fs-13"> Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              <div class="mt-2">
                <a href="https://wa.me/+51${val.celular}?text=Deseo%20cotizar%20los%20planes%20de%20internet" class="btn btn-light text-success" target="_blank"><i class="bi bi-whatsapp"></i> Contacto</a>
              </div>
            </div>
          </div>
        </div>`;

        $('#tecnico_redes').append(codigoHTML);

      });
      
    }else {
      ver_errores(response);
    }
  }).fail(function (e) { ver_errores(e); });
}


//  :::::::::::::::: P L A N E S   :::::::::::::::: 
function mostrar_planes() {
  
  $.post("ajax/home.php?op=mostrar_planes",  function(e, status){
    e = JSON.parse(e); console.log(e);
    if (e.status == true){

      $('#planes').html(''); //limpiar el div

      e.data.forEach((val, key)=> {
        var Instalacion = val.idplan == 1 ? "Instalación por zona de cobertura" : "Instalación";

        var codigoHTML = `<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 border border-2 rounded-4">
        <div class="p-4">
          <h6 class="fw-semibold text-center">${val.plan}</h6>
          <div class="py-3 d-flex align-items-center justify-content-center">
            <i class="ri-router-line la-4x text-primary"></i>
            <div class="text-end ms-5">
              <p class="fs-25 fw-semibold mb-0">S/ ${val.costo}</p>
              <p class="text-muted fs-11 fw-semibold mb-0">por mes</p>
            </div>
          </div>
          <ul class="list-unstyled text-center fs-12 px-3 pt-3 mb-0">
            
            <li class="mb-3">
              <span class="text-muted">${Instalacion}</span>
            </li>
            <li class="mb-3">
              <span class="text-muted">Soporte en línea</span>
            </li>
            <li class="mb-3">
              <span class="text-muted">Soporte Técnico<span class="badge bg-light text-default ms-1"><i class="ri-check-line"></i></span></span>
            </li>
            <li class="mb-3">
              <span class="text-muted">Fecha de pago<span class="badge bg-light text-default ms-1">03 de capa mes</span></span>
            </li>
            <li class="mb-4">
              <span class="text-muted">Contrato por 8 meses</span>
            </li>
          </ul>
          <div class="d-grid">
            <button class="btn btn-primary-light btn-wave">Empezar</button>
          </div>
        </div>
      </div>`;

        $('#planes').append(codigoHTML);

      });
      
    }else {
      ver_errores(response);
    }
  }).fail(function (e) { ver_errores(e); });
}

$(document).ready(function () {
  init();
});

//  :::::::::::::::: F O R M A  P A G O   :::::::::::::::: 
function banner_forma_pago(){
  

  
}


// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..
