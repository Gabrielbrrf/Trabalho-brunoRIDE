<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];

    if ($tipo == "motorista") {
        $stmt = $conexao->prepare("INSERT INTO motoristas (nome, email, cnh, senha) VALUES (?, ?, ?, ?)");
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $stmt->bind_param("ssss", $_POST['nome'], $_POST['email'], $_POST['cnh'], $senha);
    } elseif ($tipo == "passageiro") {
        $stmt = $conexao->prepare("INSERT INTO passageiros (nome, email, senha) VALUES (?, ?, ?)");
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $_POST['nome'], $_POST['email'], $senha);
    } elseif ($tipo == "veiculo") {
        $stmt = $conexao->prepare("INSERT INTO veiculos (modelo, placa, motorista_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $_POST['modelo'], $_POST['placa'], $_POST['motorista_id']);
    } elseif ($tipo == "corrida") {
        $stmt = $conexao->prepare("INSERT INTO corridas (origem, destino, passageiro_id, motorista_id, status) VALUES (?, ?, ?, ?, 'pendente')");
        $stmt->bind_param("ssii", $_POST['origem'], $_POST['destino'], $_POST['passageiro_id'], $_POST['motorista_id']);
    }

    if ($stmt->execute()) {
        echo "Dados cadastrados com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}
?>