<?php

session_start();

if (!$_SESSION) {
    header('Location: index.html');
}

?>

<!DOCTYPE html>
<html lang="br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seus Cursos</title>
</head>

<body>

    <h1>Cursos Ativos</h1>

    <?php
    function trasCursos()
    {
        $email = $_SESSION['email'];

        try {
            $conn = new PDO('mysql:host=localhost;dbname=cursos_online', 'root', '');
            // $conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0","sa","root");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->query("SELECT
                                    ca.id,
                                    C.NOME,
                                    C.DESCRICAO,
                                    C.DURACAO,
                                    CASE
                                        WHEN CA.STATUS = '0' THEN 'CURSANDO'
                                        ELSE 'CONCLUIDO'
                                    END AS STATUS
                                FROM curso C
                                INNER JOIN CURSO_ALUNO CA
                                    ON CA.ID_CURSO = C.ID
                                INNER JOIN ALUNO A
                                    ON A.ID = CA.ID_ALUNO
                                WHERE A.LOGIN='$email'");

            $r = $stmt->fetchAll();

            return $r;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    if(count(trasCursos()) ==0){
        echo "<h3>Nenhuma inscrição para curso ainda.</h3>";
    }

    foreach (trasCursos() as $key => $value) {
        $id = $value['id'];
        $nome = $value['NOME'];
        $duracao = $value['DURACAO'];
        $descricao = $value['DESCRICAO'];
        $status = $value['STATUS'];

        echo "<h3>Curso: $nome</h3>";
        echo "<p>Duração: $duracao</p>";
        echo "<p>Descrição: $descricao</p>";
        echo "<p>Status: $status</p>";

        if($status=='CONCLUIDO'){
            echo "<a href='concluir_gerar_certificado.php?id=$id&apenas_certificado=s'><button>gerar cetificado</button></a>";
        }else{
            echo "<a href='concluir_gerar_certificado.php?id=$id&apenas_certificado=n'><button >concluir e gerar cetificado</button></a>";
        }

    }
    ?>
</body>

</html>