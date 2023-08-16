function checkCheckbox() {
    let data = $(".checkRegister");
    let items = [];
    data.each((idx) => {
        if (data[idx].checked === true) {
            items.push(data[idx].value);
        }
    })
    if (items.length > 0) {
        $('#quantity').html(items.length);
        $(".btn-checkAll").removeAttr('disabled');
    } else {
        $('#quantity').html(0);
        $(".btn-checkAll").attr('disabled', 'disabled');
    }
}
function checkAll(check = true) {
    let data = $(".checkRegister");

    if (check) {
        data.each((idx) => {
            data[idx].checked = true;
        })
        checkCheckbox();
    } else {
        data.each((idx) => {
            data[idx].checked = false;
        })
        checkCheckbox();
    }
}
function deleteSelected() {
    let data = $(".checkRegister");
    let items = [];
    data.each((idx) => {
        if (data[idx].checked === true) {
            items.push(data[idx].value);
        }
    })
    if (items.length > 0) {
        let url = './include/cAjaxDeleteFinance.php';
        const request = $.ajax({
            url,
            data: { id: items, mult: true },
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
}
// A j a x
function loadFinances() {
    let url = './include/tableFinance.php';
    const request = $.ajax({
        url,
        method: "GET",
        dataType: "html",
        beforeSend: function() {
            $("#management-table").html(divLoading);
        }
    });
    request.done(function(data) {
        $("#management-table").html(data);
        $("#management-table").dataTable({
            "aaSorting": [],
            "columnDefs": [{
                "targets": [0,8,9,10],
                "orderable": false
            }]
        });
    });
    request.fail(function(jqXHR, textStatus) {
        console.log(textStatus)
        $("#management-table").html(divError(textStatus));
    });
}

function canvaContent() {
    let url = './include/canvaContent.php';
    const request = $.ajax({
        url,
        method: "GET",
        dataType: "html",
        beforeSend: function() {
            $("#divBodyFinance").html(divLoading);
        }
    });
    request.done(function(data) {
        $("#divBodyFinance").html(data);
        $(".select2").select2('destroy');
        $(".select2").select2();
        $(".date").datepicker('refresh');

    });
    request.fail(function(jqXHR, textStatus) {
        $("#divBodyFinance").html(divError(textStatus));
    });
}
function recurrenceOptions(value) {
    let url = './include/cAjaxCanvaRegisterUnique.php';
    if (value === 'f') {
        url = './include/cAjaxCanvaRegisterFixed.php';
    } else if (value === 'i') {
        url = './include/cAjaxCanvaRegisterInstallment.php';
    }

    var request = $.ajax({
        url,
        dataType: "html",
        beforeSend: function () {
            $("#divBodyFinance").html(divLoading);
        }
    });
    request.done(function (data) {
        $("#divBodyFinance").html(data);

        $(".select2").select2('destroy');
        $(".select2").select2();
        $(".date").datepicker('refresh');
    });
    request.fail(function (jqXHR, textStatus) {
        $("#ocNewRecord").html(divError(textStatus));
    });
}
function loadFinanceData(id) {
    let url = './include/cAjaxEditFinance.php';
    const request = $.ajax({
        url,
        data: { id },
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
function deleteFinance(id) {
    let url = './include/cAjaxDeleteFinance.php';
    const request = $.ajax({
        url,
        data: { id },
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
function infoFinance(id) {
    let url = './include/cAjaxModalFinance.php';

    const request = $.ajax({
        url,
        data: { id },
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
// A j a x End

function filtrar(tabela, texto, column) {
    $('#'+tabela).DataTable().columns(column).search(texto ? '^' + texto + '$' : '', true, false).draw();
}