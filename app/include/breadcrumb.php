<div class="block-header">
    <div class="row">       
        <div class="col-md-4">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASED; ?>"><i class="icon-home"></i></a></li>      
                
                    <?php
                    $breadcrumbs = explode('/', $_SERVER['REQUEST_URI']);
                    if(isset($_GET)){
                        $removeGet = explode('?', $_SERVER['REQUEST_URI'])[0];
                        $breadcrumbs = explode('/', $removeGet);
                    }
                    $lastIdx= array_key_last($breadcrumbs)-1;
                    foreach ($breadcrumbs as $idx => $breadcrumb) {
                        if ($idx > 2 && $breadcrumb) {
                            if($lastIdx != $idx){
                                echo "<li class='breadcrumb-item'><a href='".BASED."/$breadcrumb'>$breadcrumb</a></li>";
                            } else {
                                echo "<li class='breadcrumb-item active'>$breadcrumb</li>";
                            }
                        }
                    }
                    ?>
            </ul>
        </div>                      
    </div>
</div>