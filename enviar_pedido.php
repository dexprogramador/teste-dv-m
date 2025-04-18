<?php
// enviar_pedido.php
header('Content-Type: application/json');
require_once 'config/db_connect.php'; // ajuste o caminho se necessário

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['nome'], $data['whatsapp'], $data['tipo'], $data['pagamento'], $data['carrinho'])) {
  echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
  exit;
}

// Dados do formulário
$nome = $data['nome'];
$whatsapp = $data['whatsapp'];
$tipo = $data['tipo'];
$pagamento = $data['pagamento'];
$bairro = $data['bairro'] ?? '';
$endereco = $data['endereco'] ?? '';
$numero = $data['numero'] ?? '';
$referencia = $data['referencia'] ?? '';
$troco = $data['troco'] ?? '';
$valor_troco = isset($data['valor_troco']) && $data['valor_troco'] !== '' ? floatval($data['valor_troco']) : null;
$carrinho = $data['carrinho'];

// Calcula total
$total = 0;
$itens = [];

foreach ($carrinho as $item) {
  $quantidade = intval($item['quantity']);
  $titulo = $item['title'];
  $preco = floatval($item['price']);
  $subtotal = $quantidade * $preco;
  $total += $subtotal;

  $itens[] = "$quantidade x $titulo - R$ " . number_format($subtotal, 2, ',', '.');
}

$lista_itens = implode("\n", $itens);

// Conexão segura com prepared statement
$conn = conectar();

$stmt = $conn->prepare("INSERT INTO tbl_order 
  (nome, whatsapp, tipo_pedido, pagamento, bairro, endereco, numero, referencia, troco, valor_troco, total, itens, data_pedido) 
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

$stmt->bind_param(
  "sssssssssdss",
  $nome,
  $whatsapp,
  $tipo,
  $pagamento,
  $bairro,
  $endereco,
  $numero,
  $referencia,
  $troco,
  $valor_troco,
  $total,
  $lista_itens
);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => 'Erro ao salvar pedido: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
