<?php
session_start();
require 'conexao.php'; // Usa a conexão já existente com $conn

// 1. Excluir visitantes inativos há mais de 1 hora
$conn->query("
    DELETE FROM jogadores
    WHERE tipo = 'visitante'
    AND data_registro < (NOW() - INTERVAL 1 HOUR)
");

// 2. Buscar o último guest criado
$sql = "SELECT nome FROM jogadores WHERE nome LIKE 'guest%' ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

$nextNumber = 1;
if ($result && $row = $result->fetch_assoc()) {
    if (preg_match('/guest(\d+)/', $row['nome'], $matches)) {
        $nextNumber = intval($matches[1]) + 1;
    }
}

$nick = 'guest' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

// 3. Inserir novo visitante
$stmt = $conn->prepare("INSERT INTO jogadores (nome, email, senha, tipo) VALUES (?, NULL, NULL, 'visitante')");
$stmt->bind_param("s", $nick);
$stmt->execute();

$id = $stmt->insert_id;
$stmt->close();

// 4. Salvar na sessão
$_SESSION['usuario_id'] = [
    'id' => $id,
    'nome' => $nick,
    'email' => null,
    'tipo' => 'visitante'
];

// 5. Redirecionar para o menu
$conn->close();
header("Location: menu.php");
exit;
?>