<?php

session_start();

if (!$_SESSION) {
    header('Location: index.html');
}

$id_curso = $_REQUEST['id_curso'];

deletaCurso($id_curso);

function deletaCurso($id_curso)
{

    try {
        $conn = new PDO('mysql:host=localhost;dbname=cursos_online', 'root', '');
        // $conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0","sa","root");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->query("DELETE FROM curso WHERE id=$id_curso");

    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    header('Location: admin.php');
}

