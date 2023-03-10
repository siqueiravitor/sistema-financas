<div class="block-header">
    <div class="row">       
        <div class="col-md-4">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASED; ?>/index"><i class="icon-home"></i></a></li>      
                    <?php
                    $breadcrumbs = explode('/', $_SERVER['REQUEST_URI']);
                    if(isset($_GET)){
                        $removeGet = explode('?', $_SERVER['REQUEST_URI'])[0];
                        $breadcrumbs = explode('/', $removeGet);
                    }

                    foreach ($breadcrumbs as $idx => $breadcrumb) {
                        if ($idx > 2 && $breadcrumb) {
                            echo "<li class='breadcrumb-item'>$breadcrumb</li> ";
                        }
                    }
                    ?>
            </ul>
        </div>                      
    </div>
</div>