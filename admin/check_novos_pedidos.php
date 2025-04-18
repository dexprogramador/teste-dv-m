<?php
// check_novos_pedidos.php
require_once '../config/db_connect.php';

// Ativa exibição de erros para debug (pode remover em produção)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define o cabeçalho como JSON
header('Content-Type: application/json');

// Conecta ao banco
$conn = conectar();

// Garante que conexão foi bem-sucedida
if (!$conn) {
  echo json_encode(['novos' => 0, 'erro' => 'Erro na conexão com o banco']);
  exit;
}

// Busca pedidos com status "Novo" da data atual
$data_hoje = date('Y-m-d');
$sql = "SELECT COUNT(*) as novos FROM tbl_order WHERE status = 'Novo' AND DATE(data_pedido) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $data_hoje);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();
$novos = $row['novos'] ?? 0;

echo json_encode(['novos' => $novos]);

$stmt->close();
$conn->close();
