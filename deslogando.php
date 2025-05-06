<?php
// Remover os cookies de nome e senha
setcookie("nome", "", time() - 3600, "/"); // Exclui o cookie 'nome'
setcookie("senha", "", time() - 3600, "/"); // Exclui o cookie 'senha'

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");header("Expires: 0");

// Redireciona para a página de login
header("Location: frmacesso.php");
exit();
?>