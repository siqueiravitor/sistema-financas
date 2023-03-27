<?php

function categories() {
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
function dataFinance($userId) {
  global $con;

  $sql = "SELECT 
            f.id,
            c.descricao AS categoria,
            f.valor,
            f.descricao AS descFinanca,
            f.pagamento,
            f.recorrente,
            f.data,
            f.datager
        FROM financa f
        INNER JOIN categoria c ON (c.id = f.idcategoria)
        WHERE idusuario = $userId";

  $query = mysqli_query($con, $sql);
  $rows = mysqli_num_rows($query);
  $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
  array_unshift($result , $rows);

  return $result;
}

function registerFinance($fields){
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
  if(!$result){
    mysqli_stmt_close($prepareInsert);
    return false;
  }
  $id = mysqli_stmt_insert_id($prepareInsert);
  mysqli_stmt_close($prepareInsert);

  return $id;
}
function registerRecurrence($id, $recurrence){

  return;
}
function deleteFinance($id, $mult = false){
  global $con;

  $where = "id = $id";
  if($mult){
    $where = "id in ($id)";
  }
  $sql = "DELETE FROM financa where $where";
  
  $query = mysqli_query($con, $sql);
  if(!$query){
    return false;
  }
  $rows = mysqli_affected_rows($con);

  return $rows;
}
