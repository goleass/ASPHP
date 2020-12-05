<?php

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

if (!verificaLogin($email, $password)) {
    header("Location: ./index.html");
} else {
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;

    if ($_SESSION['admin'] == '1') {
        header("Location: admin.php");
    }else header("Location: home.php");
}


function verificaLogin($email, $senha)
{

    try {
        $conn = new PDO('mysql:host=localhost;dbname=cursos_online', 'root', '');
        // $conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0","sa","root");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->query("SELECT login, password, admin FROM aluno WHERE login = '$email' AND password = '$senha'");

        $r = $stmt->fetchAll();

        if (count($r) == 0) {
            return false;
        }

        if ($r[0]['admin'] == '1') {
            $_SESSION['admin'] = '1';
        } else $_SESSION['admin'] = '0';
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
        exit();
    }

    return true;
}
