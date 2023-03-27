<?php
function getUserIP()
{
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}

function verifyUser($user, $password) {
    global $con;

    $sql = "SELECT id, nome, email, status FROM usuario 
    WHERE login = '$user' and senha = '$password' ";

    $query = mysqli_query($con, $sql);
    $rows = mysqli_num_rows($query);
    $result = mysqli_fetch_all($query);
    array_unshift($result , $rows);

    return $result;
}

function checkUserExists($user, $email){
    global $con;

    $sql = "SELECT 1 status FROM usuario 
    WHERE login = '$user' or email = '$email'";

    $query = mysqli_query($con, $sql);
    $rows = mysqli_num_rows($query);

    return $rows;
}

function createUser($fields){
    global $con;
    
    $insert = "INSERT INTO usuario (nome, email, login, senha) VALUES (?, ?, ?, ?)";
    
    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'ssss', $fieldName, $fieldEmail, $fieldLogin, $fieldPassword);

    $fieldName = $fields['name'];
    $fieldEmail = $fields['email'];
    $fieldLogin = $fields['login'];
    $fieldPassword = $fields['password'];

    $result = mysqli_stmt_execute($prepareInsert);
    if(!$result){
        mysqli_stmt_close($prepareInsert);
        return false;
    }
    $id = mysqli_stmt_insert_id($prepareInsert);
    mysqli_stmt_close($prepareInsert);

    return $id;
}