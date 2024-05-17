<?php if ($this->totalpages > 1) { ?>
    <div align="center" class="pagination ">
        <br>
        <ul class="pagination justify-content-center">
            <?php

            $url = $this->route;
            $max = $this->page + 6;
            $min = $this->page - 6;
            if ($this->page > 1) {
                $max = $this->page + 3;
                $min = $this->page - 3;
            }
            if ($this->page == 2) {
                $max = $this->page + 5;
            }
            if ($this->page == 3) {
                $max = $this->page + 4;
            }
            if ($this->totalpages > 1) {
                if ($this->page != 1) {
                    echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page - 1) . '"> <i class="fa-solid fa-chevron-left"></i> </a></li>';
                }
                for ($i = 1; $i <= $this->totalpages; $i++) {
                    if ($this->page == $i) {
                        echo '<li class="active page-item"><a class="page-link">' . $this->page . '</a></li>';
                    } else {
                        if ($i >= $min and $i <= $max) {
                            echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . $i . '&categoria=' . $_GET["categoria"] . '&subcategoria=' . $_GET["subcategoria"] . '#a">' . $i . '</a></li>  ';
                        }
                    }
                }
                if ($this->page != $this->totalpages) {
                    echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page + 1) . '"><i class="fa-solid fa-chevron-right"></i></a></li>';
                }
            }
            ?>
        </ul>
    </div>
<?php } ?>