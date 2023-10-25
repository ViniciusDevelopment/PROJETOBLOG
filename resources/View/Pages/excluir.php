<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere o ID da publicação a ser excluída
    $id = $_POST["id"];

    // Conecte-se ao banco de dados e execute a exclusão
    // Substitua 'SUA_CONEXAO_AO_BANCO' com a lógica real de conexão ao banco de dados.
    $conexao = new mysqli("host", "usuário", "senha", "banco_de_dados");

    if ($conexao->connect_error) {
        die("Conexão ao banco de dados falhou: " . $conexao->connect_error);
    }

    $excluirQuery = "DELETE FROM Publicacoes WHERE ID = ?";
    $stmt = $conexao->prepare($excluirQuery);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success"; // A exclusão foi bem-sucedida
    } else {
        echo "error"; // Ocorreu um erro durante a exclusão
    }

    $stmt->close();
    $conexao->close();
}
?>
