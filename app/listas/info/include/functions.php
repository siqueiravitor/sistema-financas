<?php
// C r e a t e
function createItem($fields){
    global $con;

    $insert = "INSERT INTO items (id_list, description, value, created_at, updated_at) 
    VALUES (?, ?, ?, ?, ?)";

    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'isdss', $fieldIdList, $fieldDesc, $fieldValue, $fieldCreatedAt, $fieldUpdatedAt);

    $datetime = date('Y-m-d H:i:s');
    $fieldIdList = $fields['id_list'];
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
function items($id = null, $idItem = null){
    try{
        global $con;

        $sql = "SELECT 
                    id,
                    description,
                    value,
                    paid
                FROM items
                WHERE id_list = $id ";
        if($idItem){
            $sql .= " and id = $idItem ";
        }

        $query = mysqli_query($con, $sql);
        $result = mysqli_fetch_all($query, MYSQLI_NUM);

        return $result;
    } catch(Exception $e){
        return ["success" => false, "message" => "Erro ao buscar dados", $e];
    }
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