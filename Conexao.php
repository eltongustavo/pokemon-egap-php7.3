<?php
$host = "db"; // Nome do serviço MySQL no docker-compose.yml
$port = "3306";
$name = "pokemonegap"; // Nome do banco de dados configurado no docker-compose.yml
$user = "user"; // Nome do usuário configurado no docker-compose.yml
$pass = "userpassword"; // Senha do usuário configurada no docker-compose.yml

// Cria a conexão
$instance = new mysqli($host, $user, $pass, $name, $port);

// Verifica a conexão
if ($instance->connect_error) {
    die("Falha na conexão: " . $instance->connect_error);
}
