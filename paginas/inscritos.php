<?php
require_once '../Conexao.php';

// Define a consulta SQL
$query = 'SELECT * FROM equipe WHERE situacao=1';

// Inicializa a variável para armazenar os dados
$inscritos = array();

// Executa a consulta
if ($result = $instance->query($query)) {
    // Itera sobre os resultados e armazena cada linha no array $inscritos
    while ($row = $result->fetch_assoc()) {
        $inscritos[] = $row;
    }

    // Libera o resultado
    $result->free();
} else {
    echo 'Erro na consulta: ' . $instance->error;
}

// Fecha a conexão
$instance->close();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="font.css">
</head>
<body style="background-color: #dcdcdc;">
    <div class="p-3 container-fluid" style="min-height: 100vh;">
        <div class="d-flex">
            <h1 style="color:#fff; border-radius: 5px;" class="m-3 bg-success rtext p-2 mx-auto">Equipes Aprovadas</h1>
        </div>
        
        <div class="row">
        
            <?php
            if($inscritos){
                foreach ($inscritos as $i){
            ?>
            
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 py-3 d-flex justify-content-center">
                    <div style="width: 90%" class="card mb-3" style="box-sizing: border-box;">
                        <div class="card-body pb-0 mb-3 bg-success" style="border-radius: 5px 5px 0 0;">
                            <h3 style="font-family: font-site; font-weight: boldr;" class="card-title text-center text-light"><?=ucfirst($i['nome_treinador'])?></h3>
                        </div>
                        <img style="width: 80%" class="card-img-top mx-auto" src="../assets/images/personagens/<?= $i['imagem_treinador'] ?>.png" alt="Card image cap">

                        <div class="row p-3">
                            <a class="col-6 col-sm-6 col-md-4" target = "_black" style="cursor:pointer" href="https://bulbapedia.bulbagarden.net/wiki/<?=$i['p1']?>_(Pok%C3%A9mon)">
                                <img style="width: 100%;" src="https://d1r7q4bq3q8y2z.cloudfront.net/<?= $i['p1'] ?>.png" alt="<?= $i['p1'] ?>">
                            </a>

                            <a class="col-6 col-sm-6 col-md-4" target = "_black" style="cursor:pointer" href="https://bulbapedia.bulbagarden.net/wiki/<?=$i['p2']?>_(Pok%C3%A9mon)">
                                <img style="width: 100%;" src="https://d1r7q4bq3q8y2z.cloudfront.net/<?= $i['p2'] ?>.png" alt="<?= $i['p2'] ?>">
                            </a>

                            <a class="col-6 col-sm-6 col-md-4" target = "_black" style="cursor:pointer" href="https://bulbapedia.bulbagarden.net/wiki/<?=$i['p3']?>_(Pok%C3%A9mon)">
                                <img style="width: 100%;" src="https://d1r7q4bq3q8y2z.cloudfront.net/<?= $i['p3'] ?>.png" alt="<?= $i['p3'] ?>">
                            </a>

                            <a class="col-6 col-sm-6 col-md-4" target = "_black" style="cursor:pointer" href="https://bulbapedia.bulbagarden.net/wiki/<?=$i['p4']?>_(Pok%C3%A9mon)">
                                <img style="width: 100%;" src="https://d1r7q4bq3q8y2z.cloudfront.net/<?= $i['p4'] ?>.png" alt="<?= $i['p4'] ?>">
                            </a>

                            <a class="col-6 col-sm-6 col-md-4" target = "_black" style="cursor:pointer" href="https://bulbapedia.bulbagarden.net/wiki/<?=$i['p5']?>_(Pok%C3%A9mon)">
                                <img style="width: 100%;" src="https://d1r7q4bq3q8y2z.cloudfront.net/<?= $i['p5'] ?>.png" alt="<?= $i['p5'] ?>">
                            </a>

                            <a class="col-6 col-sm-6 col-md-4" target = "_black" style="cursor:pointer" href="https://bulbapedia.bulbagarden.net/wiki/<?=$i['p6']?>_(Pok%C3%A9mon)">
                                <img style="width: 100%;" src="https://d1r7q4bq3q8y2z.cloudfront.net/<?= $i['p6'] ?>.png" alt="<?= $i['p6'] ?>">
                            </a>
                        </div>
                       
                    </div>
                </div>

            <?php
     
                }
            }
            ?>

        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!-- https://d1r7q4bq3q8y2z.cloudfront.net/pikomon.png -->