// A j a x
function loadItem(list) {
    let url = './include/tableItems.php';
    const request = $.ajax({
        url,
        data: { list },
        method: "GET",
        dataType: "html",
        beforeSend: function() {
            $("#items_table").html(divLoading);
        }
    });
    request.done(function(data) {
        $("#items_table").html(data);
        $("#items_table").dataTable({
            "aaSorting": [],
            "columnDefs": [{
                "targets": [2,3],
                "orderable": false
            }]
        });
    });
    request.fail(function(jqXHR, textStatus) {
        $("#items_table").html(divError(textStatus));
    });
}