<?php
// Verifica se o parâmetro 'file' está presente na URL
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Define o diretório onde os arquivos estão armazenados
    $uploadDir = 'uploads/';
    $filePath = $uploadDir . $file;

    // Verifica se o arquivo existe
    if (file_exists($filePath)) {
        // Define os cabeçalhos para forçar o download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Limpa o buffer de saída
        flush();

        // Lê o arquivo e o envia para o navegador
        readfile($filePath);

        // Encerra o script para garantir que o arquivo seja baixado corretamente
        exit;
    } else {
        echo "O arquivo não foi encontrado.";
    }
} else {
    echo "Nenhum arquivo especificado.";
}

