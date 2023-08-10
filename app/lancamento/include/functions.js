function deleteSelected() {
    let data = $(".checkRegister");
    let items = [];
    data.each((idx) => {
        if (data[idx].checked === true) {
            items.push(data[idx].value);
        }
    })
    if (items.length > 0) {
        location.href = './include/dFinance.php?mult=true&id=' + items;
    }
}
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
        console.log(data)
        $("#management-table").html(data);
        $("#management-table").dataTable({
            "aaSorting": [],
            "columnDefs": [{
                "targets": [0, 9, 10, 11],
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
        console.log(data)
        $("#modal-content").html(data);
    });
    request.fail(function (jqXHR, textStatus) {
        $("#modal-content").html(divError(textStatus));
    });
}
// A j a x End
