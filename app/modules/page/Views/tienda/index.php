<?php
echo $this->banner;
?>
<div class="container">
    <?php
    echo $this->productos;
    ?>
</div>

<?php if ($this->popup->publicidad_estado == 1) { ?>
    <div class="modal fade" id="popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                <div class="modal-body">
                    <?php if ($this->popup->publicidad_video != "") { ?>
                        <div class="fondo-video-youtube">
                            <div class="banner-video-youtube" id="videobanner<?php echo $this->popup->publicidad_id; ?> " data-video="<?php echo $this->id_youtube($this->popup->publicidad_video); ?>"></div>
                        </div>
                    <?php } ?>
                    <?php if ($this->popup->publicidad_imagen != "") { ?>
                        <?php if ($this->popup->publicidad_enlace != "") { ?> <a href="<?php echo $this->popup->publicidad_enlace ?>" <?php if ($this->popup->publicidad_tipo_enlace == 1) {
                                                                                                                                            echo "target='_blank'";
                                                                                                                                        } ?>> <?php } ?><img src="/images/<?php echo $this->popup->publicidad_imagen ?>" alt="">
                            <?php if ($this->popup->publicidad_enlace != "") { ?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function() {
        <?php if ($this->popup->publicidad_estado == 1) { ?>
            $("#popup").modal("show");
        <?php } ?>
    });
</script>


<style>
    .button-modal {
        cursor: pointer;
        width: 205px;
        margin-left: 30px;
    }

    .modal-content {
        border: none;
        background-color: transparent;
    }

    .modal-content img {
        width: 100%;

    }
</style>