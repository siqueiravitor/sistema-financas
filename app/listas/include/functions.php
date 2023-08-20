<?php
// C r e a t e
function createList($fields){
    global $con;

    $insert = "INSERT INTO lists (id_user, id_category, title, description, created_at, updated_at) 
    VALUES (?, ?, ?, ?, ?, ?)";

    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'iissss', $fieldUser, $fieldCategory, $fieldTitle, $fieldDesc, $fieldCreatedAt, $fieldUpdatedAt);

    $datetime = date('Y-m-d H:i:s');
    $fieldUser = $_SESSION['id'];
    $fieldCategory = $fields['id_category'];
    $fieldTitle = $fields['title'];
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
function lists($id = null){
    global $con;

    $sql = "SELECT 
                l.id,
                l.title,
                l.description,
                c.id,
                c.description
            FROM lists l
            INNER JOIN categories c on (c.id = l.id_category)
            WHERE l.id_user = " . $_SESSION['id'];
    if($id){
        $sql .= " AND l.id = $id ";
    }

    $query = mysqli_query($con, $sql);
    $result = mysqli_fetch_all($query, MYSQLI_NUM);

    return $result;
}
function categories(){
    global $con;

    $sql = "SELECT 
                id,
                type,
                description,
                id_user
            FROM categories
            WHERE (id_user is null 
            OR id_user = " . $_SESSION['id'] . ")";
    $sql .= " ORDER BY type desc";

    $query = mysqli_query($con, $sql);
    $result = mysqli_fetch_all($query, MYSQLI_NUM);

    return $result;
}

// U p d a t e
function updateList($fields){
    try{
        global $con;
        $datetime = date('Y-m-d H:i:s');

        $update = "UPDATE lists SET 
                    title = ?, 
                    description = ?,
                    updated_at = ?
                WHERE id = ?";

        $prepareUpdate = mysqli_prepare($con, $update);
        mysqli_stmt_bind_param($prepareUpdate, 'sssi', $fieldTitle, $fieldDesc, $fieldUpdated, $fieldId);

        $fieldTitle = $fields['title'];
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
function deleteList($id){
    global $con;

    $sql = "DELETE FROM lists WHERE id IN ($id)";

    $query = mysqli_query($con, $sql);
    if (!$query) {
        return ['success' => false, 'message' => "Erro ao deletar dados"];
    }
    $rows = mysqli_affected_rows($con);

    return ['success' => true, 'message' => "Dados apagados ($rows)"];
}