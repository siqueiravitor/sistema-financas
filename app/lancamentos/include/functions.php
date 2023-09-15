<?php
// C r e a t e 
function registerFinance($fields){
  try{
    global $con;
    $finance = $fields['finance'];
    $date = date('Y-m-d H:i:s');

    $insert = "INSERT INTO finances (id_user, id_category, value, description, recurrent, paid, payday, created_at, updated_at) 
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'iidssssss', $fieldUser, $fieldCategory, $fieldValue, $fieldDesc, $fieldRecurrent, $fieldPaid, $fieldPayday, $fieldCreatedAt, $fieldUpdatedAt);

    $fieldUser = $finance['iduser'];
    $fieldCategory = $finance['idcategory'];
    $fieldValue = $finance['value'];
    $fieldDesc = $finance['description'];
    $fieldRecurrent = $finance['recurrent'];
    $fieldPaid = $finance['paid'];
    $fieldPayday = $finance['payday'];
    $fieldCreatedAt = $date;
    $fieldUpdatedAt = $date;

    $result = mysqli_stmt_execute($prepareInsert);
    if (!$result) {
      mysqli_stmt_close($prepareInsert);
      genLog('finances', 'register', "Erro ao registrar", 'error');

      return ['success' => false];
    }
    genLog('finances', 'register', "Dados registrados", 'success');

    $id = mysqli_stmt_insert_id($prepareInsert);
    mysqli_stmt_close($prepareInsert);

    return ['success' => true, 'id' => $id];
      
  } catch (Exception $e) {
    genLog('finances', 'exception', $e->getMessage(), 'register');

    return ['success' => false, 'message' => 'Erro ao registrar finança', 'error' => $e->getMessage()];
  }
}

function registerPayment($fields){
  try{
    global $con;
    $date = date('Y-m-d H:i:s');

    $insert = "INSERT INTO payments (id_finance, id_type, value, created_at, updated_at) 
    VALUES (?, ?, ?, ?, ?)";

    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'iidss', $fieldIdFinance, $fieldType, $fieldValue, $fieldCreatedAt, $fieldUpdatedAt);

    $fieldIdFinance = $fields['id_finance'];
    $fieldType = $fields['type'];
    $fieldValue = $fields['value'];
    $fieldCreatedAt = $date;
    $fieldUpdatedAt = $date;

    $result = mysqli_stmt_execute($prepareInsert);
    if (!$result) {
      genLog('payments', 'register', "Erro ao registrar", 'error');
      mysqli_stmt_close($prepareInsert);

      return ['success' => false, 'message' => 'Erro ao registrar pagamento'];
    }
    genLog('payments', 'register', "Dados registrados", 'success');

    mysqli_stmt_close($prepareInsert);

    return ['success' => true];

  } catch (Exception $e) {
    genLog('payments', 'exception', $e->getMessage(), 'register');

    return ['success' => false, 'message' => 'Erro ao registrar pagamento', 'error' => $e->getMessage()];
  }
}

function registerRecurrence($fields){
  try{
    global $con;
    $date = date('Y-m-d H:i:s');
    $recurrencies = $fields['recurrence'];

    $insert = "INSERT INTO recurrencies (value, type, status, recurrence, period, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'dsssiss', $fieldValue, $fieldType, $fieldStatus, $fieldRecurrence, $fieldPeriod, $fieldCreatedAt, $fieldUpdatedAt);

    $fieldValue = $recurrencies['value'];
    $fieldType = $recurrencies['type'];
    $fieldStatus = $recurrencies['status'];
    $fieldRecurrence = $recurrencies['recurrence'];
    $fieldPeriod = $recurrencies['period'];
    $fieldCreatedAt = $date;
    $fieldUpdatedAt = $date;

    $result = mysqli_stmt_execute($prepareInsert);

    if (!$result) {
      genLog('recurrencies', 'register', "Erro ao registrar", 'error');
      mysqli_stmt_close($prepareInsert);
      return false;
    }
    genLog('recurrencies', 'register', "Dados registrados", 'success');

    $id_recurrence = mysqli_stmt_insert_id($prepareInsert);
    mysqli_stmt_close($prepareInsert);
    return $id_recurrence;

  } catch (Exception $e) {
    genLog('recurrencies', 'exception', $e->getMessage(), 'register');

    return ['success' => false, 'message' => 'Erro ao registrar recorrência', 'error' => $e->getMessage()];
  }
}
function registerRecurrenceFixed($fields){
  try {
    global $con;

    $fixed = $fields['fixed'];
    $date = date('Y-m-d H:i:s');

    $insert = "INSERT INTO recurrencies_fixed (id_recurrence, value, payday, created_at, updated_at)
              VALUES (?, ?, ?, ?, ?)";

    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'idsss', $fieldIdRecurrence, $fieldValue, $fieldPayday, $fieldCreatedAt, $fieldUpdatedAt);

    $fieldIdRecurrence = $fixed['id_recurrence'];
    $fieldValue = $fixed['value'];
    $fieldPayday = $fixed['payday'];
    $fieldCreatedAt = $date;
    $fieldUpdatedAt = $date;

    $result = mysqli_stmt_execute($prepareInsert);
    if (!$result) {
      mysqli_stmt_close($prepareInsert);
      genLog('recurrencies_fixed', 'register', "Erro ao registrar fixa", 'error');

      return ['success' => false, 'message' => 'Erro ao registrar recorrência fixa'];
    }
    genLog('recurrencies_fixed', 'register', "Dados registrados", 'success');

    mysqli_stmt_close($prepareInsert);

    return ['success' => true];

  } catch (Exception $e) {
    genLog('recurrencies_fixed', 'exception', $e->getMessage(), 'register');

    return ['success' => false, 'message' => 'Erro ao registrar recorrência fixa', 'error' => $e->getMessage()];
  }
}
function finance_recurrence($fields){
  try{
    global $con;
    $success = true;
    $date = date('Y-m-d H:i:s');
    $insert = "INSERT INTO finance_recurrence (id_finance, id_recurrence, created_at, updated_at)
                  VALUES (?, ?, ?, ?)";

    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'iiss', $fieldIdFinance, $fieldIdRecurrence, $fieldCreatedAt, $fieldUpdatedAt);

    $fieldIdFinance = $fields['id_finance'];
    $fieldIdRecurrence = $fields['id_recurrence'];
    $fieldCreatedAt = $date;
    $fieldUpdatedAt = $date;

    if (!mysqli_stmt_execute($prepareInsert)) {
      $success = false;

      genLog('finance_recurrence', 'link', "Erro ao vincular", 'error');
    }
    genLog('finance_recurrence', 'link', "Dados vinculados", 'success');

    mysqli_stmt_close($prepareInsert);

    return ['success' => $success];

  } catch (Exception $e) {
    genLog('finance_recurrence', 'exception', $e->getMessage(), 'link');

    return ['success' => false, 'message' => 'Erro ao vincular finança-recorrência', 'error' => $e->getMessage()];
  }
}
function repeatFixedRecurrence($idUser, $idFinance, $value){
  global $con;
  $sql = "SELECT 
            f.id_category as idcategory,
            f.value,
            f.payday,
            f.recurrent,
            r.period,
            r.recurrence,
            concat('+', r.period, ' ', r.recurrence) as newPeriod
          FROM finances f
          INNER JOIN finance_recurrence fr ON (fr.id_finance = f.id)
          INNER JOIN recurrencies r ON (r.id = fr.id_recurrence)
          WHERE f.id_user = $idUser
          AND f.id = $idFinance";

  $query = mysqli_query($con, $sql);
  $dataFinance = mysqli_fetch_array($query, MYSQLI_NUM);
  $idcategory = $dataFinance[0];
  $payday = $dataFinance[2];
  $recurrent = $dataFinance[3];
  $period = $dataFinance[4];
  $recurrence = $dataFinance[5];

  if($recurrent){
    $fields['finance'] = [
      'iduser' => $idUser,
      'idcategory' => $idcategory,
      'value' => $value,
      'description' => null,
      'recurrent' => 'y',
      'paid' => 'n',
      'payday' => dateChange($payday, $period, $recurrence)
    ];

    registerFinance($fields);
  }

  return true;
}
// R e a d
function categories($id = null){
  global $con;
  $sql = "SELECT 
            id,
            type,
            description
        FROM categories
        WHERE type != 'save'
        AND (id_user = $id
        OR id_user is null)
        ORDER BY type";

  $query = mysqli_query($con, $sql);
  $result = mysqli_fetch_all($query, MYSQLI_NUM);

  return $result;
}
function paymentType($id = null){
  global $con;
  $sql = "SELECT 
            id,
            description
        FROM payment_type
        WHERE id_user = $id
        OR id_user is null";

  $query = mysqli_query($con, $sql);
  $result = mysqli_fetch_all($query, MYSQLI_NUM);

  return $result;
}
function financeValues($date = null){
  global $con;
  $id_user = $_SESSION['id'];

  $sql = "SELECT
            SUM(CASE WHEN c.type = 'in' THEN f.value ELSE 0 END) AS receita,
            SUM(CASE WHEN c.type = 'in' AND paid = 'n'THEN f.value ELSE 0 END) AS receber,
            SUM(CASE 
                  WHEN (c.type = 'in' AND paid = 'y') OR (sf.entry = 'out')
                    THEN f.value 
                  ELSE 0 
                END) AS recebido,
            SUM(CASE WHEN c.type = 'out' THEN f.value ELSE 0 END) AS despesa,
            SUM(CASE WHEN c.type = 'out' AND paid = 'n' THEN f.value ELSE 0 END) AS pagar,
            SUM(CASE 
                  WHEN (c.type = 'out' AND paid = 'y') OR (sf.entry = 'in')
                    THEN f.value
                  ELSE 0 
                END) AS pago,
            SUM(CASE 
                  WHEN c.type = 'in' OR sf.entry = 'out'
                    THEN f.value 
                  ELSE -f.value 
                END) AS total,
            SUM(CASE 
                  WHEN (c.type = 'in' and paid = 'y') OR (sf.entry = 'out')
                    THEN f.value 
                  ELSE if((c.type = 'out' and paid = 'y') OR (sf.entry = 'in'), -f.value, 0) 
                END) AS totalRecebido
          FROM finances f
          INNER JOIN categories c ON (c.id = f.id_category)
          LEFT JOIN savings_finances sf ON (sf.id_finance = f.id)
          WHERE f.id_user = $id_user";
  if($date){
    if($date['month'] && $date['year']){
      $month = getDateType($date['month'])['monthTxt'];
      $year = $date['year'];
      $sql .= " AND MONTHNAME(f.payday) = '$month' ";
      $sql .= " AND YEAR(f.payday) = '$year' ";
      
    } elseif($date['year']){
      $year = $date['year'];
      $sql .= " AND YEAR(f.payday) = '$year' ";
      
    } elseif($date['month']){
      $month = getDateType($date['month'])['monthTxt'];
      $sql .= " AND MONTHNAME(f.payday) = '$month' ";
      
    } else {
      $today = date('Y-m-d');
      $sql .= " AND MONTHNAME(f.payday) = $today ";
      $sql .= " AND YEAR(f.payday) = $today ";
    }
  }

  $query = mysqli_query($con, $sql);
  $result = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

  return $result;
}

function dataFinance($userId, $id = null, $date = null){
  global $con;

  $sql = "SELECT 
            f.id,
            f.value as valor,
            f.description AS descricaoFinanca,
            IF(f.paid = 'y', pt.description, '-') as pagamento,
            p.value as valorPagamento,
            CASE 
				        WHEN f.recurrent = 'y' THEN '&#10003'
                ELSE '-'
			      END as recorrente,
            f.payday as dataPagamento,
            CASE 
              WHEN c.type = 'in' THEN 'Entrada'
              ELSE 'Saída'
            END as tipo,
            c.description AS categoria,
            c.id as idCategory
        FROM finances f
        INNER JOIN categories c ON (c.id = f.id_category)
        LEFT JOIN payments p ON (p.id_finance = f.id)
        LEFT JOIN payment_type pt ON (pt.id = p.id_type)
        LEFT JOIN finance_recurrence fr ON (fr.id_finance = f.id)
        LEFT JOIN recurrencies r ON (r.id = fr.id_recurrence)
        LEFT JOIN recurrencies_fixed rf ON (rf.id_recurrence = r.id)
        WHERE f.id_user = $userId";
  if($date){
    if($date['month'] && $date['year']){
      $month = getDateType($date['month'])['monthTxt'];
      $year = $date['year'];
      $sql .= " AND MONTHNAME(f.payday) = '$month' ";
      $sql .= " AND YEAR(f.payday) = '$year' ";
      
    } elseif($date['year']){
      $year = $date['year'];
      $sql .= " AND YEAR(f.payday) = '$year' ";
      
    } elseif($date['month']){
      $month = getDateType($date['month'])['monthTxt'];
      $sql .= " AND MONTHNAME(f.payday) = '$month' ";
      
    } else {
      $today = date('Y-m-d');
      $sql .= " AND MONTHNAME(f.payday) = $today ";
      $sql .= " AND YEAR(f.payday) = $today ";
    }
  }
  if ($id) {
    $sql .= " AND f.id = $id ";
  }
  $sql .= " ORDER BY 
              CASE 
                WHEN idCategory = 1 THEN 2 
                ELSE 1
              END,
              CASE 
                WHEN pagamento = '-' THEN 1 
                ELSE 2 
              END,  
            dataPagamento";

  $query = mysqli_query($con, $sql);
  $rows = mysqli_num_rows($query);
  $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
  array_unshift($result, $rows);

  return $result;
}
function recurrence($userId, $id){
  global $con;

  $sql = "SELECT 
            *
          FROM recurrencies
          WHERE id_user = $userId 
          AND id_finance = $id";

  $query = mysqli_query($con, $sql);
  $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

  return $result;
}
// U p d a t e
function updateFinance($fields){
  try{
    global $con;

    if ($fields['paid']) {
      $update = "UPDATE finances SET 
                  id_category = ?, 
                  value = ?, 
                  description = ?,
                  paid = ?
              WHERE id = ?";

      $prepareUpdate = mysqli_prepare($con, $update);
      mysqli_stmt_bind_param($prepareUpdate, 'idssi', $fieldCategory, $fieldValue, $fieldDesc, $fieldPaid, $fieldId);

      $fieldCategory = $fields['idcategory'];
      $fieldValue = $fields['value'];
      $fieldDesc = $fields['description'];
      $fieldPaid = $fields['paid'];
      $fieldId = $fields['id'];
    } else {
      $update = "UPDATE finances SET 
                    id_category = ?, 
                    value = ?, 
                    description = ?
                  WHERE id = ?";

      $prepareUpdate = mysqli_prepare($con, $update);
      mysqli_stmt_bind_param($prepareUpdate, 'idsi', $fieldCategory, $fieldValue, $fieldDesc, $fieldId);

      $fieldCategory = $fields['idcategory'];
      $fieldValue = $fields['value'];
      $fieldDesc = $fields['description'];
      $fieldId = $fields['id'];
    }
    if (!mysqli_stmt_execute($prepareUpdate)) {
      mysqli_stmt_close($prepareUpdate);
      genLog('finances', 'update', "Erro ao atualizar", 'error');

      return ['success' => false, 'message' => "Erro ao atualizar dados"];
    }
    genLog('finances', 'update', "Dados atualizados", 'success');

    mysqli_stmt_close($prepareUpdate);
    return ['success' => true, 'message' => "Dados atualizados"];
    
  } catch (Exception $e) {
    genLog('finances', 'exception', $e->getMessage(), 'update');

    return ['success' => false, 'message' => 'Erro ao atualizar finança', 'error' => $e->getMessage()];
  }
}

// D e l e t e
function deleteFinance($id){
  try{
    global $con;

    $sqlVerifyLink = "SELECT fr.id_recurrence 
                        FROM finance_recurrence fr 
                        INNER JOIN finances f on (f.id = fr.id_finance)
                        WHERE fr.id_finance IN ($id) and f.id_user=" . $_SESSION['id'];
    $verifyLink = mysqli_query($con, $sqlVerifyLink);
    while ($recurrence = mysqli_fetch_array($verifyLink)) {
      //Delete Link
      $sqlRecurrence = "DELETE FROM finance_recurrence WHERE id_recurrence = $recurrence[0]";
      // logDelete(mysqli_query($con, $sqlRecurrence), 'finance_recurrence');
      if(mysqli_query($con, $sqlRecurrence)){
        genLog('finances', 'link', "Dados deletados", 'success');
      } else {
        genLog('finances', 'link', "Erro ao deletar", 'error');
      }

      //Delete recurrencies
      $sqlRecurrenceFixed = "DELETE FROM recurrencies_fixed 
                              WHERE id_recurrence = $recurrence[0]";
      // logDelete(mysqli_query($con, $sqlRecurrenceFixed), 'recurrencies_fixed');
      mysqli_query($con, $sqlRecurrenceFixed);

      $sqlRecurrence = "DELETE FROM recurrencies WHERE id =$recurrence[0]";
      // logDelete(mysqli_query($con, $sqlRecurrence), 'recurrencies');
      mysqli_query($con, $sqlRecurrence);
    }
    //Delete payments
    $sqlPayment = "DELETE FROM payments WHERE id_finance IN ($id)";
    // logDelete(mysqli_query($con, $sqlPayment), 'payments');
    mysqli_query($con, $sqlPayment);

    //Delete finances
    $sql = "DELETE FROM finances WHERE id IN ($id) and id_user=" . $_SESSION['id'];

    $query = mysqli_query($con, $sql);
    if (!$query) {
      genLog('finances', 'delete', "Erro ao deletar", 'error');

      return ['success' => false, 'message' => "Erro ao deletar dados"];
    }
    $rows = mysqli_affected_rows($con);
    genLog('finances', 'delete', "Dados deletados", 'success');

    return ['success' => true, 'message' => "Dados apagados ($rows)"];
      
  } catch (Exception $e) {
    genLog('finances', 'exception', $e->getMessage(), 'delete');

    return ['success' => false, 'message' => 'Erro ao deletar finança', 'error' => $e->getMessage()];
  }
}

function logDelete($param, $table){
  if($param){
    genLog($table, 'delete', "Dados deletados", 'success');
  } else {
    genLog($table, 'delete', "Erro ao deletar", 'error');
  }
}