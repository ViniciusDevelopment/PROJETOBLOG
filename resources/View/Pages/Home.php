<!DOCTYPE html>
<html>
<head>
    <title>Blog</title>
    <style>
        /* Estilos CSS personalizados */
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #333;
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-3">Lista de Posts</h1>

        <?php
        // Conexão com o banco de dados
        use \App\Config\Conexao;

        $conectado = new Conexao;
        $conexao = $conectado->conectarBancoDeDados();

        // Processar o envio do formulário de cadastro
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $titulo = $_POST["titulo"];
            $conteudo = $_POST["conteudo"];

            // Inserir a publicação no banco de dados usando MySQLi
            $inserirQuery = "INSERT INTO Publicacoes (Titulo, Conteudo) VALUES (?, ?)";
            $stmt = $conexao->prepare($inserirQuery);
            $stmt->bind_param('ss', $titulo, $conteudo);

            if ($stmt->execute()) {
                echo '<div class="alert alert-success">Publicação inserida com sucesso!</div>';
            } else {
                echo '<div class="alert alert-danger">Erro ao inserir a publicação: ' . $stmt->error . '</div>';
            }
        }
        ?>

        <!-- Formulário de Cadastro de Publicações -->
        <h2 class="mt-3">Cadastrar Publicação</h2>
        <form method="POST">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="conteudo">Conteúdo:</label>
                <textarea name="conteudo" id="conteudo" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>

        <!-- Tabela de Publicações -->
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Conteúdo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $query = "SELECT * FROM Publicacoes";
                $result = $conexao->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['Titulo'] . '</td>';
                        echo '<td>' . $row['Conteudo'] . '</td>';
                        echo '<td>';
                        echo '<button class="btn btn-primary" data-id=(\'' . $row['ID'] . '\')" onclick="abrirModalEdicao(this)">Editar</button>';
                        echo '<button class="btn btn-danger" onclick="abrirModalExclusao(\'' . $row['ID'] . '\')">Excluir</button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                    echo '<td colspan="3">Nenhum post encontrado.</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de Edição de Publicações -->
    <div id="edicaoModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <span class="close" id="closeEdicaoModal" data-dismiss="modal">&times;</span>
                <h2 class="mt-3">Editar Publicação</h2>
                <form method="POST" id="edicaoForm" action="Editar.php">
                    <div class="form-group">
                        <label for="edicaoTitulo">Título:</label>
                        <input type="text" name="titulo" id="edicaoTitulo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edicaoConteudo">Conteúdo:</label>
                        <textarea name="conteudo" id="edicaoConteudo" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div id="exclusaoModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <span class="close" id="closeExclusaoModal" data-dismiss="modal">&times;</span>
                <h2 class="mt-3">Confirmação de Exclusão</h2>
                <p>Tem certeza de que deseja excluir esta publicação?</p>
                <button id="confirmarExclusaoBtn" class="btn btn-danger" onclick="confirmarExclusao()">Sim, Excluir</button>
            </div>
        </div>
    </div>

    <script>
    // ... (seu código anterior)

    // Função para abrir o modal de edição
    function abrirModalEdicao(titulo, conteudo) {
        edicaoModal.style.display = "block";
        document.getElementById("edicaoTitulo").value = titulo;
        document.getElementById("edicaoConteudo").value = conteudo;
    }

    // Função para abrir o modal de exclusão
    function abrirModalExclusao(id) {
        exclusaoModal.style.display = "block";
        confirmarExclusaoBtn.setAttribute("data-id", id);
    }

    // Função para confirmar a exclusão
    function confirmarExclusao() {
        // Recupere o ID da publicação a ser excluída
        const id = confirmarExclusaoBtn.getAttribute("data-id");

        // Implemente a lógica para excluir a publicação com o ID especificado (usando Ajax, por exemplo)
        // Você pode fazer uma solicitação Ajax para um arquivo PHP que execute a exclusão no banco de dados.
        // Aqui está um exemplo simplificado:

        // Código de exemplo usando jQuery para Ajax (verifique se você incluiu a biblioteca jQuery):
        $.ajax({
            type: 'POST',
            url: 'excluir.php', // Substitua 'excluir.php' pelo nome do arquivo PHP que executa a exclusão
            data: { id: id }, // Envia o ID da publicação a ser excluída
            success: function (response) {
                if (response === 'success') {
                    alert("Publicação com ID " + id + " excluída com sucesso.");
                    location.reload(); // Recarregue a página para atualizar a tabela
                } else {
                    alert("Erro ao excluir a publicação.");
                }
            }
        });

        // Feche o modal de exclusão
        exclusaoModal.style.display = "none";
    }
</script>


       
