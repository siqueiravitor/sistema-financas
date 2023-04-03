<?php
// C o n s u l t
function categories()
{
  global $con;

  $sql = "SELECT 
            id,
            tipo,
            descricao
        FROM categoria
        ORDER BY tipo";

  $query = mysqli_query($con, $sql);
  $result = mysqli_fetch_all($query, MYSQLI_NUM);

  return $result;
}
function period($id = null)
{
  global $con;

  $sql = "SELECT 
            id,
            valor,
            descricao
        FROM periodo ";
  if ($id) {
    $sql .= " where id = $id ";
  }

  $query = mysqli_query($con, $sql);
  $result = mysqli_fetch_all($query, MYSQLI_NUM);

  return $result;
}
function financeValues(){
  global $con;

  $sql = "SELECT
            SUM(CASE WHEN c.tipo = 'e' THEN f.valor ELSE 0 END) as lucro,
            SUM(CASE WHEN c.tipo = 's' THEN f.valor ELSE 0 END) as despesa,
            SUM(CASE WHEN c.tipo = 'e' THEN f.valor ELSE -f.valor END) as total
          FROM financa f
          INNER JOIN categoria c ON (c.id = f.idcategoria)";

  $query = mysqli_query($con, $sql);
  $result = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];
  
  return $result;
}

function dataFinance($userId, $id = null)
{
  global $con;

  $sql = "SELECT 
            f.id,
            f.valor,
            f.descricao AS descricaoFinanca,
            CASE 
              WHEN f.pagamento = 'd'  THEN 'Dinheiro'
              WHEN f.pagamento = 'cc' THEN 'Crédito'
              WHEN f.pagamento = 'cd' THEN 'Débito'
              ELSE 'Pix'
            END as pagamento,
            CASE 
				        WHEN f.recorrente = 's' THEN 'Sim'
                ELSE 'Não'
			      END as recorrente,
            f.data,
            f.datager,
            CASE 
              WHEN c.tipo = 'e' THEN 'Entrada'
              ELSE 'Saída'
            END as tipo,
            c.descricao AS categoria
        FROM financa f
        INNER JOIN categoria c ON (c.id = f.idcategoria)
        WHERE idusuario = $userId";
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
  global $con;

  $sql = "SELECT 
            f.id,
            f.valor,
            f.descricao AS descricaoFinanca,
            CASE 
              WHEN f.pagamento = 'd'  THEN 'Dinheiro'
              WHEN f.pagamento = 'cc' THEN 'Crédito'
              WHEN f.pagamento = 'cd' THEN 'Débito'
              ELSE 'Pix'
            END as pagamento,
            CASE
              WHEN f.recorrente = 's' THEN 'Sim'
                  ELSE 'Não'
            END as recorrente,
            f.data,
            f.datager,
    
            CASE 
              WHEN c.tipo = 's' THEN 'Sim'
                  ELSE 'Não'
            END as tipo,
            c.descricao AS categoria,
    
            r.valor as valorParcelas,
            r.recorrencia,
            r.parcelas,
            CASE 
              WHEN r.status = 'p' THEN 'Pendente'
              WHEN r.status = 'f' THEN 'Finalizado'
              WHEN r.status = 'c' THEN 'Cancelado'
              ELSE 'Em andamento'
            END as statusRecorrecencia,

            p.descricao as periodo,
            p.valor as valorPeriodo
          FROM financa f
          INNER JOIN categoria c ON (c.id = f.idcategoria)
          INNER JOIN recorrencia r ON (r.idfinanca = f.id)
          INNER JOIN periodo p ON (p.id = r.idperiodo)
          WHERE idusuario = $userId
          AND f.id = $id ";

  $query = mysqli_query($con, $sql);
  $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

  return $result;
}
// R e g i s t e r
function registerFinance($fields)
{
  global $con;
  $recurrent = $fields['recurrent'] == 'u' ? 'n' : 's';

  $insert = "INSERT INTO financa (idusuario, idcategoria, valor, descricao, pagamento, recorrente, data) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";

  $prepareInsert = mysqli_prepare($con, $insert);
  mysqli_stmt_bind_param($prepareInsert, 'iidssss', $fieldUser, $fieldCategory, $fieldValue, $fieldDesc, $fieldPayment, $fieldRecurrent, $fieldDate);

  $fieldUser = $fields['iduser'];
  $fieldCategory = $fields['idcategory'];
  $fieldValue = $fields['value'];
  $fieldDesc = $fields['description'];
  $fieldPayment = $fields['payment'];
  $fieldRecurrent = $recurrent;
  $fieldDate = $fields['date'];

  $result = mysqli_stmt_execute($prepareInsert);
  if (!$result) {
    mysqli_stmt_close($prepareInsert);
    return false;
  }
  $id = mysqli_stmt_insert_id($prepareInsert);
  mysqli_stmt_close($prepareInsert);

  return $id;
}
function registerRecurrence($fields)
{
  global $con;
  $insert = "INSERT INTO recorrencia (idfinanca, idperiodo, valor, recorrencia, parcelas, datafim, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";

  $prepareInsert = mysqli_prepare($con, $insert);
  mysqli_stmt_bind_param($prepareInsert, 'iisssss', $idfinance, $idperiodo, $valor, $recorrencia, $parcelas, $datafim, $status);

  $idfinance = $fields['idfinance'];
  $idperiodo = $fields['period'];
  $valor = $fields['valueInstallment'];
  $recorrencia = $fields['recurrence'];
  $parcelas = $fields['installment'];
  $datafim = $fields['dateEnd'];
  $status = $fields['status'];

  $result = mysqli_stmt_execute($prepareInsert);
  if (!$result) {
    mysqli_stmt_close($prepareInsert);
    return false;
  }
  mysqli_stmt_close($prepareInsert);
  return true;
}
// U p d a t e
function updateFinance($fields)
{
  global $con;
  $recurrent = $fields['recurrent'] == 'u' ? 'n' : 's';

  $update = "UPDATE financa SET 
                idcategoria = ?, 
                valor = ?, 
                descricao = ?, 
                pagamento = ?, 
                recorrente = ?, 
                data = ?
            where id = ?";

  $prepareUpdate = mysqli_prepare($con, $update);
  mysqli_stmt_bind_param($prepareUpdate, 'idssssi', $fieldCategory, $fieldValue, $fieldDesc, $fieldPayment, $fieldRecurrent, $fieldDate, $fieldId);

  $fieldCategory = $fields['idcategory'];
  $fieldValue = $fields['value'];
  $fieldDesc = $fields['description'];
  $fieldPayment = $fields['payment'];
  $fieldRecurrent = $recurrent;
  $fieldDate = $fields['date'];
  $fieldId = $fields['id'];

  $result = mysqli_stmt_execute($prepareUpdate);
  if (!$result) {
    mysqli_stmt_close($prepareUpdate);
    return false;
  }
  $rows = mysqli_stmt_affected_rows($prepareUpdate);
  mysqli_stmt_close($prepareUpdate);

  return $result;
}

// D e l e t e
function deleteFinance($id, $mult = false)
{
  global $con;

  $where = "= $id";
  if ($mult) {
    $where = "in ($id)";
  }
  
  $sqlRecorrencia = "DELETE FROM recorrencia where idfinanca $where";
  if (mysqli_query($con, $sqlRecorrencia)) {
    $sql = "DELETE FROM financa where id $where";
  }

  $query = mysqli_query($con, $sql);
  if (!$query) {
    return $sql;
  }
  $rows = mysqli_affected_rows($con);

  return $rows;
}