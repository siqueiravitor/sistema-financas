<?php

function montaAlert($status, $texto, $tempo) {
    switch ($status) {
        Case 0://Sucesso
            $icone = "fa fa-check-circle";
            $classe = "success";
            break;
        Case 1://Erro
            $icone = "fa fa-times-circle";
            $classe = "danger";
            break;
        Case 2://Cuidado
            $icone = "fa fa-warning";
            $classe = "warning";
            break;
        Case 3://Info
            $icone = "fa fa-info-circle ";
            $classe = "info";
            break;
    }
    return '<div class="alert alert-' . $classe . ' alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <i class="' . $icone . '"></i> ' . $texto . '
            </div>
            <script type="text/javascript">
                window.setTimeout(function () {
                    $(".alert").fadeTo(1000, 0).slideUp(1000, function () {
                        $(this).remove();
                    });
                }, ' . $tempo . ');
            </script>';
}
echo montaAlert($_GET['status'], $_GET['texto'], $_GET['tempo']);
