<?php
include('config/constants.php');

// Recebe os dados enviados em JSON
$data = json_decode(file_get_contents("php://input"), true);
$ids = isset($data['ids']) ? $data['ids'] : [];

if (empty($ids)) {
  echo json_encode([]);
  exit;
}

// Monta a query com os IDs recebidos
$id_list = implode(',', array_map('intval', $ids));
$sql = "SELECT id, title, price FROM tbl_food WHERE id IN ($id_list)";

$res = mysqli_query($conn, $sql);
$products = [];

if ($res && mysqli_num_rows($res) > 0) {
  while ($row = mysqli_fetch_assoc($res)) {
    $products[] = $row;
  }
}

header('Content-Type: application/json');
echo json_encode($products);
