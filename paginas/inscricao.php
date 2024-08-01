<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclui o arquivo de conexão usando MySQLi
require_once '../Conexao.php'; 

session_start(); // Inicia a sessão

// Redireciona se a sessão não estiver ativa
if (!isset($_SESSION['nome'])) {
    header("Location: login.php");
    exit;
}

$nome = $_SESSION['nome'];
$imagem_treinador = $_POST['sexo'] ?? ''; // Usar operador null coalescing para evitar undefined index
$p1 = $_POST['p1'] ?? '';
$p2 = $_POST['p2'] ?? '';
$p3 = $_POST['p3'] ?? '';
$p4 = $_POST['p4'] ?? '';
$p5 = $_POST['p5'] ?? '';
$p6 = $_POST['p6'] ?? '';

// Define o diretório onde o arquivo será salvo
$uploadDir = 'uploads/'; // Certifique-se de que esse diretório exista e tenha permissões adequadas

// Cria o diretório se não existir
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Gera um nome único para o arquivo e adiciona a extensão
$uploadFile = $uploadDir . $nome . '.txt';

// move o arquivo para o local correto
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);       
}

try {
    // Inicia uma transação
    $instance->begin_transaction();

    // Prepara e executa a inserção no banco de dados
    $sql_equipe = "INSERT INTO equipe (nome_treinador, imagem_treinador, situacao, p1, p2, p3, p4, p5, p6) 
                   VALUES (?, ?, default, ?, ?, ?, ?, ?, ?)";
    $stmt_equipe = $instance->prepare($sql_equipe);

    // Verifica se a preparação foi bem-sucedida
    if ($stmt_equipe === false) {
        throw new Exception("Falha ao preparar a consulta: " . $instance->error);
    }

    // Associa os parâmetros
    $stmt_equipe->bind_param("ssssssss", $nome, $imagem_treinador, $p1, $p2, $p3, $p4, $p5, $p6);

    // Executa a consulta
    $stmt_equipe->execute();

    // Verifica se a execução foi bem-sucedida
    if ($stmt_equipe->errno) {
        throw new Exception("Falha ao executar a consulta: " . $stmt_equipe->error);
    }

    // Comita a transação
    $instance->commit();

    // Redireciona para a página de inscritos
    header("Location: register.php");
    exit;
} catch (Exception $e) {
    // Reverte a transação em caso de erro
    $instance->rollback();
    die("ERRO: " . $e->getMessage());
} finally {
    // Fecha a declaração
    if (isset($stmt_equipe)) {
        $stmt_equipe->close();
    }
    // Fecha a conexão
    $instance->close();
}

