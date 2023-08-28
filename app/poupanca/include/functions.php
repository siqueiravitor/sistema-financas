<?php
// C r e a t e
function registerFinance($description){
  global $con;
  $date = date('Y-m-d H:i:s');

  $insert = "INSERT INTO finances (id_user, id_category, value, description, created_at, updated_at) 
    VALUES (?, ?, ?, ?, ?, ?)";

  $prepareInsert = mysqli_prepare($con, $insert);
  mysqli_stmt_bind_param($prepareInsert, 'iidsss', $fieldUser, $fieldCategory, $fieldValue, $fieldDesc, $fieldCreatedAt, $fieldUpdatedAt);

  $fieldUser = $_SESSION['id'];
  $fieldCategory = 1;
  $fieldValue = 0;
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

        $insert = "INSERT INTO savings (id_user, id_finance, name, description, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?)";

        $prepareInsert = mysqli_prepare($con, $insert);
        mysqli_stmt_bind_param($prepareInsert, 'iissss', $fieldIdUser, $fieldIdFinance, $fieldName, $fieldDesc, $fieldCreatedAt, $fieldUpdatedAt);

        $datetime = date('Y-m-d H:i:s');
        $fieldIdUser = $_SESSION['id'];
        $fieldIdFinance = $fields['id_finance'];
        $fieldName = $fields['name'];
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
                id_user
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

// U p d a t e
function updateSavings($fields){
    global $con;

    return;
}

// D e l e t e 
function deleteSavings($fields){
    global $con;

    $idSaving = $fields['id'];
    $idFinance = $fields['id_finance'];

    $sqlFinance = "DELETE FROM finances WHERE id = $idFinance AND id_user = " . $_SESSION['id'];
    mysqli_query($con, $sqlFinance);

    $sql = "DELETE FROM savings WHERE id = $idSaving AND id_user = " . $_SESSION['id'];

    $query = mysqli_query($con, $sql);
    if (!$query) {
        return ['success' => false, 'message' => "Erro ao deletar dados"];
    }
    $rows = mysqli_affected_rows($con);

    return ['success' => true, 'message' => "Dados apagados ($rows)"];
}