<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

  <!-- Start::main-sidebar-header -->
  <div class="main-sidebar-header">
    <a href="index.php" class="header-logo">
      <img src="../assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
      <img src="../assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
      <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
      <img src="../assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
      <img src="../assets/images/brand-logos/desktop-white.png" alt="logo" class="desktop-white">
      <img src="../assets/images/brand-logos/toggle-white.png" alt="logo" class="toggle-white">
    </a>
  </div>
  <!-- End::main-sidebar-header -->

  <!-- Start::main-sidebar -->
  <div class="main-sidebar" id="sidebar-scroll">

    <!-- Start::nav -->
    <nav class="main-menu-container nav nav-pills flex-column sub-open">
      <div class="slide-left" id="slide-left">
        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
          <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
        </svg>
      </div>
      <ul class="main-menu">
        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name">I N I C I O</span></li>
        <!-- End::slide__category -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['dashboard'] == '1') { ?>
        <li class="slide">
          <a href="escritorio.php" class="side-menu__item">
            <i class="bx bx-home side-menu__icon"></i><span class="side-menu__label"> Dashboards</span>
          </a>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name">L O G I S T I C A</span></li>
        <!-- End::slide__category -->
        
        <!-- Start::slide -->
        <?php  if ($_SESSION['compra'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class="bx bx-home side-menu__icon"></i>
            <span class="side-menu__label">Compras<span class="badge bg-warning-transparent ms-2">3</span></span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"> <a href="javascript:void(0)">Compras</a>  </li>
            <?php  if ($_SESSION['proveedores'] == '1') { ?>
            <li class="slide"> <a href="proveedores.php" class="side-menu__item">Proveedores</a> </li>
            <?php } ?>
            <?php  if ($_SESSION['lista_de_compras'] == '1') { ?>
            <li class="slide"> <a href="index-1.php" class="side-menu__item">Ingresar compra</a> </li>
            <?php } ?>
            <?php  if ($_SESSION['lista_de_compras'] == '1') { ?>
            <li class="slide"> <a href="compras.php" class="side-menu__item">Lista de compra</a> </li>         
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['articulo'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class="bx bx-home side-menu__icon"></i>
            <span class="side-menu__label">Articulos<span class="badge bg-warning-transparent ms-2">8</span></span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"> <a href="javascript:void(0)">Articulos</a></li>
            <?php  if ($_SESSION['producto'] == '1') { ?>
            <li class="slide"> <a href="producto.php" class="side-menu__item">Producto</a></li>
            <?php } ?>
            <?php  if ($_SESSION['servicio'] == '1') { ?>
            <li class="slide"> <a href="servicio.php" class="side-menu__item">Servicio</a></li>
            <?php } ?>
            <?php  if ($_SESSION['categoria_y_marca'] == '1') { ?>
            <li class="slide"> <a href="categoria_y_marca.php" class="side-menu__item">Categoria y Marca</a></li>
            <?php } ?>
            <?php  if ($_SESSION['unidad_de_medida'] == '1') { ?>
            <li class="slide"> <a href="unidad_medida.php" class="side-menu__item">Unidad Medida</a></li>  
            <?php } ?>
            <?php  if ($_SESSION['stok_precio'] == '1') { ?>          
            <li class="slide"> <a href="index-4.php" class="side-menu__item">Stok / Precio</a></li>
            <?php } ?>
            <?php  if ($_SESSION['tranferencia_de_stock'] == '1') { ?>
            <li class="slide"> <a href="index-5.php" class="side-menu__item">Tranferencia de Stok</a></li>
            <?php } ?>
            <?php  if ($_SESSION['inventario'] == '1') { ?>
            <li class="slide"> <a href="index-6.php" class="side-menu__item">Inventario</a></li>   
            <?php } ?>         
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name">G E S T I O N - D E - V E N T A S</span></li>
        <!-- End::slide__category -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['caja'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class="bx bx-file-blank side-menu__icon"></i>
            <span class="side-menu__label">Caja<span class="badge bg-secondary-transparent ms-2">New</span></span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"> <a href="javascript:void(0)">Caja</a> </li>
            <?php  if ($_SESSION['caja_chica'] == '1') { ?>
            <li class="slide"> <a href="about-us.php" class="side-menu__item">Caja chica</a></li> 
            <?php } ?>         
            <?php  if ($_SESSION['ingreso_egreso'] == '1') { ?>  
            <li class="slide"> <a href="chat.php" class="side-menu__item">Ingreso / Egreso</a></li>
            <?php } ?>                 
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['POS'] == '1') { ?>
        <li class="slide">
          <a href="pos.php" class="side-menu__item">
            <i class="bx bx-home side-menu__icon"></i><span class="side-menu__label"> POS</span>
          </a>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['realizar_venta'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class='bx bx-cart-add side-menu__icon'></i>
            <span class="side-menu__label">Realizar venta<span class="badge bg-secondary-transparent ms-2">New</span></span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"> <a href="javascript:void(0)">Realizar venta</a> </li>
            <?php  if ($_SESSION['boleta'] == '1') { ?>
            <li class="slide"> <a href="task-kanban-board.php" class="side-menu__item">Boleta</a></li>
            <?php } ?>
            <?php  if ($_SESSION['factura'] == '1') { ?>
            <li class="slide"> <a href="task-list-view.php" class="side-menu__item">Factura</a></li>
            <?php } ?>
            <?php  if ($_SESSION['nota_de_venta'] == '1') { ?>
            <li class="slide"> <a href="task-details.php" class="side-menu__item">Nota de venta</a></li>
            <?php } ?>
            <?php  if ($_SESSION['Cotizacion'] == '1') { ?>
            <li class="slide"> <a href="task-details.php" class="side-menu__item">Cotizacion</a></li>
            <?php } ?>
            <?php  if ($_SESSION['nota_de_credito'] == '1') { ?>
            <li class="slide"> <a href="task-details.php" class="side-menu__item">Nota de credito</a></li>
            <?php } ?>
            <?php  if ($_SESSION['nota_de_debito'] == '1') { ?>
            <li class="slide"> <a href="task-details.php" class="side-menu__item">Nota de debito</a></li>
            <?php } ?>
            <?php  if ($_SESSION['guia_de_remision'] == '1') { ?>
            <li class="slide"> <a href="task-details.php" class="side-menu__item">Guia remision</a></li>
            <?php } ?>
            <?php  if ($_SESSION['cliente'] == '1') { ?>
            <li class="slide"> <a href="clientes.php" class="side-menu__item">Clientes</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['comprobante'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class='bx bxs-file-doc side-menu__icon'></i>
            <span class="side-menu__label">Comprobante</span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"> <a href="javascript:void(0)">Comprobante</a> </li>
            <?php  if ($_SESSION['estado_de_envio'] == '1') { ?>
            <li class="slide"> <a href="coming-soon.php" class="side-menu__item">Estado de envio</a> </li>   
            <?php } ?>       
            <?php  if ($_SESSION['anulados'] == '1') { ?>  
            <li class="slide"> <a href="coming-soon.php" class="side-menu__item">Anulados</a> </li>   
            <?php } ?>       
            <?php  if ($_SESSION['validar_solo_factura'] == '1') { ?>           
            <li class="slide"> <a href="coming-soon.php" class="side-menu__item">Validar solo factura</a> </li>   
            <?php } ?>       
            <?php  if ($_SESSION['validar_solo_boleta'] == '1') { ?>           
            <li class="slide"> <a href="coming-soon.php" class="side-menu__item">Validar solo boleta</a> </li>     
            <?php } ?>      
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['resumen_de_baja'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class="bx bx-error side-menu__icon"></i>
            <span class="side-menu__label">Resumen de baja</span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"><a href="javascript:void(0)">Resumen de baja</a></li>
            <?php  if ($_SESSION['resumen_de_baja'] == '1') { ?>
            <li class="slide"><a href="401-error.php" class="side-menu__item">Anular boletas</a></li>
            <?php } ?>
            <?php  if ($_SESSION['resumen_de_baja'] == '1') { ?>
            <li class="slide"><a href="401-error.php" class="side-menu__item">Anular facturas</a></li>
            <?php } ?>
            <?php  if ($_SESSION['resumen_de_baja'] == '1') { ?>
            <li class="slide"><a href="401-error.php" class="side-menu__item">Anular nota de credito</a></li>     
            <?php } ?>      
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['creditos_Pendientes'] == '1') { ?>
        <li class="slide">
          <a href="icons.php" class="side-menu__item">
            <i class="bx bx-home side-menu__icon"></i><span class="side-menu__label"> Creditos pendiente</span>
          </a>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name">C O N T A B I L I D A D</span></li>
        <!-- End::slide__category -->


        <!-- Start::slide -->
        <?php  if ($_SESSION['kardex_por_articulos'] == '1') { ?>
        <li class="slide">
          <a href="icons.php" class="side-menu__item">
            <i class="bx bx-home side-menu__icon"></i><span class="side-menu__label"> Kardex por articulo</span>
          </a>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['reporte'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <box-icon name='bar-chart-square side-menu__icon'></box-icon>
            <span class="side-menu__label">Reportes</span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1 mega-menu">
            <li class="slide side-menu__label1"> <a href="javascript:void(0)">Reportes</a></li>
            <?php  if ($_SESSION['venta_dia_mes'] == '1') { ?>
            <li class="slide"> <a href="alerts.php" class="side-menu__item">Venta Dia/mes</a></li>  
            <?php } ?>         
            <?php  if ($_SESSION['venta_por_vendedor'] == '1') { ?>
            <li class="slide"> <a href="alerts.php" class="side-menu__item">Venta por vendedor</a></li>
            <?php } ?>         
            <?php  if ($_SESSION['venta_agrupada'] == '1') { ?>
            <li class="slide"> <a href="alerts.php" class="side-menu__item">Venta agrupada</a></li>
            <?php } ?>         
            <?php  if ($_SESSION['venta_por_cliente'] == '1') { ?>
            <li class="slide"> <a href="alerts.php" class="side-menu__item">Venta por cliente</a></li>
            <?php } ?>         
            <?php  if ($_SESSION['PLE_ventas'] == '1') { ?>
            <li class="slide"> <a href="alerts.php" class="side-menu__item">PLE ventas</a></li>
            <?php } ?>         
            <?php  if ($_SESSION['reporte_compras'] == '1') { ?>
            <li class="slide"> <a href="alerts.php" class="side-menu__item">Compras</a></li>
            <?php } ?>         
            <?php  if ($_SESSION['margen_de_ganancia'] == '1') { ?>
            <li class="slide"> <a href="alerts.php" class="side-menu__item">Margen de ganancia</a></li>
            <?php } ?>         
            <?php  if ($_SESSION['correo_enviado'] == '1') { ?>
            <li class="slide"> <a href="alerts.php" class="side-menu__item">Correo enviados</a></li>
            <?php } ?>     
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['gastos_trabajador'] == '1') { ?>
        <li class="slide">
          <a href="gasto_de_trabajador.php" class="side-menu__item">
            <i class='bx bx-dollar-circle side-menu__icon' ></i><span class="side-menu__label"> Gastos Trabajador</span>
          </a>
        </li>
        <?php } ?>
        <!-- End::slide -->        

        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name">G E S T I O N - R R H H</span></li>
        <!-- End::slide__category -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['administracion'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class='bx bxs-briefcase-alt-2 side-menu__icon'  ></i>
            <span class="side-menu__label">Administracion</span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"><a href="javascript:void(0)">Administracion</a></li>
            <?php  if ($_SESSION['usuario'] == '1') { ?>
            <li class="slide"><a href="usuario.php" class="side-menu__item">Usuarios</a></li>     
            <?php } ?>             
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['planilla_personal'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class='bx bx-user-check side-menu__icon'></i>
            <span class="side-menu__label">Planilla personal</span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"><a href="javascript:void(0)">Planilla personal</a></li>  
            <?php  if ($_SESSION['registrar_trabajador'] == '1') { ?>          
            <li class="slide"><a href="trabajador.php" class="side-menu__item">Trabajadores</a></li>
            <?php } ?>
            <?php  if ($_SESSION['tipo_de_seguro'] == '1') { ?>
            <li class="slide"><a href="floating_labels.php" class="side-menu__item">Tipo de seguro</a></li>
            <?php } ?>
            <?php  if ($_SESSION['boleta_de_pago'] == '1') { ?>
            <li class="slide"><a href="floating_labels.php" class="side-menu__item">Boleta de pago</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name">C O N F I G U R A C I O N</span></li>
        <!-- End::slide__category -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['SUNAT'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class='bx bx-building side-menu__icon'></i>
            <span class="side-menu__label">SUNAT</span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"><a href="javascript:void(0)">SUNAT</a></li>
            <?php  if ($_SESSION['tipo_de_tributos'] == '1') { ?>
            <li class="slide"><a href="tipo_de_tributos.php" class="side-menu__item">Tipo de tributos</a></li>
            <?php } ?>
            <?php  if ($_SESSION['documento_de_identidad'] == '1') { ?>
            <li class="slide"><a href="documento_de_identidad.php" class="side-menu__item">Documento de Identidad</a></li>
            <?php } ?>
            <?php  if ($_SESSION['tipo_de_afeccion_IGV'] == '1') { ?>
            <li class="slide"><a href="accordions_collpase.php" class="side-menu__item">Tipo afeccion IGV</a></li>  
            <?php } ?>
            <?php  if ($_SESSION['correlativo_numeracion'] == '1') { ?>          
            <li class="slide"><a href="correlacion_comprobante.php" class="side-menu__item">Correlativo Numercion</a></li>
            <?php } ?>
            <?php  if ($_SESSION['cargar_certificado'] == '1') { ?>
            <li class="slide"><a href="accordions_collpase.php" class="side-menu__item">Cargar Certificado</a></li>  
            <?php } ?>          
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['empresa'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class='bx bxs-building-house side-menu__icon' ></i>
            <span class="side-menu__label">Empresa</span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"><a href="javascript:void(0)">Empresa</a></li>
            <?php  if ($_SESSION['empresa_configuracion'] == '1') { ?>
            <li class="slide"><a href="empresa.php" class="side-menu__item">Empresa</a></li>
            <?php } ?>
            <?php  if ($_SESSION['correo_SMTP'] == '1') { ?>
            <li class="slide"><a href="accordions_collpase.php" class="side-menu__item">Correo/SMTP</a></li>
            <?php } ?>
            <?php  if ($_SESSION['notificaciones'] == '1') { ?>
            <li class="slide"><a href="accordions_collpase.php" class="side-menu__item">Notificaciones</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['configuracion'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class='bx bx-cog side-menu__icon'></i>
            <span class="side-menu__label">Configuración</span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"><a href="javascript:void(0)">Configuración</a></li>
           
            <li class="slide"><a href="general.php" class="side-menu__item">General</a></li>                  
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide -->
        <li class="slide">
          <a href="papelera.php" class="side-menu__item" target="_blank">
            <i class='bx bx-trash side-menu__icon'></i><span class="side-menu__label"> Papelera</span>
          </a>
        </li>
        <!-- End::slide -->

        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name">S O P O R T E</span></li>
        <!-- End::slide__category --> 

        <!-- Start::slide -->
        <li class="slide">
          <a href="https://wa.link/1dpx0i" class="side-menu__item" target="_blank">
            <i class="bx bx-home side-menu__icon"></i><span class="side-menu__label"> Soporte Técnico</span>
          </a>
        </li>
        <!-- End::slide -->

        
      </ul>
      <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
          height="24" viewBox="0 0 24 24">
          <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
        </svg></div>
    </nav>
    <!-- End::nav -->

  </div>
  <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->