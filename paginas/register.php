<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclua o arquivo de conexão
require_once '../Conexao.php';

// Inicializa a variável para armazenar os dados
$adm = null;

// Verifica a conexão e executa a consulta
if ($result = $instance->query("SELECT * FROM adm LIMIT 1")) {
    $adm = $result->fetch_assoc();
    $result->free(); // Libera o resultado
} else {
    echo 'Erro na consulta: ' . $instance->error;
}

session_start(); // Verifica se a sessão está ativa

// Redireciona se a sessão já estiver ativa
if (isset($_SESSION['nome'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o formulário foi enviado
if (isset($_POST['nome']) && isset($_POST['senha'])) {
    $instance->begin_transaction(); // Inicia a transação

    // Prepara e executa a consulta para verificar se o nome já existe
    $sql_login = "SELECT nome FROM treinador WHERE nome = ?";
    if ($stmt_login = $instance->prepare($sql_login)) {
        $stmt_login->bind_param("s", $_POST['nome']);
        $stmt_login->execute();
        $stmt_login->store_result();

        $qnt_resultados = $stmt_login->num_rows;

        if ($qnt_resultados == 1) {
            echo '<div class="bg-danger text-light text-center w-100 p-3">Já existe um usuário com esse nome no banco de dados</div>';
        } else {
            // Prepara e executa a consulta para adicionar um novo treinador
            $sql_add = "INSERT INTO treinador (nome, telefone, senha) VALUES (?, ?, ?)";
            if ($stmt_add = $instance->prepare($sql_add)) {

                //armazena as variáveis do POST
                $nome = $_POST['nome'];
                $telefone = $_POST['telefone'];
                $senha = md5($_POST['senha']);

                $stmt_add->bind_param("sss", $nome, $telefone, $senha);
                $stmt_add->execute();

                $instance->commit(); // Confirma a transação

                $_SESSION['nome'] = $_POST['nome'];
                reload_page();
            } else {
                echo 'Erro ao preparar a consulta para adicionar o treinador: ' . $instance->error;
            }
        }
        $stmt_login->close();

    } else {
        echo 'Erro ao preparar a consulta de login: ' . $instance->error;
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
    <link rel="stylesheet" href="font.css">
</head>

    <body style="background-color: #dcdcdc">
        <div class="container mt-sm-5 bg-light p-3 rounded">
            <!-- Pills navs -->
            <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-success" id="tab-login" data-mdb-pill-init href="login.php" role="tab"
                    aria-controls="pills-login" aria-selected="true">Login</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link active bg-success" id="tab-register" data-mdb-pill-init href="#" role="tab"
                    aria-controls="pills-register" aria-selected="false">Registrar</a>
                </li>
            </ul>
            <!-- Pills navs -->

            <!-- Pills content -->
            <div class="tab-content p-3">
                <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                    <form method="post" id="formulario">
                        <!-- nome input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="loginName">Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" />
                        </div>

                        <!-- telefone input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="telefone">Telefone</label>
                            <input type="tel" pattern="\+?[0-9]{1,4}[-.\s]?[0-9]{1,15}" name="telefone" id="telefone" class="form-control">
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="loginPassword">Senha</label>
                            <input type="password" name="senha" id="senha" class="form-control" minlength="8"/>
                        </div>

                        <!-- Password input -->
                        
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="loginPassword">Confirmar senha</label>
                            <input type="password" id="confirmarSenha" class="form-control" minlength="8" />
                        </div>

                        <!-- Submit button -->
                        <button id="submitBtn" type="submit" class="btn btn-success btn-block mb-4">Registrar-se</button>
                    </form>
                    <div id="mensagem" class="mt-3"></div>
                    
                </div>
            </div>
            </div>
            <!-- Pills content -->
        </div>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="register-script.js"></script>
    </body>
</html>