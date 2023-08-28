// A j a x
function loadSavings() {
    let url = './include/tableSavings.php';
    const request = $.ajax({
        url,
        method: "GET",
        dataType: "html",
        beforeSend: function() {
            $("#savings_table").html(divLoading);
        }
    });
    request.done(function(data) {
        $("#savings_table").html(data);
        $("#savings_table").dataTable({
            "aaSorting": [],
            // "columnDefs": [{
            //     "targets": [2,3],
            //     "orderable": false
            // }]
        });
    });
    request.fail(function(jqXHR, textStatus) {
        $("#savings_table").html(divError(textStatus));
    });
}