<ul>
  <?php if (Session::getInstance()->get('kt_login_level') == '1') { ?>
    <li <?php if ($this->botonpanel == 1) { ?>class="activo" <?php } ?>>
      <a href="/administracion/panel">
        <i class="fas fa-info-circle"></i>
        Información Página
      </a>
    </li>
  <?php } ?>
  <li <?php if ($this->botonpanel == 2) { ?>class="activo" <?php } ?>>
    <a href="/administracion/publicidad">
      <i class="far fa-images"></i>
      Administrar Publicidad
    </a>
  </li>
  <li <?php if ($this->botonpanel == 3) { ?>class="activo" <?php } ?>>
    <a href="/administracion/contenido">
      <i class="fas fa-file-invoice"></i>
      Administrar Contenidos
    </a>
  </li>
  <li <?php if ($this->botonpanel == 5) { ?>class="activo" <?php } ?>>
    <a href="/administracion/categorias">
      <i class="fa-solid fa-layer-group"></i>
      Administrar Categorías
    </a>
  </li>
  <li <?php if ($this->botonpanel == 6) { ?>class="activo" <?php } ?>>
    <a href="/administracion/marcas">
      <i class="fa-regular fa-copyright"></i>
      Administrar Marcas
    </a>
  </li>
  <li <?php if ($this->botonpanel == 7) { ?>class="activo" <?php } ?>>
    <a href="/administracion/distribuidores">
      <i class="fa-solid fa-boxes-packing"></i>
      Administrar Distribuidores
    </a>
  </li>
  <li <?php if ($this->botonpanel == 8) { ?>class="activo" <?php } ?>>
    <a href="/administracion/productos">
      <i class="fa-solid fa-dumpster"></i>
      Administrar Productos
    </a>
  </li>
  <li <?php if ($this->botonpanel == 9) { ?>class="activo" <?php } ?>>
    <a href="/administracion/actualizarcupos/manage?id=2">
      <i class="fa-solid fa-dumpster"></i>
      Actualizar Productos
    </a>
  </li>
  <li <?php if ($this->botonpanel == 10) { ?>class="activo" <?php } ?>>
    <a href="/administracion/listarcompras">
      <i class="fa-solid fa-list"></i>
      Listar Compras
    </a>
  </li>
  <li <?php if ($this->botonpanel == 11) { ?>class="activo" <?php } ?>>
    <a href="/administracion/actualizarcupos/manage?id=1">
      <i class="fa-solid fa-list"></i>
      Actualizar cupos
    </a>
  </li>
  <li <?php if ($this->botonpanel == 12) { ?>class="activo" <?php } ?>>
    <a href="/administracion/ordenesdecompra">
      <i class="fa-solid fa-list-ol"></i>
      Listar Ordenes de Compra
    </a>
  </li>
  <li <?php if ($this->botonpanel == 15) { ?>class="activo" <?php } ?>>
    <a href="/administracion/solicitudsoat">
      <i class="fas fa-users"></i>
      Solicitudes SOAT
    </a>
  </li>
  <li <?php if ($this->botonpanel == 13) { ?>class="activo" <?php } ?>>
    <a href="/administracion/usuariostienda">
      <i class="fas fa-users"></i>
      Administrar Usuarios Tienda
    </a>
  </li>
  <li <?php if ($this->botonpanel == 14) { ?>class="activo" <?php } ?>>
    <a href="/administracion/reportes">
      <i class="fa-solid fa-file-export"></i>
      Reportes
    </a>
  </li>
  <?php if (Session::getInstance()->get('kt_login_level') == '1') { ?>
    <li <?php if ($this->botonpanel == 4) { ?>class="activo" <?php } ?>>
      <a href="/administracion/usuario">
        <i class="fas fa-users"></i>
        Administrar Usuarios
      </a>
    </li>
  <?php } ?>
</ul>