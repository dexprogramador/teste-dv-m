<?php
require_once '../config/db_connect.php';

$conn = conectar();

// Busca pedidos do dia com status "Novo"
$data_hoje = date('Y-m-d');
$sql = "SELECT COUNT(*) as novos FROM tbl_order WHERE status = 'Novo' AND DATE(data_pedido) = '$data_hoje'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo json_encode(['novos' => $row['novos'] ?? 0]);
