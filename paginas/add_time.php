<?php
    session_start();
    // Verifica se a sessão está ativa
    if (!isset($_SESSION['nome'])) {
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <style>
        label.opc-treinador {
            filter: saturate(20%);
        }
        label.opc-treinador:hover {
            filter: none;
            transform: scale(100%);
        }
        label.opc-treinador.selecionado {
            filter: none;
            transform: scale(110%);
            border-radius: 5%;
            img {
                border-bottom: 3px solid green;
            }
        }
    </style>
</head>
<body style="background-color: #dcdcdc;">
    <div class="container p-3 mt-sm-5 bg-light rounded">
        <form action="inscricao.php" method="post" enctype="multipart/form-data" class="form">
            <div class="bg-success text-center text-light p-2 mb-3" style="margin: -1em;"><?=ucfirst($_SESSION['nome'])?></div>

            <div id="treinadores" class="row mx-0 my-3 pb-3 rounded" style="box-sizing: border-box; background-color: white; border: 1px solid #ddd">
                <label class="opc-treinador selecionado col-6 col-md-4 col-lg-2 px-4 m-0" style="box-sizing: border-box;">
                    <input class="d-none mt-3" type="radio" name="sexo" value="m1" checked>    
                    <img src="../assets/images/personagens/m1.png" alt="personagem 1" style="width: 100%; padding-top: 15px;">
                </label>
                <label class="opc-treinador col-6 col-md-4 col-lg-2 px-4 m-0" style="box-sizing: border-box;">
                    <input class="d-none mt-3" type="radio" name="sexo" value="m2">    
                    <img src="../assets/images/personagens/m2.png" alt="personagem 1" style="width: 100%; padding-top: 15px;">
                </label>
                <label class="opc-treinador col-6 col-md-4 col-lg-2 px-4 m-0" style="box-sizing: border-box;">
                    <input class="d-none mt-3" type="radio" name="sexo" value="m3">    
                    <img src="../assets/images/personagens/m3.png" alt="personagem 1" style="width: 100%; padding-top: 15px;">
                </label>
                <label class="opc-treinador col-6 col-md-4 col-lg-2 px-4 m-0" style="box-sizing: border-box;">
                    <input class="d-none mt-3" type="radio" name="sexo" value="f1">
                    <img src="../assets/images/personagens/f1.png" alt="personagem 1" style="width: 100%; padding-top: 15px;">
                </label>
                <label class="opc-treinador col-6 col-md-4 col-lg-2 px-4 m-0" style="box-sizing: border-box;">
                    <input class="d-none mt-3" type="radio" name="sexo" value="f2">
                    <img src="../assets/images/personagens/f2.png" alt="personagem 1" style="width: 100%; padding-top: 15px;">
                </label>
                <label class="opc-treinador col-6 col-md-4 col-lg-2 px-4 m-0" style="box-sizing: border-box;">
                    <input class="d-none mt-3" type="radio" name="sexo" value="f3">
                    <img src="../assets/images/personagens/f3.png" alt="personagem 1" style="width: 100%; padding-top: 15px;">
                </label>
            </div>

            <label class="mt-3" for="txt-showdown">txt do time:</label>
            <input class="form-control mt-1" required type="file" accept=".txt" name="file" id="txt">
            
            <div id="container" class="row mx-0 my-3 rounded" style="box-sizing: border-box; background-color: white; border: 1px solid #ddd"></div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Registrar</button>
            </div>

        </form>
    </div>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>
</html>