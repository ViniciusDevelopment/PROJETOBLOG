<?php
require_once '..\..\..\app\Controller\Pages\Servicos.php';
use \App\Controller\Pages\Servico;
$Servico = new Servico;

if(isset($_POST['nomeServico']))
{
    $nome = $_POST['nomeServico'];
    $valor = $_POST['valorServico'];
    $descricao = $_POST['descricaoServico'];
    $id_prestador = $decoded->id;

    $retornoCadastroServico = $Servico->CadastrarServiço($nome, $valor, $descricao,$id_prestador);

    echo '<div class="d-flex justify-content-center mt-3">';

    if ($retornoCadastroServico) {
        // Redireciona para a mesma página com um parâmetro "success"
        header('Location: page.php?arquivo=CadastrarServiço&id=&success=true');
    }
    
    else
    {
        // Mensagem de erro (vermelho)
        echo '<div class="alert alert-danger mt-3 w-50">
                <strong>Erro:</strong> Erro ao cadastrar serviço.
              </div>';
    }

    echo '</div>';
}

?>

<div class="container mt-5">
        <h1>Cadastro de Serviço</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nomeServico" class="form-label">Nome do Serviço</label>
                <input type="text" class="form-control" id="nomeServico" name="nomeServico" required>
            </div>
            <div class="mb-3">
                <label for="valorServico" class="form-label">Valor do Serviço</label>
                <input type="number" class="form-control" id="valorServico" name="valorServico" required>
            </div>
            <div class="mb-3">
                <label for="descricaoServico" class="form-label">Descrição do Serviço</label>
                <textarea class="form-control" id="descricaoServico" name="descricaoServico" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <div class="container p-3">
    <div class="card p-3 table-responsive">
    <h2>Minha Lista de Serviços</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $Servico->ConsultarServicosPrestador($decoded->id);
                

                if ($result->num_rows > 0) {
                    // Exibe os dados na tabela
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['Id'] . "</td>";
                        echo "<td>" . $row['Nome'] . "</td>";
                        echo "<td>R$" . number_format($row['Valor'], 2, ',', '.') . "</td>";
                        echo "<td>" . $row['Descricao'] . "</td>";
                        echo "<td class='col-auto'>";
                        echo "<a href='DetalhesServico.php?id=" . $row['Id'] . "' class='btn btn-sm btn-info'>Detalhes</a>";
                        echo "<a href='AlterarServico.php?id=" . $row['Id'] . "' class='btn btn-sm btn-warning'>Alterar</a>";
                        echo "<a href='DeletarServico.php?id=" . $row['Id'] . "' class='btn btn-sm btn-danger'>Deletar</a>";
                        echo "</td>";
                        echo "</tr>";
                
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum serviço cadastrado.</td></tr>";
                }

                ?>
            </tbody>
        </table>

        </div>
        </div>
    


    

