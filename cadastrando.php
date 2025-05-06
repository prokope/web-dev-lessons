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
    ]); //ponte de acesso

    // Recebendo os dados do formulário
    $nome = $_POST["txtnome"] ?? '';
    $senha = $_POST["txtsenha"] ?? '';

    if (empty($nome) || empty($senha)) {
        die("❌ Erro: Todos os campos são obrigatórios.");
    }

    // Criando a consulta SQL com parâmetros para evitar SQL Injection
    $query = "INSERT INTO aluno (nome, senha) VALUES (:nome, :senha)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':senha', $senha);
    
    // Executando a inserção
    if ($stmt->execute()) {
        echo "✅ Sucesso! Registro salvo no banco de dados.";
    } else {
        echo "❌ Erro ao inserir o registro.";
    }

} catch (PDOException $e) {
    echo "❌ Erro na conexão: " . $e->getMessage();
}
?>