// A j a x
function loadTypePayment() {
    let url = './include/tableTypePayment.php';
    const request = $.ajax({
        url,
        method: "GET",
        dataType: "html",
        beforeSend: function() {
            $("#typePayment_table").html(divLoading);
        }
    });
    request.done(function(data) {
        $("#typePayment_table").html(data);
        $("#typePayment_table").dataTable({
            "aaSorting": [],
            "columnDefs": [{
                "targets": [1,2],
                "orderable": false
            }]
        });
    });
    request.fail(function(jqXHR, textStatus) {
        $("#typePayment_table").html(divError(textStatus));
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
function deleteTypePayment(id){
    let url = './include/dTypePayment.php';
    const request = $.ajax({
        url,
        method: "GET",
        dataType: "html",
        beforeSend: function() {
            $("#category_table").html(divLoading);
        },
        data: id
    });
    request.done(function(data) {
        console.log(data)
        loadCategories()
    });
    request.fail(function(jqXHR, textStatus) {
        console.log(textStatus)
        // $("#category_table").html(divError(textStatus));
    });
}