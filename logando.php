<?php

// Configuração da conexão com o banco de dados
$host = "localhost";
$port = "5432";
$dbname = "aulaphp";
$user = "postgres";
$password = "pgadmin";

// Criando a conexão com PDO
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
$pdo = new PDO($dsn, $user, $password);

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["txtnome"] ?? '';
    $senha = $_POST["txtsenha"] ?? '';
    
    if (empty($nome) || empty($senha)) {
        header("Location: frmacesso.php"); // Redireciona para a tela de login
        exit();
    }
    
    // Consulta para validar o usuário no banco de dados
    //$query = "SELECT * FROM aluno WHERE nome = :nome AND senha = :senha";
    $query = "SELECT * FROM aluno WHERE nome ='".$nome."' AND senha ='".$senha."'";
    $stmt = $pdo->prepare($query);
    //$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    //$stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
    $stmt->execute();
    
    $numrows = $stmt->rowCount();
    echo "$numrows";
    // Verifica se encontrou um registro
    if ($numrows > 0) {
        setcookie("nome", $nome, time() + 3600, "/"); // Define cookie para 1 hora
        setcookie("senha", $senha, time() + 3600, "/"); // Define cookie para 1 hora
        header("Location: menucliente.php"); // Redireciona para o menu do cliente
        
        exit;
    } else {
        echo "errado";
        header("Location: frmacesso.php"); // Redireciona para a tela de login
        exit;
    }
}
?>