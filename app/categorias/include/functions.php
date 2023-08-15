<?php
// C r e a t e
function createCategory($fields){
    global $con;

    $insert = "INSERT INTO categories (id_user, type, description, created_at, updated_at) 
    VALUES (?, ?, ?, ?, ?)";

    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'issss', $fieldUser, $fieldType, $fieldDesc, $fieldCreatedAt, $fieldUpdatedAt);

    $datetime = date('Y-m-d H:i:s');
    $fieldUser = $_SESSION['id'];
    $fieldType = $fields['type'];
    $fieldDesc = $fields['description'];
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
function categories($id = null){
    global $con;

    $sql = "SELECT 
                id,
                type,
                description
            FROM categories
            WHERE id_user = " . $_SESSION['id'];
    if($id){
        $sql .= " AND id = $id ";
    }
    $sql .= " ORDER BY type ";

    $query = mysqli_query($con, $sql);
    $result = mysqli_fetch_all($query, MYSQLI_NUM);

    return $result;
}

// D e l e t e 
function deleteCategory($id){
    global $con;

    $sql = "DELETE FROM categories WHERE id IN ($id)";

    $query = mysqli_query($con, $sql);
    if (!$query) {
        return "Erro ao deletar categoria";
    }
    $rows = mysqli_affected_rows($con);

    return $rows;
}