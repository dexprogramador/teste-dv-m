<?php
require_once '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $conn = conectar();
  $id = intval($_POST['id']);
  $status = $_POST['status'];

  $stmt = $conn->prepare("UPDATE tbl_order SET status = ? WHERE id = ?");
  $stmt->bind_param("si", $status, $id);

  if ($stmt->execute()) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar status']);
  }
  $stmt->close();
  $conn->close();
}
