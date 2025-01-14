<?php
function getUserIP(){
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
function verifyUser($user, $password){
    global $con;

    $sql = "SELECT 
                id, 
                name, 
                email,
                password,
                CASE
                    WHEN status = 'i' THEN 'inativado'
                    WHEN status in ('b1','b2') THEN 'bloqueado'
                    ELSE 'a'
                END as status
            FROM users
            WHERE login = '$user'";
    
    $query = mysqli_query($con, $sql);
    $result = mysqli_fetch_all($query)[0];

    if ($result) {
        if ($result[4] != 'a') {
            return ['error' => errors(2) . $result[4]];
        }
        if (!password_verify($password, $result[3])) {
            return ['error' => errors(3)];
        }
    } else {
        return ['error' => errors(1)];
    }

    $data = [
        'id' => $result[0],
        'nome' => $result[1],
        'email' => $result[2],
    ];

    return $data;
}

function checkUserExists($login, $email){
    global $con;

    $sql = "SELECT 1 status FROM users 
    WHERE login = '$login' or email = '$email'";

    $query = mysqli_query($con, $sql);
    $rows = mysqli_num_rows($query);

    return $rows;
}

function createUser($fields){
    global $con;

    $insert = "INSERT INTO users (name, email, login, password) VALUES (?, ?, ?, ?)";

    $prepareInsert = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($prepareInsert, 'ssss', $fieldName, $fieldEmail, $fieldLogin, $fieldPassword);

    $fieldName = $fields['name'];
    $fieldEmail = $fields['email'];
    $fieldLogin = $fields['login'];
    $fieldPassword = md5($fields['password']);

    $result = mysqli_stmt_execute($prepareInsert);
    if (!$result) {
        mysqli_stmt_close($prepareInsert);
        return false;
    }
    $id = mysqli_stmt_insert_id($prepareInsert);
    mysqli_stmt_close($prepareInsert);

    return $id;
}

function errors($idx = 0){
    $error = [
        1 => 'Usuário não encontrado',
        2 => 'Usuário ',
        3 => 'Senha inválida',
        4 => 'Email já cadastrado',
        5 => 'Login já cadastrado'
    ];

    return $error[$idx];
}

// if(empty(trim($_POST["username"]))){
//     $username_err = "Por favor coloque um nome de usuário.";
// } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
//     $username_err = "O nome de usuário pode conter apenas letras, números e sublinhados.";
// } 