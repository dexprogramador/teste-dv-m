<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Finalizar Pedido - BK Lounge</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background-color: #111;
      font-family: 'Poppins', sans-serif;
      color: #fff;
    }

    .checkout-container {
      max-width: 600px;
      margin: 30px auto;
      background: #222;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
    }

    .checkout-container h2 {
      text-align: center;
      color: #ffc107;
      margin-bottom: 20px;
    }

    .product-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="tel"] {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: none;
    }

    .radio-inline-group {
      display: flex;
      gap: 20px;
      margin-top: 10px;
    }

    .radio-inline-group label {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .checkout-summary {
      font-weight: bold;
      margin: 20px 0;
      text-align: right;
      color: #ffc107;
    }

    .btn {
      background: #ffc107;
      color: #000;
      padding: 12px;
      width: 100%;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      margin-top: 15px;
    }

    .btn:hover {
      background-color: #ffda33;
    }

    .btn-secondary {
      margin-top: 10px;
      background-color: #555;
      color: #fff;
    }

    .confirmation-box {
      display: none;
      background: #000;
      padding: 20px;
      border-radius: 10px;
      margin-top: 20px;
      text-align: center;
    }

    .confirmation-box h3 {
      color: #0f0;
    }

    .whatsapp-button {
      background: green;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      margin-top: 15px;
      cursor: pointer;
    }

    .remove-btn {
      background: red;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 4px 8px;
      cursor: pointer;
      font-size: 0.8rem;
      margin-left: 10px;
    }
  </style>
</head>

<body>
  <div class="checkout-container">
    <button class="btn btn-secondary" onclick="window.location.href='index.php'">Adicionar Mais Itens</button>
    <h2>Finalizar Pedido</h2>
    <div id="product-list"></div>
    <div class="checkout-summary">Total: R$ <span id="total">0,00</span></div>

    <div class="form-group">
      <label for="nome">Nome Completo (Obrigatório)</label>
      <input type="text" id="nome" required>
    </div>
    <div class="form-group">
      <label for="whatsapp">Telefone / WhatsApp (Obrigatório)</label>
      <input type="tel" id="whatsapp" required>
    </div>

    <div class="form-group">
      <label>Tipo do Pedido</label>
      <div class="radio-inline-group">
        <label><input type="radio" name="tipo-pedido" value="Delivery" checked> Delivery</label>
        <label><input type="radio" name="tipo-pedido" value="Retirada"> Retirada</label>
      </div>
    </div>

    <div id="campos-endereco">
      <div class="form-group">
        <label for="bairro">Bairro</label>
        <input type="text" id="bairro">
      </div>
      <div class="form-group">
        <label for="endereco">Endereço</label>
        <input type="text" id="endereco">
      </div>
      <div class="form-group">
        <label for="numero">Número</label>
        <input type="number" id="numero">
      </div>
      <div class="form-group">
        <label for="referencia">Referência (opcional)</label>
        <input type="text" id="referencia">
      </div>
    </div>

    <div class="form-group" id="info-retirada" style="display:none">
      <p>Você selecionou Retirada, o endereço aparece após finalizar a compra!</p>
    </div>

    <div class="form-group">
      <label>Forma de Pagamento</label>
      <div class="radio-inline-group">
        <label><input type="radio" name="pagamento" value="Dinheiro"> Dinheiro</label>
        <label><input type="radio" name="pagamento" value="PIX"> PIX</label>
        <label><input type="radio" name="pagamento" value="Débito"> Cartão Débito</label>
        <label><input type="radio" name="pagamento" value="Crédito"> Cartão Crédito</label>
      </div>
    </div>

    <div class="form-group" id="troco-options" style="display:none">
      <label>Precisa de troco?</label>
      <div class="radio-inline-group">
        <label><input type="radio" name="troco" value="Sim"> Sim</label>
        <label><input type="radio" name="troco" value="Não"> Não</label>
      </div>
      <div id="campo-troco" style="margin-top:10px; display:none;">
        <label>Valor para troco:</label>
        <input type="number" id="valor-troco">
      </div>
    </div>

    <div class="form-group" id="mensagem-pix" style="display:none">
      <p>A chave Pix aparecerá após enviar o pedido!</p>
    </div>

    <button class="btn" onclick="confirmarPedido()">Enviar Pedido</button>
    <button class="btn btn-secondary" onclick="window.location.href='index.php'">Voltar</button>

    <div class="confirmation-box" id="confirmacao">
      <h3>SEU PEDIDO FOI CONFIRMADO!</h3>
      <div id="resumo-pedido"></div>
      <button class="whatsapp-button" onclick="enviarWhatsApp()">ACOMPANHE SEU PEDIDO NO WHATSAPP</button>
    </div>
  </div>

  <script>
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    function renderCarrinho() {
      let total = 0;
      let html = '';

      cart.forEach((item, index) => {
        const subtotal = item.price * item.quantity;
        total += subtotal;
        html += `<div class="product-item">
                    <div>${item.quantity} x ${item.title}</div>
                    <div>R$ ${subtotal.toFixed(2)} <button class='remove-btn' onclick='removerItem(${index})'>Remover</button></div>
                  </div>`;
      });

      document.getElementById('product-list').innerHTML = html;
      document.getElementById('total').innerText = total.toFixed(2).replace('.', ',');
    }

    function removerItem(index) {
      cart.splice(index, 1);
      localStorage.setItem('cart', JSON.stringify(cart));
      renderCarrinho();
    }

    function confirmarPedido() {
      const nome = document.getElementById('nome').value.trim();
      const whatsapp = document.getElementById('whatsapp').value.trim();
      const tipo = document.querySelector('input[name="tipo-pedido"]:checked').value;
      const pagamento = document.querySelector('input[name="pagamento"]:checked');
      const bairro = document.getElementById('bairro').value.trim();
      const endereco = document.getElementById('endereco').value.trim();
      const numero = document.getElementById('numero').value.trim();

      if (!nome || !whatsapp) {
        alert("Preencha nome e WhatsApp.");
        return;
      }
      if (tipo === "Delivery" && (!bairro || !endereco || !numero)) {
        alert("Preencha todos os dados de entrega.");
        return;
      }
      if (!pagamento) {
        alert("Selecione a forma de pagamento.");
        return;
      }

      let trocoMsg = '';
      if (pagamento.value === 'Dinheiro') {
        const opcaoTroco = document.querySelector('input[name="troco"]:checked');
        if (!opcaoTroco) {
          alert("Informe se precisa de troco.");
          return;
        }
        if (opcaoTroco.value === 'Sim') {
          const valor = document.getElementById('valor-troco').value;
          if (!valor) {
            alert("Digite o valor para troco.");
            return;
          }
          trocoMsg = `Precisa de troco: Sim - R$ ${valor}`;
        } else {
          trocoMsg = 'Precisa de troco: Não';
        }
      } else if (pagamento.value === 'PIX') {
        trocoMsg = 'CHAVE PIX: TELEFONE (65)996182692\nNOME: 59.316.766 JULIA FERREIRA LUNA\nBANCO: NUBANK\nAO ENVIAR O PIX MANDE O COMPROVANTE NO WHATSAPP (65)98143-1429';
      }

      let resumo = `<p><strong>Produtos:</strong></p><ul>`;
      let total = 0;
      cart.forEach(item => {
        const subtotal = item.price * item.quantity;
        total += subtotal;
        resumo += `<li>${item.quantity} x ${item.title} - R$ ${subtotal.toFixed(2)}</li>`;
      });

      resumo += `</ul><p><strong>Total:</strong> R$ ${total.toFixed(2)}</p>`;
      resumo += `<p><strong>Cliente:</strong> ${nome}</p>`;
      resumo += `<p><strong>WhatsApp:</strong> ${whatsapp}</p>`;
      resumo += `<p><strong>Tipo:</strong> ${tipo}</p>`;
      if (tipo === 'Delivery') {
        resumo += `<p><strong>Endereço:</strong> ${endereco}, ${numero} - ${bairro}</p>`;
        const ref = document.getElementById('referencia').value.trim();
        if (ref) resumo += `<p><strong>Referência:</strong> ${ref}</p>`;
      } else {
        resumo += `<p><strong>Retirada:</strong> R. Natal, 127 - Centro - Campo Novo do Parecis - MT</p>`;
      }
      resumo += `<p><strong>Pagamento:</strong> ${pagamento.value}</p>`;
      resumo += `<p>${trocoMsg.replace(/\n/g, '<br>')}</p>`;

      document.getElementById('resumo-pedido').innerHTML = resumo;
      document.getElementById('confirmacao').style.display = 'block';
    }

    function enviarWhatsApp() {
      const texto = document.getElementById('resumo-pedido').innerText;
      const link = `https://wa.me/5565981431429?text=${encodeURIComponent(texto)}`;
      window.location.href = link;
    }

    document.querySelectorAll('input[name="pagamento"]').forEach(el => {
      el.addEventListener('change', () => {
        const val = el.value;
        document.getElementById('troco-options').style.display = val === 'Dinheiro' ? 'block' : 'none';
        document.getElementById('mensagem-pix').style.display = val === 'PIX' ? 'block' : 'none';
      });
    });

    document.querySelectorAll('input[name="troco"]').forEach(el => {
      el.addEventListener('change', () => {
        document.getElementById('campo-troco').style.display = el.value === 'Sim' ? 'block' : 'none';
      });
    });

    document.querySelectorAll('input[name="tipo-pedido"]').forEach(el => {
      el.addEventListener('change', () => {
        const val = el.value;
        const campos = document.getElementById('campos-endereco');
        const msg = document.getElementById('info-retirada');
        if (val === 'Delivery') {
          campos.style.display = 'block';
          msg.style.display = 'none';
        } else {
          campos.style.display = 'none';
          msg.style.display = 'block';
        }
      });
    });

    renderCarrinho();
    document.querySelector('input[name="tipo-pedido"][value="Delivery"]').click();
  </script>
</body>

</html>