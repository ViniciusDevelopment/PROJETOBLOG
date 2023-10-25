<?php

namespace App\Controller\Pages;

require_once __DIR__ . '/../../Config/config.php';
require __DIR__ . '/../../../vendor/autoload.php';

use \App\Utils\View;
use \App\Config\Conexao;

class Servico
{
    public static function CadastrarServiço($nome, $valor, $descricao, $id_prestador)
    {
        $conexao = new Conexao;
        $conectado = $conexao->conectarBancoDeDados();
        
        $sql = "INSERT INTO servicos (Nome, Valor, Descricao, disponibilidade, prestador_id) VALUES (?, ?, ?, 1, ?)";
        $stmt = $conectado->prepare($sql);
        $stmt->bind_param("sdsi", $nome, $valor, $descricao, $id_prestador);

        if ($stmt->execute()) {
            return true; // Inserção bem-sucedida
        } else {
            return false; // Erro na inserção
        }
    }
    public static function ConsultarServicos()
    {
        $conexao = new Conexao;
        $conectado = $conexao->conectarBancoDeDados();
        $sql = "SELECT * FROM servicos WHERE disponibilidade = 1";
        $result = $conectado->query($sql);
        return $result;
    }
    public static function ConsultarServicosPrestador($id_prestador)
    {
        $conexao = new Conexao;
        $conectado = $conexao->conectarBancoDeDados();
        $sql = "SELECT * FROM servicos WHERE prestador_id = $id_prestador";
        $result = $conectado->query($sql);
        return $result;
    }
    
}
