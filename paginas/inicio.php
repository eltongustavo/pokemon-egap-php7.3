<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regras</title>
    <link rel="stylesheet" href="font.css">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body style="background-color: #dcdcdc;">

    <div class="container d-flex flex-column align-items-center bg-light" style="">
        <h1 style="color:#FFF; border-radius: 5px;" class="m-3 bg-success rtext p-2">Regras do Torneio</h1>

        <h2 style="font-size: clamp(1.5em, 1.8em, 2.5em);" class="rtext text-center bg-danger backrule">Esse torneio será realizado dentro dos jogos Pokémon Ultra Sun/Ultra Moon</h2>

        <img class="m-4" style="margin: 5px; width: 100%;" src="../assets/images/pokemonusum.jpg" alt="pokemon USUM">

        <h2 style="font-size: clamp(1.5em, 1.8em, 2.5em);"class="bg-danger backrule rtext text-center m-3">O modelo das batalhas será VGC/Doubles no modelo do mundial de 2018</h2>

        <img class="m-4" style="margin: 5px; width: 100%;" src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgEzJ7XLRPveDMNsQtCiuFwjst8bUfo3jtfaUM4zOXAFRgRavwOYd58AIQHx7D0f6X8dc0pkLFxoh6wzlIQpHP4TUg06WjZeMouRdlb77qY3IFsj30r3rLeVHqaSp0U1QUQvzDfcxhydQ0/s1600/nblast_04-04_pokemonblast.jpg" alt="imagem de batalha em dupla">

        <div style="width: 100%;">
            <h1 class="ltext bg-danger backrule text-center">Não pode haver pokémons repetidos na equipe</h1>
            <h1 class="ltext bg-danger backrule text-center">Não podem haver items repetidos</h1>
            <h1 class="ltext bg-primary backrule text-center mb-5 ">ABAIXO TODOS OS POKÉMON BANIDOS</h1>
        </div>

        <div class="row">
            <?php
             require_once "../banidos.php";
             foreach(BANIDOS as $pokemon):?>
             <div class="col-6 col-md-4 col-lg-3 d-flex flex-column justify-content-center align-items-center">
                <img class="m-3" src="https://d1r7q4bq3q8y2z.cloudfront.net/<?=$pokemon?>.png" alt="pikomon" style="width: 50%;">
                <p class="text-dark my-auto"><?= ucfirst($pokemon) ?></p>
             </div>
            <?php endforeach;?>        
        </div>

        <div class="mb-5"></div>

        
    
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>