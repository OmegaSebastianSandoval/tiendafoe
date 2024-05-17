<div class="slider-principal">


  <div id="carouselprincipal<?php echo $this->seccionbanner; ?>" class="carousel slide" data-bs-ride="carousel">
    <?php if (count($this->banners) > 1) { ?>


      <div class="carousel-indicators">
        <?php foreach ($this->banners as $key => $banner) { ?>

          <button type="button" data-bs-target="##carouselprincipal<?php echo $this->seccionbanner; ?>" data-bs-slide-to="<?php echo $key ?>" <?php if (
                                                                                                                                                $key == 0
                                                                                                                                              ) { ?>class="active" <?php } ?> aria-current="true" aria-label="Slide <?php echo $key ?>"></button>
        <?php } ?>

      </div>
    <?php } ?>

    <div class="carousel-inner">
      <?php foreach ($this->banners as $key => $banner) { ?>
        <div class="carousel-item <?php if ($key == 0) { ?>active <?php } ?>">

          <?php if ($this->id_youtube($banner->publicidad_video) != false) { ?>
            <div class="fondo-video-youtube">
              <div class="banner-video-youtube" id="videobanner<?php echo $banner->publicidad_id; ?> " data-video="<?php echo $this->id_youtube($banner->publicidad_video); ?>"></div>
            </div>
          <?php } else { ?>

            <div class="fondo-imagen d-none d-sm-flex justify-content-start align-items-center">

              <?php if ($banner->mostrarinfo != 1 && $banner->publicidad_enlace) { ?>
                <a href="<?php echo $banner->publicidad_enlace; ?>" <?php echo $banner->publicidad_tipo_enlace == 1 ? 'target="_blank"' : ''; ?> class="w-100">

                <?php } ?>

                <img src="/images/<?php echo $banner->publicidad_imagen; ?>" alt="">


                <?php if ($banner->mostrarinfo != 1 && $banner->publicidad_enlace) { ?>
                </a>
              <?php } ?>
              <?php if ($banner->mostrarinfo == 1) { ?>

                <div class="contenido-banner">

                  <h4>
                    <?php echo $banner->publicidad_nombre; ?>
                  </h4>
                  <?php echo $banner->publicidad_descripcion; ?>
                  <?php if ($banner->publicidad_enlace) { ?>
                    <a href="<?php echo $banner->publicidad_enlace; ?>" <?php echo $banner->publicidad_tipo_enlace == 1 ? 'target="_blank"' : ''; ?> class="btn-verde">
                      <?php echo $banner->publicidad_texto_enlace ? $banner->publicidad_texto_enlace : 'Ver más'; ?>

                    </a>
                  <?php } ?>

                </div>
              <?php } ?>
            </div>

            <div class="fondo-imagen-responsive d-sm-none d-flex justify-content-center align-items-center">
              <?php if ($banner->mostrarinfo != 1 && $banner->publicidad_enlace) { ?>
                <a href="<?php echo $banner->publicidad_enlace; ?>" <?php echo $banner->publicidad_tipo_enlace == 1 ? 'target="_blank"' : ''; ?> class="w-100">

                <?php } ?>

                <img src="/images/<?php echo $banner->publicidad_imagenresponsive; ?>" alt="" class="img-responsive-principal">
                <?php if ($banner->mostrarinfo != 1 && $banner->publicidad_enlace) { ?>
                </a>
              <?php } ?>

              <?php if ($banner->mostrarinfo == 1) { ?>

                <div class="contenido-banner">

                  <h4>
                    <?php echo $banner->publicidad_nombre; ?>
                  </h4>
                  <?php echo $banner->publicidad_descripcion; ?>
                  <?php if ($banner->publicidad_enlace) { ?>
                    <a href="<?php echo $banner->publicidad_enlace; ?>" <?php echo $banner->publicidad_tipo_enlace == 1 ? 'target="_blank"' : ''; ?> class="btn-verde">
                      <?php echo $banner->publicidad_texto_enlace ? $banner->publicidad_texto_enlace : 'Ver más'; ?>

                    </a>
                  <?php } ?>

                </div>
              <?php } ?>
            </div>

          <?php } ?>



        </div>
      <?php } ?>
    </div>
    <?php if (count($this->banners) > 1) { ?>

      <button type="button" class="carousel-control-prev" data-bs-target="#carouselprincipal<?php echo $this->seccionbanner; ?>" data-bs-slide="prev">
        <!-- <span class="carousel-control-prev-icon" aria-hidden="true"></span> -->
        <i class="fa-solid fa-chevron-left carousel-control-prev-icono"></i>
      </button>
      <button type="button" class="carousel-control-next" data-bs-target="#carouselprincipal<?php echo $this->seccionbanner; ?>" data-bs-slide="next">
        <!-- <span class="carousel-control-next-icon" aria-hidden="true"></span> -->
        <i class="fa-solid fa-chevron-right carousel-control-next-icono"></i>
      </button>
    <?php } ?>

  </div>
</div>