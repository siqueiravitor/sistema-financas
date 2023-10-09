// A j a x
function loadCategories() {
    let url = './include/tableCategory.php';
    const request = $.ajax({
        url,
        method: "GET",
        dataType: "html",
        beforeSend: function() {
            $("#category_table").html(divLoading);
        }
    });
    request.done(function(data) {
        $("#category_table").html(data);
        $("#category_table").dataTable({
            "aaSorting": [],
            "columnDefs": [{
                "targets": [2,3],
                "orderable": false
            }]
        });
    });
    request.fail(function(jqXHR, textStatus) {
        $("#category_table").html(divError(textStatus));
    });
}
function editCategory(id){
    let url = './include/dCategory.php';
    const request = $.ajax({
        url,
        method: "GET",
        dataType: "html",
        beforeSend: function() {
            $("#category_table").html(divLoading);
        },
        data: id
    });
    request.done(function() {
        loadCategories()
    });
    request.fail(function(jqXHR, textStatus) {
        console.log(textStatus)
    });
}
function deleteCategory(id){
    let url = './include/dCategory.php';
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
    });
}