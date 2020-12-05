<?php

session_start();

if (!$_SESSION) {
    header('Location: index.html');
}

if(!$_SESSION['admin']=='1'){
    echo "<script>alert('Voce precisa ser admin para acessar.')
        window.location.href='http://localhost/cursos_online/home.php'
    </script>";
}

?>

<!DOCTYPE html>
<html lang="br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração</title>
</head>

<body>
    <h1>Gerenciamento de cursos</h1>

    <a href="novo_curso.php"><button>Novo curso</button></a>

    <?php
    function trasCursos()
    {

        try {
            $conn = new PDO('mysql:host=localhost;dbname=cursos_online', 'root', '');
            // $conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0","sa","root");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->query("SELECT * FROM curso ORDER BY ID DESC");

            $r = $stmt->fetchAll();

            return $r;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    foreach (trasCursos() as $key => $value) {
        $id_curso = $value['ID'];
        $nome = $value['NOME'];
        $duracao = $value['DURACAO'];
        $descricao = $value['DESCRICAO'];

        echo "<h3>Curso: $nome</h3>";
        echo "<p>Duração: $duracao</p>";
        echo "<p>Descrição: $descricao</p>";
        echo "<a href='deletar_curso.php?id_curso=$id_curso'><button>remover</button></a>";
    }
    ?>
</body>

</html>