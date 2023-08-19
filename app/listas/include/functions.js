// A j a x
function loadList() {
    let url = './include/tableLists.php';
    const request = $.ajax({
        url,
        method: "GET",
        dataType: "html",
        beforeSend: function() {
            $("#list_table").html(divLoading);
        }
    });
    request.done(function(data) {
        $("#list_table").html(data);
        $("#list_table").dataTable({
            "aaSorting": [],
            "columnDefs": [{
                "targets": [2,3],
                "orderable": false
            }]
        });
    });
    request.fail(function(jqXHR, textStatus) {
        $("#list_table").html(divError(textStatus));
    });
}
// function editTypePayment(id){
//     let url = './include/dTypePayment.php';
//     const request = $.ajax({
//         url,
//         method: "GET",
//         dataType: "html",
//         beforeSend: function() {
//             $("#category_table").html(divLoading);
//         },
//         data: id
//     });
//     request.done(function(data) {
//         console.log(data)
//         loadCategories()
//     });
//     request.fail(function(jqXHR, textStatus) {
//         console.log(textStatus)
//         // $("#category_table").html(divError(textStatus));
//     });
// }