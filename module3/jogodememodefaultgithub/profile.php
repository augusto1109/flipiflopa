<?php
session_start();

$usuarioLogado = isset($_SESSION["usuario_id"]) ? true : false;

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Conectar ao banco
require_once 'conexao.php';

$sql = "SELECT nome, email FROM jogadores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
} else {
    echo "Usuário não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="css/style-profile.css">
</head>
<body>
    <main>
        <h1>Perfil do Jogador</h1>
        <div class="profile-container">
            <p><strong>Nome de usuário:</strong> <?php echo htmlspecialchars($usuario['nome']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
        </div>
        <a href="menu.php" class="back-button">Voltar ao menu</a>
    </main>

    <footer>
        <p>&copy; 2025 Memória do Seu Jeito. Todos os direitos reservados.</p>
    </footer>

    <script src="js/menu_script.js"></script>
    <script>
        var usuarioLogado = <?php echo $usuarioLogado ? 'true' : 'false'; ?>;
    </script>
</body>
</html>
