<?php
include 'conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];
$tipo = $_POST['tipo'];

$tabela = ($tipo == "motorista") ? "motoristas" : "passageiros";

$sql = "SELECT * FROM $tabela WHERE email = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($usuario = $result->fetch_assoc()) {
    if (password_verify($senha, $usuario['senha'])) {
        echo "Login realizado com sucesso! Bem-vindo, " . $usuario['nome'];
    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "Usuário não encontrado.";
}
?>