<?php

$nome = $_POST['nome'];
$nascimento = $_POST['data_nasc'];
$sexo = $_POST['sexo'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$password = $_POST['password'];


if (!validaInput($email, $password, $nome, $nascimento, $sexo)) {
    // header('Location: criarConta.html');
} else {
    if (verificaSeExiste($email)) {
        header('Location: signin_page_admin.html');
        return;
    }

    criarUsuario($email, $password, $nome, $nascimento, $sexo, $cpf);
    header("Location: login_page.html");
}

function validaInput($email, $password, $nome, $nascimento, $sexo)
{
    if (!$sexo) return false;
    if (!$nascimento) return false;
    if (!$nome) return false;
    if (!$email) return false;
    if (!$password) return false;
    if (!substr_count($email, "@") == 1) return false;

    return true;
}

function verificaSeExiste($email)
{

    try {
        $conn = new PDO('mysql:host=localhost;dbname=cursos_online', 'root', '');
        // $conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0","sa","root");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $conn->query("SELECT * FROM aluno WHERE login = '$email'");
        
        $r = $stmt->fetchAll();

        if(count($r)>0){
            return true;
        }
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    return false;
}

function criarUsuario($email, $password, $nome, $nascimento, $sexo, $cpf)
{

    try {
        $conn = new PDO('mysql:host=localhost;dbname=cursos_online', 'root', '');
        // $conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0","sa","root");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "INSERT INTO ALUNO(NOME, LOGIN,PASSWORD, CPF, CPF,DATA_NASC, SEXO) 
        VALUES('$nome', '$email', '$password','$cpf', '$nascimento', '$sexo')";

        $stmt = $conn->query("INSERT INTO ALUNO(NOME, LOGIN,PASSWORD, CPF,DATA_NASC, SEXO,ADMIN) 
                              VALUES('$nome', '$email', '$password','$cpf', '$nascimento', '$sexo','1')");
        
        $stmt->execute();
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
        exit();
    }
}
