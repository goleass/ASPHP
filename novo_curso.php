<!DOCTYPE html>
<html lang="br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo curso</title>
</head>
<body>
    <form action="cria_novo_curso.php" method="post">
        Nome&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" required name='nome' placeholder='Curso de PHP'><br><br>
        Duração (meses):
        <input type="number" name='duracao' required name="" id=""><br><br>
        Descrição&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <textarea required name="descricao"cols="20" placeholder='Curso voltado para iniciande na linguagem PHP' rows="3"></textarea><br><br>
        <input type="submit" value="Criar">

    </form>
</body>
</html>