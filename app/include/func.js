function abrirHistorico(parametro, url) {
    if (!url) {
        url = "../../include/mHistorico.php";
    }

    $('#modalHistorico').modal('show');
    $.ajax({
        url: url,
        dataType: 'html',
        type: 'GET',
        data: { parametro },
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

function deleteModal(id, url, params) {
    const request = $.ajax({
        url,
        data: { id, params },
        method: "GET",
        dataType: "html",
        beforeSend: function () {
            $("#modal-content").html(divLoading);
        }
    });
    request.done(function (data) {
        $("#modal-content").html(data);
    });
    request.fail(function (jqXHR, textStatus) {
        $("#modal-content").html(divError(textStatus));
    });
}

function loadData(id, url, id_alt) {
    const request = $.ajax({
        url,
        data: { id, id_alt },
        method: "GET",
        dataType: "html",
        beforeSend: function () {
            $("#ocTemplate").html(divLoading);
        }
    });
    request.done(function (data) {
        $("#ocTemplate").html(data);

        $(".select2").select2('destroy');
        $(".select2").select2();
        $('#date').datepicker({
            todayHighlight: true
        });
    });
    request.fail(function (jqXHR, textStatus) {
        $("#ocTemplate").html(divError(textStatus));
    });
}
function moneyMask(input) {
    if (input.value) {
        const numericInput = input.value.replace(/\D/g, '');
        const formattedInput = (parseInt(numericInput) / 100).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        input.value = formattedInput;
    }
}
function moneyBRL(input) {     
    const numericInput = input.value.replace(/\D/g, '');
    const formattedInput = (parseInt(numericInput) / 100).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    input.value = formattedInput;
}
function moneytToFloat(value){
    let format =value.replace(/\D/g, '');
    let floatValue = Math.floor(format)/100;
    return floatValue;
}
function floatToBRL(value) {     
    const formattedInput = value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    return formattedInput;
}
function divError(statusError, canva = null) {
    var divError =
        `<div class='offcanvas-body offcanvas-loading' style='flex-grow: 10!important'>
        Request failed: <span class='text-danger'> `+ statusError + `</span>
    </div>`;
    if(canva){
        divError += `<div class='offcanvas-footer' style='flex-grow: 1!important'>
            <button type='button' class='btn btn-tertiary' style='width: 90%'
            data-bs-dismiss='offcanvas'>Fechar</button>
        </div>`;
    }

    return divError;
}

var divLoading =
    `<div class="offcanvas-body offcanvas-loading pt-3">
    <i class='fa-spin fa fa-spinner'></i> <strong>Carregando...</strong>
</div>`;
