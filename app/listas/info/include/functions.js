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
function changeItemStatus(id){
    let url = './include/uItemStatus.php';
    const request = $.ajax({
        url,
        data: { id },
        method: "POST",
        dataType: "json",
        beforeSend: function () {
            $("body").tooltip();
        }
    });
    request.done(function(data) {
        if(data.success){
            let status, changeTo, btnColor;
            status = data.status === 'a' ? 'Ativo' : "Inativo"; 
            btnColor = data.status === 'a' ? 'btn-outline-success' : "btn-outline-danger"; 
            
            let span = `<span class='badge-btn `+ btnColor +` space-1' href='#' 
                            onclick='changeItemStatus(`+ id +`)' class='d-block'>`+ status +`</span>`;
            $("#item_"+id).html(span);
        }

    });
    request.fail(function(jqXHR, textStatus) {
        console.log(textStatus)
    });
}
