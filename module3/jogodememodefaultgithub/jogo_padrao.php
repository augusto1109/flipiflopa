<?php
session_start();

$usuarioLogado = isset($_SESSION["usuario_id"]);

if ($usuarioLogado) {
    require_once 'conexao.php';

    $usuario_id = $_SESSION['usuario_id'];

    $sql = "SELECT nome, email FROM jogadores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();
        $nomeJogador = htmlspecialchars($usuario['nome']);
    } else {
        $nomeJogador = "Desconhecido";
    }
} else {
    $nomeJogador = "";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memória do Seu Jeito</title>
    <link rel="stylesheet" href="css/style-jogo-novo.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="logo_katakana.png" alt="Logo do jogo" class="logo">
            <h1>MEMÓRIA DO SEU JEITO</h1>
        </div>
        <div class="user-container">
            <div class="user-icon" onclick="toggleUserDropdown()"></div>
            <div id="user-dropdown" class="user-dropdown hidden">
                <ul>
                    <li><a href="profile.php">Perfil</a></li>
                    <li><a href="logout.php">Deslogar</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="game-info">
        <div id="player-info">
            <label for="player-name">Jogador:</label>
            <?php if ($usuarioLogado): ?>
                <input type="text" id="player-name" value="<?= $nomeJogador ?>" readonly>
            <?php else: ?>
                <input type="text" id="player-name" placeholder="Digite seu nome">
            <?php endif; ?>
        </div>
        <br>
        <div id="timer">Tempo: 00:00</div>
    </div>

    <div class="button-container">
        <button id="start-button">Iniciar Jogo</button>
        <button id="restart-button">Reiniciar Jogo</button>
        <button id="upload-button">Adicionar Imagens</button>
        <button id="exit-button" onclick="window.location.href='menu.php'">Sair do Jogo</button>
    </div>
    <br>

    <input type="file" id="image-upload" accept="image/*" style="display: none;" multiple>

    <div class="game-container">
        <div class="memory-game">
            <?php
            $cartas = ['zero', 'um', 'dois', 'tres', 'quatro', 'cinco', 'seis', 'sete'];
            foreach ($cartas as $carta) {
                echo "<div class='memory-card' data-framework='$carta'>
                        <img class='front-face' src='imgPadrao/$carta.png' alt='$carta'>
                        <img class='back-face' src='imgPadrao/interrogacao.png' alt='Verso da Carta'>
                    </div>
                    <div class='memory-card' data-framework='$carta'>
                        <img class='front-face' src='imgPadrao/$carta.png' alt='$carta'>
                        <img class='back-face' src='imgPadrao/interrogacao.png' alt='Verso da Carta'>
                    </div>";
            }
            ?>
        </div>
    </div>

    <script>
        console.log("Usuário logado: <?= $usuarioLogado ? 'Sim' : 'Não' ?>");
        <?php if ($usuarioLogado): ?>
            console.log("Nome do usuário: <?= $nomeJogador ?>");
        <?php endif; ?>
    </script>
    <script src="js/jogo_padrao_script.js"></script>
</body>
</html>
