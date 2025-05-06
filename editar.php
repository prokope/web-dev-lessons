<?php
$host = "localhost";
$port = "5432";
$dbname = "aulaphp";
$user = "postgres";
$password = "pgadmin";

try {
    // Criando a conexão com PDO
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Obtendo o nome do aluno via GET
    $nome = $_GET["nome"] ?? '';
    if (empty($nome)) {
        die("❌ Erro: Nome do aluno não informado.");
    }

    // Buscando o aluno no banco de dados
    $query = "SELECT * FROM aluno WHERE nome = :nome";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->execute();
    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$aluno) {
        die("aluno nao encontrado.");
    }

    // Se o formulário for enviado, atualiza os dados
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $novoNome = $_POST["txtnome"] ?? '';
        $novaSenha = $_POST["txtsenha"] ?? '';

        if (empty($novoNome) || empty($novaSenha)) {
            echo "❌ Erro: Todos os campos são obrigatórios.";
        } else {
            $updateQuery = "UPDATE aluno SET nome = :novoNome, senha = :novaSenha WHERE nome = :nome";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->bindParam(':novoNome', $novoNome, PDO::PARAM_STR);
            $updateStmt->bindParam(':novaSenha', $novaSenha, PDO::PARAM_STR);
            $updateStmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            
            if ($updateStmt->execute()) {
                echo " Sucesso! Registro atualizado.";
                $nome = $novoNome; // Atualiza a variável para refletir o novo nome
            } else {
                echo " Erro ao atualizar o registro.";
            }
        }
    }
} catch (PDOException $e) {
    echo " Erro na conexão: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
</head>
<body>
    <h2>Editar Aluno</h2>
    <form method="post">
        <label for="txtnome">Nome:</label>
        <input type="text" name="txtnome" id="txtnome" value="<?php echo htmlspecialchars($aluno['nome']); ?>" required>
        <br>
        <label for="txtsenha">Senha:</label>
        <input type="password" name="txtsenha" id="txtsenha" value="<?php echo htmlspecialchars($aluno['senha']); ?>" required>
        <br>
        <button type="submit">Salvar</button>
    </form>
    <br>
    <a href="frmconsulta.php"> Voltar</a>
</body>
</html>