<?php
session_start();

if (!$_SESSION) {
    header('Location: index.html');
}

$certificado = $_REQUEST['apenas_certificado'];

if ($certificado == 's') {
    // apenas certificado

    $nome = trasInfoAluno()[0]['nome'];
    $nome_curso= trasInfoAluno()[0]['CURSO'];
    $duracao= trasInfoAluno()[0]['DURACAO'];

    header("Content-Type: image/jpg");

    $image = imagecreatefromjpeg('modelo-de-certificado-em-branco-6.jpg');

    $black = imagecolorallocate($image, 0, 0, 0);

    $red = imagecolorallocate($image, 255, 0, 0);

    $now = date('d/m/Y');
    $now2 = date('d-m-Y');

    imagestring($image, 5, 200, 170, "Nome Aluno: ".strtoupper(utf8_decode($nome)), $black);
    imagestring($image, 5, 200, 211, "Curso: ".utf8_decode($nome_curso), $black);
    imagestring($image, 5, 200, 250, utf8_decode("Duração: ").$duracao, $black);
    imagestring($image, 5, 315, 340, "Canoas, $now", $black);

    $nome_arquivo = "certificado_$now2.jpg";

    imagejpeg($image, $nome_arquivo);

    
    header('Cache-control: must-revalidate, post-check=0, pre-check=0');
    header('Content-Type: application/octet-stream');
    header('Content-Length: '.filesize($nome_arquivo));
    header('Content-Disposition: filename='.$arquivo);
    header("Content-Disposition: attachment; filename=".basename($nome_arquivo));
    readfile($nome_arquivo);
    
    imagedestroy($image);
    // header('Location: cursos_ativos.php');
} else {
    // marcar como concluido e gerar certificado

    function marcarComoConcluido()
    {
        $id = $_REQUEST['id'];

        try {
            $conn = new PDO('mysql:host=localhost;dbname=cursos_online', 'root', '');
            // $conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0","sa","root");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->exec("UPDATE `cursos_online`.`curso_aluno` SET `STATUS` = '1' WHERE (`ID` = $id);");
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }

        header('Location: cursos_ativos.php');
    }

    marcarComoConcluido();
}

function trasInfoAluno()
{
    try {
        $id = $_REQUEST['id'];
        $conn = new PDO('mysql:host=localhost;dbname=cursos_online', 'root', '');
        // $conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0","sa","root");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->query("SELECT a.nome, C.NOME AS CURSO, C.DURACAO
                            FROM aluno a
                            INNER JOIN curso_aluno ca
                            ON ca.id_aluno = a.id
                            INNER JOIN curso c
                            ON ca.id_curso = c.id
                            WHERE CA.ID=$id");

        $r = $stmt->fetchAll();

        return $r;
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
        exit();
    }
}
