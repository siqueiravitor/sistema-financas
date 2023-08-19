<?php
// C r e a t e
function createItem($fields){
    global $con;

    $insert = "INSERT INTO items (id_list, id_category, description, value, created_at, updated_at) 
    VALUES (?, ?, ?, ?, ?, ?)";

    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'iisdss', $fieldIdList, $fieldCategory, $fieldDesc, $fieldValue, $fieldCreatedAt, $fieldUpdatedAt);

    $datetime = date('Y-m-d H:i:s');
    $fieldIdList = $fields['id_list'];
    $fieldCategory = $fields['id_category'];
    $fieldDesc = $fields['description'];
    $fieldValue = $fields['value'];
    $fieldCreatedAt = $datetime;
    $fieldUpdatedAt = $datetime;

    $result = mysqli_stmt_execute($prepareInsert);
    if (!$result) {
        mysqli_stmt_close($prepareInsert);
        return false;
    }
    $id = mysqli_stmt_insert_id($prepareInsert);
    mysqli_stmt_close($prepareInsert);
    return $id;
}

// R e a d
function items($id = null){
    global $con;

    $sql = "SELECT 
                id_category,
                description,
                value,
                paid
            FROM items
            WHERE id_list = $id ";

    $query = mysqli_query($con, $sql);
    $result = mysqli_fetch_all($query, MYSQLI_NUM);

    return $result;
}
// D e l e t e 
function deleteItem($id, $list = null){
    global $con;

    $item = "id IN ($id)";
    if($list){
        $item = "id_list = $list";
    }

    $sql = "DELETE FROM items WHERE $item";

    $query = mysqli_query($con, $sql);
    if (!$query) {
        return ['success' => false, 'message' => "Erro ao deletar dados"];
    }
    $rows = mysqli_affected_rows($con);

    return ['success' => true, 'message' => "Dados apagados ($rows)"];
}