<?php

// ConfiguraÃ§Ã£o da conexÃ£o com o banco de dados
$host = "localhost";
$port = "5432";
$dbname = "aulaphp";
$user = "postgres";
$password = "pgadmin";

// Criando a conexÃ£o com PDO
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
$pdo = new PDO($dsn, $user, $password);

// Obtendo o nome via GET
$nome = $_GET["nome"] ?? '';
if (empty($nome)) {
    die("âErro: Nome do aluno não informado.");
}

// Criar a consulta de exclusÃ£o
$query = "DELETE FROM aluno WHERE nome = :nome";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);

// Executar a consulta
if ($stmt->execute()) {
    echo "Registro excluÃ­do com sucesso.";
} else {
    echo "Erro ao excluir o registro.";
}

?>

<br>
<a href="frmconsulta.php"> Voltar</a>