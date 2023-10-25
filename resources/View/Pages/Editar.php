<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se o ID foi enviado corretamente via POST
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $titulo = $_POST["titulo"];
        $conteudo = $_POST["conteudo"];

        // Conecte-se ao banco de dados e execute a atualização
        $conexao = new mysqli("localhost", "seu_usuario", "sua_senha", "seu_banco_de_dados");

        if ($conexao->connect_error) {
            die("Conexão ao banco de dados falhou: " . $conexao->connect_error);
        }

        $atualizarQuery = "UPDATE Publicacoes SET Titulo = ?, Conteudo = ? WHERE ID = ?";
        $stmt = $conexao->prepare($atualizarQuery);
        $stmt->bind_param("ssi", $titulo, $conteudo, $id);

        if ($stmt->execute()) {
            echo "success"; // A edição foi bem-sucedida
        } else {
            echo "error"; // Ocorreu um erro durante a edição
        }

        $stmt->close();
        $conexao->close();
    } else {
        echo "error: ID não foi fornecido.";
    }
}
?>
