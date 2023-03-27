<?php

function select($table, $columns = "*", $where = "") {
  global $con;

  $sql = "SELECT $columns FROM $table";
  if (!empty($where)) {
    $sql .= " WHERE $where";
  }

  $query = mysqli_query($con, $sql);
  $rows = mysqli_num_rows($query);
  $result = mysqli_fetch_all($query);
  array_unshift($result , $rows);

  return $result;
}
function insert($data, $types, $table, $fieldsName, $fieldsParam) {
  global $con;
  
  //INSERT INTO user (name, email, login, pass) VALUES (?, ?, ?, ?)
  $insert = "INSERT INTO $table ($fieldsName) VALUES ($fieldsParam)";

  $prepare = mysqli_prepare($con, $insert);
  // ($insert, 'ssss', $name, $email, $login, $pass);
  mysqli_stmt_bind_param($prepare, $types, $value1, $value2, $value3, $value4);

  $value1 = $data[0]; // $name = 
  $value2 = $data[1]; // $email = 
  $value3 = $data[2]; // $login = 
  $value4 = $data[3]; // $pass = 

  $result = mysqli_stmt_execute($prepare);
  mysqli_stmt_close($prepare);
  if(!$result){ return false; }
  
  $id = mysqli_stmt_insert_id($prepare);
  return $id;
}

function update($table, $data, $where = "") {
  global $conn;
  $set = "";
  foreach ($data as $column => $value) {
    $set .= "$column = '$value', ";
  }
  $set = rtrim($set, ", ");
  $sql = "UPDATE $table SET $set";
  if (!empty($where)) {
    $sql .= " WHERE $where";
  }
  $result = mysqli_query($conn, $sql);
  return $result;
}

function delete($table, $where = "") {
  global $conn;
  $sql = "DELETE FROM $table";
  if (!empty($where)) {
    $sql .= " WHERE $where";
  }
  $result = mysqli_query($conn, $sql);
  return $result;
}

// printf("%d Row inserted.\n", mysqli_stmt_affected_rows($stmt));
// printf("%d Row deleted.\n", mysqli_affected_rows($link));

?>