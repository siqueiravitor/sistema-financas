<?php

function dataSystem() {
  global $con;

  $sql = "SELECT 
            empresa,
            nome,
            apelido,
            logo,
            logoalt,
            versao,
            status
          FROM sistema";

  $query = mysqli_query($con, $sql);
  $rows = mysqli_num_rows($query);
  $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
  array_unshift($result , $rows);

  return $result;
}
