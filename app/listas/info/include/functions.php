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

function createFinance($listId){
    global $con;
    try{
        $items = items($listId);
        foreach($items as $item){
            $status = $item[4];
            if($status == 'a'){
                $description = $item[1];
                $value = $item[2];

                $date = date('Y-m-d H:i:s');
            
                $insert = "INSERT INTO finances (id_user, id_category, value, description, paid, payday, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
                $prepareInsert = mysqli_prepare($con, $insert);
                mysqli_stmt_bind_param($prepareInsert, 'iidsssss', $fieldUser, $fieldCategory, $fieldValue, $fieldDesc, $fieldPaid, $fieldPayday, $fieldCreatedAt, $fieldUpdatedAt);
            
                $fieldUser = $_SESSION['id'];
                $fieldCategory = 14;
                $fieldValue = $value;
                $fieldDesc = $description;
                $fieldPaid = 'n';
                $fieldPayday = date('Y-m-d');
                $fieldCreatedAt = $date;
                $fieldUpdatedAt = $date;
                
                $result = mysqli_stmt_execute($prepareInsert);
                mysqli_stmt_close($prepareInsert);
                if (!$result) {
                    //LOG
                }
                $update = "UPDATE lists SET 
                            updated_at = ?
                        WHERE id = ?
                        AND id_user = ?";

                $prepareUpdate = mysqli_prepare($con, $update);
                mysqli_stmt_bind_param($prepareUpdate, 'sii', $fieldUpdatedAt, $fieldId, $fieldUser);

                $fieldUpdatedAt = $date;
                $fieldId = $listId;
                $fieldUser = $_SESSION['id'];
            }
        }
        return true;
    } catch (Exception $e){
        return false;
    }
}

// R e a d
function items($id = null, $idItem = null){
    try{
        global $con;

        $sql = "SELECT 
                    id,
                    description,
                    value,
                    paid,
                    status
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

// R e a d
function getList($id, $idList = null){
    try{
        global $con;

        $sql = "SELECT 
                    l.id,
                    l.title,
                    l.description,
                    c.id,
                    c.description,
                    l.list_id,
                    CASE 
                        WHEN l.type = 'shopping'
                            THEN 'Compras'
                        ELSE 
                            'Lista'
                    END as type
                FROM lists l
                LEFT JOIN categories c on (c.id = l.id_category)
                WHERE l.id_user = " . $_SESSION['id'];

        if(!$idList){
            $sql .= " AND l.list_id = $id ";
        } else {
            $sql .= " AND l.id = $idList ";
        }

        $query = mysqli_query($con, $sql);
        $result = mysqli_fetch_all($query, MYSQLI_NUM);

        return $result;
    } catch(Exception $e){
        $result = [
            'success' => false,
            'redirect' => true,
            'message' => 'Erro inesperado',
            'error' => $e->getMessage()
        ];
    }
}

// U p d a t e
function updateItem($fields){
    try{
        global $con;
        $datetime = date('Y-m-d H:i:s');

        $update = "UPDATE items SET 
                    description = ?,
                    value = ?, 
                    updated_at = ?
                WHERE id = ?";

        $prepareUpdate = mysqli_prepare($con, $update);
        mysqli_stmt_bind_param($prepareUpdate, 'sdsi', $fieldDesc, $fieldValue, $fieldUpdated, $fieldId);

        $fieldDesc = $fields['description'];
        $fieldValue = $fields['value'];
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
function updateItemStatus($fields){
    try{
        global $con;
        $idItem = $fields['id'];

        $sql = "SELECT 
                    status
                FROM items
                WHERE id = $idItem ";

        $query = mysqli_query($con, $sql);
        $statusItem = mysqli_fetch_array($query, MYSQLI_NUM)[0];
        $newStatus = $statusItem == 'a' ? 'i' : 'a';

        $datetime = date('Y-m-d H:i:s');

        $update = "UPDATE items SET 
                    status = ?,
                    updated_at = ?
                WHERE id = ?";

        $prepareUpdate = mysqli_prepare($con, $update);
        mysqli_stmt_bind_param($prepareUpdate, 'ssi', $fieldStatus, $fieldUpdated, $fieldId);

        $fieldStatus = $newStatus;
        $fieldUpdated = $datetime;
        $fieldId = $idItem;
        if (!mysqli_stmt_execute($prepareUpdate)) {
            mysqli_stmt_close($prepareUpdate);
            return ['success' => false, 'message' => "Erro ao atualizar dados"];
        }

        mysqli_stmt_close($prepareUpdate);
        return ['success' => true, 'message' => "Dados atualizados", 'status' => $newStatus];
    } catch(Exception $e) {
        return ['success' => false, 'message' => "Erro ao atualizar dados", 'error' => $e];
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