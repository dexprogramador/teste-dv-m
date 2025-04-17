<?php
session_start();
include('config/constants.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seu Carrinho - BK Tabacaria</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body style="background: url('images/bg-grafite.jpg') no-repeat center center; background-size: cover; color: white; font-family: 'Poppins', sans-serif;">
  <div class="container" style="margin-top: 100px; max-width: 800px; background-color: rgba(0,0,0,0.75); padding: 30px; border-radius: 15px;">
    <h2 class="text-center" style="margin-bottom: 20px;">🛒 Seu Carrinho</h2>

    <div id="cart-items"></div>
    <h3 id="total-price" style="text-align: right; margin-top: 20px;">Total: R$ 0,00</h3>

    <div style="margin-top: 30px; text-align: center;">
      <a href="index.php" class="btn btn-yellow" style="margin-right: 10px;">➕ Adicionar mais itens</a>
      <a href="checkout.php" class="btn btn-yellow">✅ Finalizar Compra</a>
    </div>
  </div>

  <script>
    async function loadCart() {
      const cart = JSON.parse(localStorage.getItem('bk_cart')) || [];
      const container = document.getElementById('cart-items');
      const totalPriceEl = document.getElementById('total-price');

      if (cart.length === 0) {
        container.innerHTML = '<p style="text-align:center;">Seu carrinho está vazio.</p>';
        totalPriceEl.innerText = 'Total: R$ 0,00';
        return;
      }

      const response = await fetch('get_products.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          ids: cart.map(item => item.id)
        })
      });

      const products = await response.json();
      let total = 0;
      let html = '';

      cart.forEach(item => {
        const product = products.find(p => p.id == item.id);
        if (product) {
          const subtotal = item.qty * parseFloat(product.price);
          total += subtotal;
          html += `
            <div style="margin-bottom: 15px; border-bottom: 1px solid #444; padding-bottom: 10px;">
              <strong>${product.title}</strong><br>
              Quantidade: ${item.qty}<br>
              Preço unitário: R$ ${parseFloat(product.price).toFixed(2).replace('.', ',')}<br>
              Subtotal: R$ ${subtotal.toFixed(2).replace('.', ',')}
            </div>
          `;
        }
      });

      container.innerHTML = html;
      totalPriceEl.innerText = 'Total: R$ ' + total.toFixed(2).replace('.', ',');
    }

    loadCart();
  </script>
</body>

</html>