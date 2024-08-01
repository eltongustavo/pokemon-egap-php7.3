<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclui o arquivo de conexão usando instance
require_once '../Conexao.php';

// Inicia a sessão
session_start();

// Redireciona se a sessão não estiver ativa
if (!isset($_SESSION['nome'])) {
    header("Location: inicio.php");
    exit;
}

// Obtém o nome do administrador e verifica se o usuário atual é o administrador
$stmt = $instance->query("SELECT * FROM adm LIMIT 1");
$adm = $stmt->fetch_assoc(); // Usa fetch_assoc() para instance

if ($_SESSION['nome'] != $adm['administrador']) {
    header("Location: inicio.php");
    exit;
}

// Obtém todos os inscritos
$inscritosResult = $instance->query('SELECT * FROM equipe');
$inscritos = $inscritosResult->fetch_all(MYSQLI_ASSOC);

// Processa as ações de deletar e aprovar
if (isset($_POST['deletar'])) {
    $nome_treinador = $_POST['deletar'];
    $stmt = $instance->prepare("DELETE FROM equipe WHERE nome_treinador = ? LIMIT 1");
    $stmt->bind_param("s", $nome_treinador);
    $stmt->execute();

    $file = 'uploads/' . $nome_treinador . ".txt";

    // Verifica se o arquivo existe e tenta excluir
    if (file_exists($file)) {
        unlink($file);
    } 

    $stmt->close();
    header("Location: dashboard.php");
    exit;

}elseif (isset($_POST['aprovar'])) {
    $nome_treinador = $_POST['aprovar'];
    $stmt = $instance->prepare("UPDATE equipe SET situacao = 1 WHERE nome_treinador = ? LIMIT 1");
    $stmt->bind_param("s", $nome_treinador);
    $stmt->execute();

    $stmt->close();
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="font.css">
</head>
<body>
    <div class="bg-dark text-light text-center mb-3">Dashboard</div>

    <div class="container" style="min-height: 100vh;">
        <table class="table table-dark text-center text-light">
            <tr class="bg-success text-center text-light">
                <td>Treinador</td>
                <td>Pokémon 1</td>
                <td>Pokémon 2</td>
                <td>Pokémon 3</td>
                <td>Pokémon 4</td>
                <td>Pokémon 5</td>
                <td>Pokémon 6</td>
                <td colspan="3">Ação</td>
            </tr>
            <?php
            
            if ($inscritos) {
                foreach ($inscritos as $i) {
                    ?>
                    <tr>
                        <td><?= htmlspecialchars(ucfirst($i['nome_treinador'])) ?></td>
                        <td><?= htmlspecialchars($i['p1']) ?></td>
                        <td><?= htmlspecialchars($i['p2']) ?></td>
                        <td><?= htmlspecialchars($i['p3']) ?></td>
                        <td><?= htmlspecialchars($i['p4']) ?></td>
                        <td><?= htmlspecialchars($i['p5']) ?></td>
                        <td><?= htmlspecialchars($i['p6']) ?></td>

                        <?php 
                        if (!$i['situacao']) {
                            ?>
                            <td>
                                <form action="" method="POST">
                                    <input type="hidden" name="aprovar" value="<?= htmlspecialchars($i['nome_treinador']) ?>">
                                    <input type="submit" value="Aprovar" class="btn btn-success">
                                </form>
                            </td>
                            <?php
                        } else {
                            ?>
                            <td><div class="btn btn-primary">Aprovado</div></td>
                            <?php
                        }
                        ?>

                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="deletar" value="<?= htmlspecialchars($i['nome_treinador']) ?>">
                                <input type="submit" value="Deletar" class="btn btn-danger">
                            </form>
                        </td>

                        <td>
                            <form action="download.php" method="GET">
                                <input type="hidden" name="file" value="<?= htmlspecialchars($i['nome_treinador'] . '.txt') ?>">
                                <input class="btn btn-secondary" type="submit" value="Baixar TXT">
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
