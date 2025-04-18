<?php
require_once '../config/db_connect.php';

if (!isset($_GET['id'])) {
  echo "ID do pedido não informado.";
  exit;
}

$conn = conectar();
$id = intval($_GET['id']);
$sql = "SELECT * FROM tbl_order WHERE id = $id";
$res = $conn->query($sql);

if ($res->num_rows === 0) {
  echo "Pedido não encontrado.";
  exit;
}

$pedido = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Imprimir Pedido</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    h2 {
      text-align: center;
    }

    .linha {
      margin-bottom: 10px;
    }
  </style>
</head>

<body onload="window.print()">
  <h2>Pedido BK Lounge</h2>
  <div class="linha"><strong>Nome:</strong> <?= $pedido['nome'] ?></div>
  <div class="linha"><strong>WhatsApp:</strong> <?= $pedido['whatsapp'] ?></div>
  <div class="linha"><strong>Tipo:</strong> <?= $pedido['tipo_pedido'] ?></div>
  <?php if ($pedido['tipo_pedido'] === 'Delivery'): ?>
    <div class="linha"><strong>Endereço:</strong> <?= "{$pedido['endereco']}, Nº {$pedido['numero']}, Bairro {$pedido['bairro']}" ?></div>
    <?php if (!empty($pedido['referencia'])): ?>
      <div class="linha"><strong>Referência:</strong> <?= $pedido['referencia'] ?></div>
    <?php endif; ?>
  <?php else: ?>
    <div class="linha"><strong>Retirada na loja:</strong> R. Natal, 127 - Centro</div>
  <?php endif; ?>
  <div class="linha"><strong>Pagamento:</strong> <?= $pedido['pagamento'] ?></div>
  <?php if ($pedido['pagamento'] === 'Dinheiro'): ?>
    <div class="linha"><strong>Troco:</strong> <?= $pedido['troco'] ?> <?= $pedido['troco'] === 'Sim' ? '- R$ ' . $pedido['valor_troco'] : '' ?></div>
  <?php endif; ?>
  <hr>
  <div class="linha"><strong>Itens:</strong>
    <pre><?= $pedido['itens'] ?></pre>
  </div>
  <div class="linha"><strong>Total:</strong> R$ <?= number_format($pedido['total'], 2, ',', '.') ?></div>
</body>

</html>