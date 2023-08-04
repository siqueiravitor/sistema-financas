<?php

function dataSystem() {
  global $con;

  $sql = "SELECT 
            name,
            nickname,
            logo,
            logo_alt,
            version,
            status
          FROM systems";

  $query = mysqli_query($con, $sql);
  $rows = mysqli_num_rows($query);
  $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
  array_unshift($result , $rows);

  return $result;
}
