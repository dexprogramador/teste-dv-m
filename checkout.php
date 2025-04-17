<?php
session_start();
$total = 0;
foreach ($_SESSION['cart'] as $item) {
  $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Finalizar Pedido - BK Lounge</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/style.css"> <!-- seu CSS aqui -->
  <style>
    body {
      background: #111;
      color: #fff;
      font-family: sans-serif;
      padding: 20px;
    }

    input,
    select,
    button {
      width: 100%;
      margin-bottom: 10px;
      padding: 10px;
      border-radius: 8px;
      border: none;
    }

    .hidden {
      display: none;
    }

    .total {
      font-size: 20px;
      font-weight: bold;
      margin-top: 10px;
    }
  </style>
</head>

<body>

  <h2>Finalizar Pedido</h2>

  <form id="checkout-form" action="enviar_pedido.php" method="POST">
    <label>Nome Completo</label>
    <input type="text" name="nome" required>

    <label>WhatsApp</label>
    <input type="text" name="whatsapp" required>

    <label>Tipo de Pedido</label>
    <select name="tipo_pedido" id="tipo-pedido" required>
      <option value="delivery">Delivery</option>
      <option value="retirada">Retirada</option>
    </select>

    <div id="endereco-fields">
      <label>Bairro</label>
      <input type="text" name="bairro">

      <label>Endereço</label>
      <input type="text" name="endereco">

      <label>Número</label>
      <input type="text" name="numero">

      <label>Referência</label>
      <input type="text" name="referencia">
    </div>

    <label>Forma de Pagamento</label>
    <select name="pagamento" required>
      <option value="dinheiro">Dinheiro</option>
      <option value="pix">PIX</option>
      <option value="debito">Cartão Débito</option>
      <option value="credito">Cartão Crédito</option>
    </select>

    <div class="total">
      Total: R$ <span id="valor-total"><?= number_format($total, 2, ',', '.') ?></span>
    </div>

    <input type="hidden" id="totalFinal" name="total" value="<?= $total ?>">

    <button type="submit">Enviar Pedido</button>
  </form>

  <script>
    const tipoPedido = document.getElementById('tipo-pedido');
    const enderecoFields = document.getElementById('endereco-fields');
    const totalBase = <?= $total ?>;
    const spanTotal = document.getElementById('valor-total');
    const inputTotal = document.getElementById('totalFinal');

    tipoPedido.addEventListener('change', () => {
      if (tipoPedido.value === 'retirada') {
        enderecoFields.style.display = 'none';
        spanTotal.innerText = totalBase.toFixed(2).replace('.', ',');
        inputTotal.value = totalBase;
      } else {
        enderecoFields.style.display = 'block';
        const novoTotal = totalBase + 7;
        spanTotal.innerText = novoTotal.toFixed(2).replace('.', ',');
        inputTotal.value = novoTotal;
      }
    });

    // já inicia com endereço visível
    enderecoFields.style.display = 'block';
  </script>

</body>

</html>