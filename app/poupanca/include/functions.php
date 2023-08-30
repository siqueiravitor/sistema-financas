<?php
// C r e a t e
function registerFinance($description, $value){
  global $con;
  $date = date('Y-m-d H:i:s');

  $insert = "INSERT INTO finances (id_user, id_category, value, description, created_at, updated_at) 
    VALUES (?, ?, ?, ?, ?, ?)";

  $prepareInsert = mysqli_prepare($con, $insert);
  mysqli_stmt_bind_param($prepareInsert, 'iidsss', $fieldUser, $fieldCategory, $fieldValue, $fieldDesc, $fieldCreatedAt, $fieldUpdatedAt);

  $fieldUser = $_SESSION['id'];
  $fieldCategory = 1;
  $fieldValue = $value;
  $fieldDesc = $description;
  $fieldCreatedAt = $date;
  $fieldUpdatedAt = $date;

  $result = mysqli_stmt_execute($prepareInsert);
  if (!$result) {
    mysqli_stmt_close($prepareInsert);
    return false;
  }

  $id = mysqli_stmt_insert_id($prepareInsert);
  mysqli_stmt_close($prepareInsert);

  return $id;
}
function createSavings($fields){
    try{
        global $con;

        $insert = "INSERT INTO savings (id_user, id_finance, name, reserved, description, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $prepareInsert = mysqli_prepare($con, $insert);
        mysqli_stmt_bind_param($prepareInsert, 'iisdsss', $fieldIdUser, $fieldIdFinance, $fieldName, $fieldValue, $fieldDesc, $fieldCreatedAt, $fieldUpdatedAt);

        $datetime = date('Y-m-d H:i:s');
        $fieldIdUser = $_SESSION['id'];
        $fieldIdFinance = $fields['id_finance'];
        $fieldName = $fields['name'];
        $fieldValue = $fields['value'];
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
    } catch(Exception $e) {
        return ['success' => false, 'message' => "Erro ao criar poupança", 'error' => $e];
    }
}

// R e a d
function savings($id = null){
    global $con;

    $sql = "SELECT 
                id,
                name,
                description,
                reserved,
                goal,
                (CASE 
                    WHEN reserved < goal THEN goal - reserved 
                    ELSE 0
                END) as missing,
                id_user,
                id_finance
            FROM savings
            WHERE (id_user is null 
            OR id_user = " . $_SESSION['id'] . ")";
    if($id){
        $sql .= " AND id = $id ";
    }

    $query = mysqli_query($con, $sql);
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

    return $result;
}
function savingsFinance($id = null){
    global $con;

    $sql = "SELECT 
                reserved,
                id_finance
            FROM savings
            WHERE id = $id 
            AND (id_user is null 
            OR id_user = " . $_SESSION['id'] . ")";

    $query = mysqli_query($con, $sql);
    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

    return $result;
}


// U p d a t e
function updateSavings($fields){
    try{
        global $con;
        $datetime = date('Y-m-d H:i:s');

        $update = "UPDATE savings SET 
                    name = ?,
                    description = ?,
                    goal = ?,
                    updated_at = ?
                WHERE id = ?";

        $prepareUpdate = mysqli_prepare($con, $update);
        mysqli_stmt_bind_param($prepareUpdate, 'ssdsi', $fieldName, $fieldDesc, $fieldGoal, $fieldUpdated, $fieldId);

        $fieldName = $fields['name'];
        $fieldDesc = $fields['description'];
        $fieldGoal = $fields['goal'];
        $fieldUpdated = $datetime;
        $fieldId = $fields['id'];
        if (!mysqli_stmt_execute($prepareUpdate)) {
            mysqli_stmt_close($prepareUpdate);
            return ['success' => false, 'message' => "Erro ao atualizar dados"];
        }
        $finance = savingsFinance($fields['id']);
        $data = [
            'id_finance' => $finance['id_finance'],
            'description' => $fields['name']
        ];
        updateFinanceSavings($data);

        mysqli_stmt_close($prepareUpdate);
        return ['success' => true, 'message' => "Dados atualizados"];
    } catch(Exception $e) {
        return ['success' => false, 'message' => "Erro ao atualizar dados", 'error' => $e];
    }
}
function updateSavingsReserved($fields){
    try{
        global $con;
        $datetime = date('Y-m-d H:i:s');

        if($fields['savings_radio'] == 'save'){
            $update = "UPDATE savings SET 
                        reserved = (SELECT reserved FROM savings WHERE ID = ?) + ?,
                        updated_at = ?
                    WHERE id = ?";
        } else {
            $update = "UPDATE savings SET 
                        reserved = (SELECT reserved FROM savings WHERE ID = ?) - ?,
                        updated_at = ?
                    WHERE id = ?";
        }
        $prepareUpdate = mysqli_prepare($con, $update);
        mysqli_stmt_bind_param($prepareUpdate, 'idsi', $fieldIdReserved, $fieldReserved, $fieldUpdated, $fieldId);
        
        $fieldIdReserved = $fields['id'];
        $fieldReserved = $fields['value'];
        $fieldUpdated = $datetime;
        $fieldId = $fields['id'];
        if (!mysqli_stmt_execute($prepareUpdate)) {
            mysqli_stmt_close($prepareUpdate);
            return ['success' => false, 'message' => "Erro ao atualizar dados"];
        }
        $finance = savingsFinance($fields['id']);
        $data = [
            'id_finance' => $finance['id_finance'],
            'value' => $finance['reserved']
        ];
        updateFinanceReserved($data);

        mysqli_stmt_close($prepareUpdate);
        return ['success' => true, 'message' => "Dados atualizados"];
    } catch(Exception $e) {
        return ['success' => false, 'message' => "Erro ao atualizar dados", 'error' => $e];
    }
}
function updateFinanceReserved($fields){
    try{
        global $con;
        $datetime = date('Y-m-d H:i:s');

        $update = "UPDATE finances SET 
                    value = ?,
                    updated_at = ?
                WHERE id = ?";

        $prepareUpdate = mysqli_prepare($con, $update);
        mysqli_stmt_bind_param($prepareUpdate, 'dsi', $fieldValue, $fieldUpdated, $fieldId);

        $fieldValue = $fields['value'];
        $fieldUpdated = $datetime;
        $fieldId = $fields['id_finance'];
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
function updateFinanceSavings($fields){
    try{
        global $con;
        $datetime = date('Y-m-d H:i:s');

        $update = "UPDATE finances SET 
                    description = ?,
                    updated_at = ?
                WHERE id = ?";

        $prepareUpdate = mysqli_prepare($con, $update);
        mysqli_stmt_bind_param($prepareUpdate, 'ssi', $fieldDesc, $fieldUpdated, $fieldId);

        $fieldDesc = $fields['description'];
        $fieldUpdated = $datetime;
        $fieldId = $fields['id_finance'];
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
function deleteSavings($fields){
    try{
        global $con;

        $idSaving = $fields['id'];
        $idFinance = $fields['id_finance'];

        $sql = "DELETE FROM savings WHERE id = $idSaving AND id_user = " . $_SESSION['id'];
        $query = mysqli_query($con, $sql);

        if (!$query) {
            return ['success' => false, 'message' => "Erro ao deletar dados"];
        }
        $rows = mysqli_affected_rows($con);

        $sqlFinance = "DELETE FROM finances WHERE id = $idFinance AND id_user = " . $_SESSION['id'];
        mysqli_query($con, $sqlFinance);
        
        return ['success' => true, 'message' => "Dados apagados ($rows)"];
    } catch(Exception $e) {
        return ['success' => false, 'message' => "Erro ao atualizar dados", 'error' => $e];
    }
}