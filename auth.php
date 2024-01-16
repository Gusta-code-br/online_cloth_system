<?php
// public_html/auth.php

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
    die(json_encode(['success' => false, 'message' => 'Erro de conexão com o banco de dados']));
}

$data = json_decode(file_get_contents('php://input'), true);

$username = isset($data['username']) ? $mysqli->real_escape_string($data['username']) : null;
$password = isset($data['password']) ? $mysqli->real_escape_string($data['password']) : null;

if ($username !== null && $password !== null) {
    // Consulta SQL para verificar as credenciais
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Login bem-sucedido']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Credenciais inválidas']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Credenciais não fornecidas']);
}

// Fechar a conexão com o banco de dados
$mysqli->close();
?>
