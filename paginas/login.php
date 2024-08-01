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

// Verifica se a sessão está ativa e redireciona se necessário
if (isset($_SESSION['nome'])) {
    header("Location: logoff.php");
    exit();
}

// Verifica se o formulário foi enviado
if (isset($_POST['nome']) && isset($_POST['senha'])) {
    $instance->begin_transaction(); // Inicia a transação

    // Prepara a consulta para verificar se o nome e senha correspondem
    $sql_login = "SELECT nome FROM treinador WHERE nome = ? AND senha = ?";
    if ($stmt_login = $instance->prepare($sql_login)) {
        //definição de variáveis
        $nome = $_POST['nome'];
        $senha = md5($_POST['senha']);

        $stmt_login->bind_param("ss", $nome , $senha);
        $stmt_login->execute();
        $stmt_login->store_result();

        $qnt_resultados = $stmt_login->num_rows;

        if ($qnt_resultados == 1) {
            $_SESSION['nome'] = $_POST['nome'];
            $instance->commit(); // Confirma a transação
            reload_page();
            exit();
        } else {
            echo '<div class="bg-danger text-light text-center w-100 p-3">Usuário não encontrado!</div>';
        }

        $stmt_login->close();
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

$instance->close(); // Fecha a conexão
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
    <body style="background-color: #dcdcdc">
        <div class="container mt-sm-5 bg-light p-3 rounded">
            <!-- Pills navs -->
            <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active bg-success" id="tab-login" data-mdb-pill-init href="#" role="tab"
                    aria-controls="pills-login" aria-selected="true">Login</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-success" id="tab-register" data-mdb-pill-init href="register.php" role="tab"
                    aria-controls="pills-register" aria-selected="false">Registrar</a>
                </li>
            </ul>
            <!-- Pills navs -->

            <!-- Pills content -->
            <div class="tab-content p-3">
                <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                    <form method="post" id="formulario_login">
                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="loginName">Nome</label>
                            <input type="text" id="loginName" class="form-control" name="nome"/>
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="loginPassword">Senha</label>
                            <input type="password" id="loginPassword" class="form-control" name="senha"/>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block mb-4">Fazer Login</button>
                    </form>
                </div>
            </div>
            </div>
            <!-- Pills content -->
        </div>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>