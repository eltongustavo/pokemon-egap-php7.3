<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclui o arquivo de conexão
require_once '../Conexao.php';

// Inicializa a sessão
session_start();

// Verifica a conexão
if ($instance->connect_error) {
    die("Falha na conexão: " . $instance->connect_error);
}

// Obtém o administrador do banco de dados
$sql_adm = "SELECT * FROM adm LIMIT 1";
if ($result_adm = $instance->query($sql_adm)) {
    $adm = $result_adm->fetch_object();
    $result_adm->free();
} else {
    die("Erro ao consultar o banco de dados: " . $instance->error);
}

// Redireciona para a página de login se a sessão não estiver ativa
if (!isset($_SESSION['nome'])) {
    header("Location: login.php");
    exit();
}

// Processa o logoff
if (isset($_POST['end'])) {
    if ($_SESSION['nome'] == $adm->administrador) {
        session_destroy();
        reload_page();
    } else {
        session_destroy();
        reload_page();
        exit();
    }
}

// Função para recarregar a página
function reload_page() {
    echo '<script>
            window.top.location.href = "../"; // Redireciona a página principal
            if (window.parent) {
                window.parent.frames["frame"].location.reload(); // Recarrega o iframe
            }
          </script>';
    exit();
}

// Redireciona para a página de adicionar time
if (isset($_POST['add'])) {
    header("Location: add_time.php");
    exit();
}

// Prepara a consulta para verificar os dados do usuário
if (isset($_SESSION['nome'])) {
    $sql_user = "SELECT * FROM equipe WHERE nome_treinador = ?";
    if ($stmt_user = $instance->prepare($sql_user)) {
        $stmt_user->bind_param("s", $_SESSION['nome']);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        $qnt_resultados = $result_user->num_rows; // Obtém o número de resultados

        if ($qnt_resultados == 1) {
            $resultado = $result_user->fetch_object();
            $showDetails = true; // Define uma variável para mostrar os detalhes
        } else {
            $showDetails = false; // Define uma variável para mostrar a mensagem de inscrição
        }

        $stmt_user->close();
    } else {
        die("Erro ao preparar a consulta: " . $instance->error);
    }
}

// Fecha a conexão
$instance->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Logoff</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body style="background-color: #cdcdcd">
    <div class="container bg-white mt-sm-5 p-3">
        <form method="post" class="d-flex flex-column">
            <?php if (isset($showDetails) && $showDetails): ?>
                <div style="margin: -1rem;" class="bg-dark text-light text-center p-2 mb-3">
                    <?= ucfirst($resultado->nome_treinador);
                    if ($resultado->situacao == 0) {
                        echo " (EQUIPE AGUARDANDO AVALIAÇÃO)";
                    } else {
                        echo " (EQUIPE APROVADA)";
                    }
                    ?>
                </div>
                <div class="row d-flex justify-content-center px-3">
                    <div class="col-12 col-sm-6 d-flex align-items-center justify-content-center">
                        <img style="width:75%;" class="card-img-top m-0 rounded-0" src="../assets/images/personagens/<?= htmlspecialchars($resultado->imagem_treinador) ?>.png" alt="Card image cap">
                    </div>
                    <div class="col-12 col-sm-6 row m-0">
                        <?php foreach (['p1', 'p2', 'p3', 'p4', 'p5', 'p6'] as $p): ?>
                            <a class="col-4 p-0 d-flex align-items-center justify-content-center" target="_blank" style="cursor:pointer" href="https://bulbapedia.bulbagarden.net/wiki/<?= htmlspecialchars($resultado->$p) ?>_(Pok%C3%A9mon)">
                                <img style="width:100%;" src="https://d1r7q4bq3q8y2z.cloudfront.net/<?= htmlspecialchars($resultado->$p) ?>.png" alt="<?= htmlspecialchars($resultado->$p) ?>">
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button name='end' class="btn btn-danger mt-3" type="submit">Sair</button>                    
            <?php else: ?>
                <div style="margin: -1rem;" class="bg-dark text-light text-center p-2 mb-3">Inscreva sua Equipe!</div>
                <div class="row d-flex justify-content-center px-3">
                    <div class="col-12 col-sm-6 d-flex align-items-center justify-content-center">
                        <img style="width:75%;" class="card-img-top m-0 rounded-0" src="../assets/images/treinador_desconhecido2.png" alt="Card image cap">
                    </div>
                    <div class="col-12 col-sm-6 row m-0">
                        <?php foreach (range(1, 6) as $i): ?>
                            <div class="col-4 p-0 d-flex align-items-center justify-content-center">
                                <img style="width:75%;" class="card-img-top m-0 rounded-0" src="../assets/images/unknown.jpg" alt="Card image cap">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <button name='end' class="btn btn-danger mx-2" type="submit">Sair</button>  
                        <a href="add_time.php" name='end' class="btn btn-success">Criar Time</a>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
