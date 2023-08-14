<?php
// C r e a t e 
function registerFinance($fields)
{
  global $con;
  $recurrent = $fields['recurrent'] == 'u' ? 'n' : 'y';
  $paid = $fields['payment'] ? 'y' : 'n';
  $date = date('Y-m-d H:i:s');

  $insert = "INSERT INTO finances (id_user, id_category, value, description, paid, recurrent, payday, created_at, updated_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $prepareInsert = mysqli_prepare($con, $insert);
  mysqli_stmt_bind_param($prepareInsert, 'iidssssii', $fieldUser, $fieldCategory, $fieldValue, $fieldDesc, $fieldPayment, $fieldRecurrent, $fieldDate, $fieldCreatedAt, $fieldUpdatedAt);

  $fieldUser = $fields['iduser'];
  $fieldCategory = $fields['idcategory'];
  $fieldValue = $fields['value'];
  $fieldDesc = $fields['description'];
  $fieldPayment = $paid;
  $fieldRecurrent = $recurrent;
  $fieldDate = $fields['date'];
  $fieldCreatedAt = $date;
  $fieldUpdatedAt = $date;

  $result = mysqli_stmt_execute($prepareInsert);
  if (!$result) {
    mysqli_stmt_close($prepareInsert);
    return false;
  }
  $id = mysqli_stmt_insert_id($prepareInsert);
  mysqli_stmt_close($prepareInsert);

  if ($fields['payment']) {
    $insert = "INSERT INTO payments (id_finance, type, value, paid_at, created_at, updated_at) 
    VALUES (?, ?, ?, ?, ?, ?)";

    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'isdsii', $fieldIdFinance, $fieldType, $fieldValue, $fieldPaidAt, $fieldCreatedAt, $fieldUpdatedAt);

    $fieldIdFinance = $id;
    $fieldType = $fields['payment'];
    $fieldValue = $fields['value'];
    $fieldPaidAt = $fields['date'];
    $fieldCreatedAt = $date;
    $fieldUpdatedAt = $date;
  }

  return $id;
}
function registerRecurrence($fields)
{
  global $con;
  // $insert = "INSERT INTO recorrencia (idfinanca, idperiodo, valor, recorrencia, parcelas, datafim, status) 
  //   VALUES (?, ?, ?, ?, ?, ?, ?)";

  // $prepareInsert = mysqli_prepare($con, $insert);
  // mysqli_stmt_bind_param($prepareInsert, 'iisssss', $idfinance, $idperiodo, $valor, $recorrencia, $parcelas, $datafim, $status);

  // $idfinance = $fields['idfinance'];
  // $idperiodo = $fields['period'];
  // $valor = $fields['valueInstallment'];
  // $recorrencia = $fields['recurrence'];
  // $parcelas = $fields['installment'];
  // $datafim = $fields['dateEnd'];
  // $status = $fields['status'];

  // $result = mysqli_stmt_execute($prepareInsert);
  // if (!$result) {
  //   mysqli_stmt_close($prepareInsert);
  //   return false;
  // }
  // mysqli_stmt_close($prepareInsert);
  // return true;
}
// R e a d
function categories($id = null){
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
function financeValues(){
  global $con;
  $id_user = $_SESSION['id'];

  $sql = "SELECT
            SUM(CASE WHEN c.type = 'in' THEN f.value ELSE 0 END) as lucro,
            SUM(CASE WHEN c.type = 'out' THEN f.value ELSE 0 END) as despesa,
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
            CASE 
              WHEN p.type = 'p'  THEN 'Pix'
              WHEN p.type = 'm'  THEN 'Dinheiro'
              WHEN p.type = 'cc' THEN 'Crédito'
              WHEN p.type = 'dc' THEN 'Débito'
              ELSE 'Pendente'
            END as pagamento,
            CASE 
				        WHEN f.recurrent = 'y' THEN 'Sim'
                ELSE 'Não'
			      END as recorrente,
            f.payday as data,
            f.created_at as datager,
            CASE 
              WHEN c.type = 'in' THEN 'Entrada'
              ELSE 'Saída'
            END as tipo,
            c.description AS categoria
        FROM finances f
        LEFT JOIN payments p ON (p.id_finance = f.id)
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
function recurrence($userId, $id)
{
  // global $con;

  // $sql = "SELECT 
  //           f.id,
  //           f.value,
  //           f.description AS descricaoFinanca,
  //           CASE 
  //             WHEN p.type = 'p'  THEN 'Pix'
  //             WHEN p.type = 'm'  THEN 'Dinheiro'
  //             WHEN p.type = 'cc' THEN 'Crédito'
  //             WHEN p.type = 'dc' THEN 'Débito'
  //             ELSE 'Pendente'
  //           END as pagamento,
  //           CASE 
  // 			        WHEN f.recurrent = 'y' THEN 'Sim'
  //               ELSE 'Não'
  // 		      END as recorrente,
  //           f.payday as data,
  //           f.created_at as datager,

  //           CASE 
  //             WHEN c.type = 'in' THEN 'Entrada'
  //             ELSE 'Saída'
  //           END as tipo,
  //           c.description AS categoria

  //           r.valor as valorParcelas,
  //           r.recorrencia,
  //           r.parcelas,
  //           CASE 
  //             WHEN r.status = 'p' THEN 'Pendente'
  //             WHEN r.status = 'f' THEN 'Finalizado'
  //             WHEN r.status = 'c' THEN 'Cancelado'
  //             ELSE 'Em andamento'
  //           END as statusRecorrecencia,

  //           p.descricao as periodo,
  //           p.valor as valorPeriodo
  //         FROM financa f
  //         INNER JOIN categoria c ON (c.id = f.idcategoria)
  //         INNER JOIN recorrencia r ON (r.idfinanca = f.id)
  //         INNER JOIN periodo p ON (p.id = r.idperiodo)
  //         WHERE idusuario = $userId
  //         AND f.id = $id ";

  // $query = mysqli_query($con, $sql);
  // $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

  // return $result;
}
// U p d a t e
function updateFinance($fields)
{
  global $con;
  $paid = $fields['payment'] ? 'y' : 'n';
  $date = date('Y-m-d H:i:s');

  $update = "UPDATE finances SET 
                id_category = ?, 
                value = ?, 
                description = ?, 
                paid = ?, 
                payday = ?
            WHERE id = ?";

  $prepareUpdate = mysqli_prepare($con, $update);
  mysqli_stmt_bind_param($prepareUpdate, 'idsssi', $fieldCategory, $fieldValue, $fieldDesc, $fieldPayment, $fieldDate, $fieldId);

  $fieldCategory = $fields['idcategory'];
  $fieldValue = $fields['value'];
  $fieldDesc = $fields['description'];
  $fieldPayment = $paid;
  $fieldDate = $fields['date'];
  $fieldId = $fields['id'];

  if (!mysqli_stmt_execute($prepareUpdate)) {
    mysqli_stmt_close($prepareUpdate);
    return false;
  }

  if ($fields['payment']) {
    $insert = "INSERT INTO payments (id_finance, type, value, paid_at, created_at, updated_at) 
    VALUES (?, ?, ?, ?, ?, ?)";

    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'isdsii', $fieldIdFinance, $fieldType, $fieldValue, $fieldPaidAt, $fieldCreatedAt, $fieldUpdatedAt);

    $fieldIdFinance = $fieldId;
    $fieldType = $fields['payment'];
    $fieldValue = $fields['value'];
    $fieldPaidAt = $fields['date'];
    $fieldCreatedAt = $date;
    $fieldUpdatedAt = $date;
  }
  mysqli_stmt_close($prepareUpdate);
  return true;
}

// D e l e t e
function deleteFinance($id)
{
  global $con;

  $sqlRecorrencia = "DELETE FROM recurrencies WHERE id_finance IN ($id)";
  if (mysqli_query($con, $sqlRecorrencia)) {
    $sql = "DELETE FROM finances WHERE id IN ($id)";
  }

  $query = mysqli_query($con, $sql);
  if (!$query) {
    return "Erro ao deletar finança";
  }
  $rows = mysqli_affected_rows($con);

  return $rows;
}