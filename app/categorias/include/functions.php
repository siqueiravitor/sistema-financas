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
                description,
                id_user
            FROM categories
            WHERE type != 'save'
            AND (id_user is null 
            OR id_user = " . $_SESSION['id'] . ")";
    if($id){
        $sql .= " AND id = $id ";
    }
    $sql .= " ORDER BY type ";

    $query = mysqli_query($con, $sql);
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

    return $result;
}

// U p d a t e
function updateCategory($fields){
    try{
        global $con;
        $datetime = date('Y-m-d H:i:s');

        $update = "UPDATE categories SET 
                    description = ?,
                    updated_at = ?
                WHERE id = ?";

        $prepareUpdate = mysqli_prepare($con, $update);
        mysqli_stmt_bind_param($prepareUpdate, 'ssi', $fieldDesc, $fieldUpdated, $fieldId);

        $fieldDesc = $fields['description'];
        $fieldUpdated = $datetime;
        $fieldId = $fields['id'];
        if (!mysqli_stmt_execute($prepareUpdate)) {
            mysqli_stmt_close($prepareUpdate);
            return ['success' => false, 'message' => "Erro ao atualizar dados"];
        }

        mysqli_stmt_close($prepareUpdate);
        return ['success' => true, 'message' => "Dados atualizados"];
    } catch(Exception $e) {
        return ['success' => false, 'message' => "Erro ao atualizar dados", 'error' => $e];
    }
}
// D e l e t e 
function deleteCategory($id){
    global $con;

    $sql = "DELETE FROM categories WHERE id IN ($id) AND id_user IS NOT NULL";

    $query = mysqli_query($con, $sql);
    if (!$query) {
        return "Erro ao deletar categoria";
    }
    $rows = mysqli_affected_rows($con);

    return $rows;
}