<?php
session_start();

if (!$_SESSION) {
    header('Location: index.html');
}


$id_curso = $_GET['id_curso'];
$email = $_SESSION['email'];


function inscrever($id_curso, $email)
    {

        try {
            $conn = new PDO('mysql:host=localhost;dbname=cursos_online', 'root', '');
            // $conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0","sa","root");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->query("SELECT ID FROM aluno WHERE LOGIN = '$email'");
            $r = $stmt->fetchAll();
            
            $id_aluno = $r[0][0];
            $now = date('Y-m-d');

            $stmt = $conn->exec("INSERT INTO CURSO_ALUNO(ID_CURSO, ID_ALUNO, DATA_INSCRI, STATUS)
                                 VALUES($id_curso, $id_aluno, '$now', '0');");

        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

inscrever($id_curso, $email);
header('Location: home.php');
?>


