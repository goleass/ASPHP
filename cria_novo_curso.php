<?php
session_start();

if (!$_SESSION) {
    header('Location: index.html');
}

function marcarComoConcluido()
{
    $duracao = $_REQUEST['duracao'];
    $descricao = $_REQUEST['descricao'];
    $nome = $_REQUEST['nome'];

    try {
        $conn = new PDO('mysql:host=localhost;dbname=cursos_online', 'root', '');
        // $conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0","sa","root");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->exec("INSERT INTO CURSO(NOME, DURACAO, DESCRICAO) 
                             VALUES('$nome','$duracao MESES','$descricao')");
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
        exit();
    }

    header('Location: admin.php');
}

marcarComoConcluido();
