function abrirHistorico(parametro, url) {
    if(!url){
        url = "../../include/mHistorico.php";
    }

    $('#modalHistorico').modal('show');
    $.ajax({
        url: url,
        dataType: 'html',
        type: 'GET',
        data: {parametro},
        success: function (data) {
            $('#cModalHistorico').html(data);
            $('#tabelaHistorico').DataTable({
                "order": [[0, "desc"]]
            });
        },
        error: function (xhr, er, index, anchor) {
            $('#cModalHistorico').html('Error ' + xhr.status);
        },
        timeout: 60000 //2 minutos
    });
}