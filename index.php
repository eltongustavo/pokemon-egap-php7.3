<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclui o arquivo de conexão
require_once 'Conexao.php';

// Verifica se a variável $instance está definida
if (isset($instance)) {
    // Tenta executar a consulta
    $query = "SELECT * FROM adm LIMIT 1";
    if ($result = $instance->query($query)) {
        // Fetches the result row
        $adm = $result->fetch_assoc();

        // Libera o resultado
        $result->free();
    } else {
        echo 'Erro na consulta: ' . $instance->error;
    }

    // Fecha a conexão
    $instance->close();
} else {
    echo 'Instância instance não foi criada.';
}

session_start(); // Inicia a sessão
?>


<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Torneio VGC EGAP</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="paginas/font.css">
    <link rel="shortcut icon" href="assets/pikachu.png" type="image/x-icon">
  </head>
  <body style="overflow: hidden;">
    <div class="container-fluid p-3 bg-success text-center" style="min-height: 10vh;">
      <button onclick="mudar_pagina('paginas/inicio.php', this)" class="btn-frame btn btn-sm bg-light itext">Inicio</button>
      <button onclick="mudar_pagina('paginas/inscritos.php', this)" class="btn-frame btn btn-sm bg-success text-light itext">Inscritos</button>
      <button onclick="mudar_pagina('paginas/tutorial.php', this)" class="btn-frame btn btn-sm bg-success text-light itext">Tutorial</button>
      <button onclick="mudar_pagina('paginas/register.php', this)" class="btn-frame btn btn-sm bg-success text-light itext">Inscrição</button>
      <?php
        if(!isset($_SESSION['nome'])){}
        else{
          if ($_SESSION['nome'] == $adm['administrador']) {
            ?>
            <button onclick="mudar_pagina('paginas/dashboard.php', this)" class="btn-frame btn btn-sm bg-success text-light itext">Dashboard</button>
            <?php
          }        
        }

      ?>
    </div>
    <iframe id="frame" src="paginas/inicio.php" frameborder="0" class="w-100" style="height: 90vh;"></iframe>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
      const frame = document.querySelector('#frame');
      const btns = document.querySelectorAll('.btn-frame');
      
      function mudar_pagina(src, btn) {
        frame.src = src;
        btns.forEach(b => {
          b.classList.remove('bg-light');
          b.classList.add('bg-success', 'text-light');
          btn.classList.remove('text-light');
          btn.classList.add('bg-light');
        });
      }
    </script>
  </body>
</html>