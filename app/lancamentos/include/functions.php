<?php
// C r e a t e 
function registerFinance($fields)
{
  global $con;
  $finance = $fields['finance'];
  $date = date('Y-m-d H:i:s');

  $insert = "INSERT INTO finances (id_user, id_category, value, description, paid, recurrent, created_at, updated_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

  $prepareInsert = mysqli_prepare($con, $insert);
  mysqli_stmt_bind_param($prepareInsert, 'iidsssss', $fieldUser, $fieldCategory, $fieldValue, $fieldDesc, $fieldPaid, $fieldRecurrent, $fieldCreatedAt, $fieldUpdatedAt);

  $fieldUser = $finance['iduser'];
  $fieldCategory = $finance['idcategory'];
  $fieldValue = $finance['value'];
  $fieldDesc = $finance['description'];
  $fieldPaid = $finance['paid'];
  $fieldRecurrent = $finance['recurrent'];
  $fieldCreatedAt = $date;
  $fieldUpdatedAt = $date;

  $result = mysqli_stmt_execute($prepareInsert);
  if (!$result) {
    mysqli_stmt_close($prepareInsert);
    return ['success' => false];
  }

  $id = mysqli_stmt_insert_id($prepareInsert);
  mysqli_stmt_close($prepareInsert);

  return ['success' => true, 'id' => $id];
}

function registerPayment($id_finance, $fields){
  global $con;
  $date = date('Y-m-d H:i:s');

  $insert = "INSERT INTO payments (id_finance, id_type, value, created_at, updated_at) 
  VALUES (?, ?, ?, ?, ?)";

  $prepareInsert = mysqli_prepare($con, $insert);
  mysqli_stmt_bind_param($prepareInsert, 'iidss', $fieldIdFinance, $fieldType, $fieldValue, $fieldCreatedAt, $fieldUpdatedAt);

  $fieldIdFinance = $id_finance;
  $fieldType = $fields['type'];
  $fieldValue = $fields['value'];
  $fieldCreatedAt = $date;
  $fieldUpdatedAt = $date;

  $result = mysqli_stmt_execute($prepareInsert);
  if (!$result) {
    mysqli_stmt_close($prepareInsert);
    return ['success' => false, 'message' => 'Erro ao registrar pagamento'];
  }
  mysqli_stmt_close($prepareInsert);

  return ['success' => true];
}

function registerRecurrence($id_finance, $fields){
  global $con;
  $date = date('Y-m-d H:i:s');
  $recurrencies = $fields['recurrence'];

  $insert = "INSERT INTO recurrencies (id_finance, value, type, status, recurrence, period, created_at, updated_at) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

  $prepareInsert = mysqli_prepare($con, $insert);
  mysqli_stmt_bind_param($prepareInsert, 'idsssiss', $fieldIdFinance, $fieldValue, $fieldType, $fieldStatus, $fieldRecurrence, $fieldPeriod, $fieldCreatedAt, $fieldUpdatedAt);

  $fieldIdFinance = $id_finance;
  $fieldValue = $recurrencies['value'];
  $fieldType = $recurrencies['type'];
  $fieldStatus = $recurrencies['status'];
  $fieldRecurrence = $recurrencies['recurrence'];
  $fieldPeriod = $recurrencies['period'];
  $fieldCreatedAt = $date;
  $fieldUpdatedAt = $date;

  $result = mysqli_stmt_execute($prepareInsert);

  if (!$result) {
    mysqli_stmt_close($prepareInsert);
    return false;
  }
  
  $id_recurrence = mysqli_stmt_insert_id($prepareInsert);
  mysqli_stmt_close($prepareInsert);
  return $id_recurrence;
}
function registerRecurrenceFixed($id_recurrence, $fields){
  try {
    global $con;
    
    $fixed = $fields['fixed'];
    $date = date('Y-m-d H:i:s');

    $insert = "INSERT INTO recurrencies_fixed (id_recurrence, value, paid, payday, created_at, updated_at)
              VALUES (?, ?, ?, ?, ?, ?)";

    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'idssss', $fieldIdRecurrence, $fieldValue, $fieldPaid, $fieldPayday, $fieldCreatedAt, $fieldUpdatedAt);

    $fieldIdRecurrence = $id_recurrence;
    $fieldValue = $fixed['value'];
    $fieldPaid = $fixed['paid'];
    $fieldPayday = $fixed['payday'];
    $fieldCreatedAt = $date;
    $fieldUpdatedAt = $date;

    $result = mysqli_stmt_execute($prepareInsert);
    if (!$result) {
      mysqli_stmt_close($prepareInsert);
      return ['success' => false, 'message' => 'Erro ao registrar recorrência fixa'];
    }
    mysqli_stmt_close($prepareInsert);

    return ['success' => true];
  } catch (Exception $e) {
    return ['success' => false, 'message' => $e];
  }
}
// R e a d
function categories($id = null)
{
  global $con;
  $sql = "SELECT 
            id,
            type,
            description
        FROM categories
        WHERE id_user = $id
        ORDER BY type";

  $query = mysqli_query($con, $sql);
  $result = mysqli_fetch_all($query, MYSQLI_NUM);

  return $result;
}
function paymentType($id = null)
{
  global $con;
  $sql = "SELECT 
            id,
            description
        FROM payment_type
        WHERE id_user = $id";

  $query = mysqli_query($con, $sql);
  $result = mysqli_fetch_all($query, MYSQLI_NUM);

  return $result;
}
function financeValues()
{
  global $con;
  $id_user = $_SESSION['id'];

  $sql = "SELECT
            SUM(CASE WHEN c.type = 'in' THEN f.value ELSE 0 END) as receita,
            SUM(CASE WHEN c.type = 'in' AND paid = 'n' THEN f.value ELSE 0 END) as receber,
            SUM(CASE WHEN c.type = 'in' AND paid = 'y' THEN f.value ELSE 0 END) as recebido,
            SUM(CASE WHEN c.type = 'out' THEN f.value ELSE 0 END) as despesa,
            SUM(CASE WHEN c.type = 'out' AND paid = 'n' THEN f.value ELSE 0 END) as pagar,
            SUM(CASE WHEN c.type = 'out' AND paid = 'y' THEN f.value ELSE 0 END) as pago,
            SUM(CASE WHEN c.type = 'in' THEN f.value ELSE -f.value END) as total
          FROM finances f
          INNER JOIN categories c ON (c.id = f.id_category)
          WHERE f.id_user = $id_user";

  $query = mysqli_query($con, $sql);
  $result = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

  return $result;
}

function dataFinance($userId, $id = null)
{
  global $con;

  $sql = "SELECT 
            f.id,
            f.value as valor,
            f.description AS descricaoFinanca,
            IF(pt.description, pt.description, '-') as pagamento,
            p.value as valorPagamento,
            CASE 
				        WHEN f.recurrent = 'y' THEN 'Sim'
                ELSE '-'
			      END as recorrente,
            f.created_at as datager,
            CASE 
              WHEN c.type = 'in' THEN 'Entrada'
              ELSE 'Saída'
            END as tipo,
            c.description AS categoria
        FROM finances f
        LEFT JOIN payments p ON (p.id_finance = f.id)
        LEFT JOIN payment_type pt ON (pt.id = p.id_type)
        INNER JOIN categories c ON (c.id = f.id_category)
        WHERE f.id_user = $userId";
  if ($id) {
    $sql .= " AND f.id = $id ";
  }

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
function updateFinance($fields)
{
  global $con;

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

  if (!mysqli_stmt_execute($prepareUpdate)) {
    mysqli_stmt_close($prepareUpdate);
    return ['success' => false, 'message' => "Erro ao atualizar dados"];
  }

  mysqli_stmt_close($prepareUpdate);
  return ['success' => true, 'message' => "Dados atualizados"];
}

// D e l e t e
function deleteFinance($id)
{
  global $con;
  $sqlVerifyFinance = "SELECT 1 FROM finances WHERE id IN ($id) AND id_user=" . $_SESSION['id'];
  $verifyFinance = mysqli_query($con, $sqlVerifyFinance);
  if (mysqli_num_rows($verifyFinance)) {
    //Deletar recorrencias
    $sqlRecurrenceFixed = "DELETE FROM recurrencies_fixed 
                            WHERE id > 0 and id_recurrence in (SELECT id FROM recurrencies WHERE id_finance IN ($id))";
    mysqli_query($con, $sqlRecurrenceFixed);

    $sqlRecurrence = "DELETE FROM recurrencies WHERE id_finance IN ($id)";
    mysqli_query($con, $sqlRecurrence);
    
    //Deletar pagamentos
    $sqlPayment = "DELETE FROM payments WHERE id_finance IN ($id)";
    mysqli_query($con, $sqlPayment);
    
    //Deletar finanças
    $sql = "DELETE FROM finances WHERE id IN ($id) and id_user=" . $_SESSION['id'];

    $query = mysqli_query($con, $sql);
    if (!$query) {
      return ['success' => false, 'message' => "Erro ao deletar dados"];
    }
    $rows = mysqli_affected_rows($con);
  
    return ['success' => true, 'message' => "Dados apagados ($rows)"];
  } else {
    return ['success' => false];
  }
}
