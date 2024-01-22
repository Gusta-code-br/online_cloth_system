<?php
// public_html/api/cadastrar.php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Configurações do banco de dados
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "dbreact";

// Conectar ao banco de dados
$mysqli = new mysqli($host, $usuario, $senha, $banco);

// Verificar a conexão
if ($mysqli->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Erro de conexão com o banco de dados: ' . $mysqli->connect_error]));
}

// Processar os dados do formulário
$data = json_decode(file_get_contents('php://input'), true);

$username = isset($data['username']) ? $mysqli->real_escape_string($data['username']) : null;
$password = isset($data['password']) ? $mysqli->real_escape_string($data['password']) : null;
$email = isset($data['email']) ? $mysqli->real_escape_string($data['email']) : null;
$phone = isset($data['phone']) ? $mysqli->real_escape_string($data['phone']) : null;
$fullName = isset($data['fullName']) ? $mysqli->real_escape_string($data['fullName']) : null;

if ($username !== null && $password !== null && $email !== null && $phone !== null && $fullName !== null) {
    // Consulta SQL para inserir um novo usuário
    $query = "INSERT INTO tusers (username, password, email, phone, fullName) 
              VALUES ('$username', '$password', '$email', '$phone', '$fullName')";
    $result = $mysqli->query($query);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Cadastro realizado com sucesso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar: ' . $mysqli->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
}

// Fechar a conexão com o banco de dados
$mysqli->close();
