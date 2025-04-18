<?php
header('Content-Type: application/json'); // <- ESSENCIAL

require_once '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $conn = conectar();

  $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
  $status = isset($_POST['status']) ? trim($_POST['status']) : '';

  if ($id <= 0 || $status === '') {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    exit;
  }

  $stmt = $conn->prepare("UPDATE tbl_order SET status = ? WHERE id = ?");
  $stmt->bind_param("si", $status, $id);

  if ($stmt->execute()) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar status.']);
  }

  $stmt->close();
  $conn->close();
} else {
  http_response_code(405); // Método não permitido
  echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}
