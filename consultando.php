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

    // Recebendo o texto da pesquisa
    $pesquisa = $_POST["txtpesquisa"];

    // Criando a consulta SQL para buscar registros que correspondam à pesquisa
    $query = "SELECT * FROM aluno WHERE nome ILIKE :pesquisa";
    $stmt = $pdo->prepare($query);
    $parametro = "%$pesquisa%";
    $stmt->bindParam(':pesquisa', $parametro, PDO::PARAM_STR);
    $stmt->execute(); //consulta feita

    // Exibindo os registros encontrados
    echo "<table border='1'>";
    echo "<tr><th>Nome</th><th>Senha</th><th>Ações</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
		echo "<td>" . htmlspecialchars($row["senha"]) . "</td>";
        echo "<td>
                <a href='editar.php?nome=" . urlencode($row["nome"]) . "'>✏️ Editar</a> | 
                <a href='excluir.php?nome=" . urlencode($row["nome"])  . "'>❌ Excluir</a>
              </td>";
        echo "</tr>";
    }
    echo "</table>";

} catch (PDOException $e) {
    echo "❌ Erro na conexão: " . $e->getMessage();
}
?>