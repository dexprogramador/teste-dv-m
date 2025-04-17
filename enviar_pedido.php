<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verifica se há itens no carrinho
  if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    echo "Carrinho vazio. Por favor, adicione itens antes de finalizar o pedido.";
    exit;
  }

  // Dados do formulário
  $nome = $_POST['nome'];
  $whatsapp = $_POST['whatsapp'];
  $tipo = $_POST['tipo_pedido'];
  $pagamento = $_POST['pagamento'];
  $total = number_format($_POST['total'], 2, ',', '.');

  // Endereço (se for delivery)
  $endereco = '';
  if ($tipo === 'delivery') {
    $bairro = $_POST['bairro'];
    $rua = $_POST['endereco'];
    $numero = $_POST['numero'];
    $referencia = $_POST['referencia'];
    $endereco = "📍 *Endereço:*\n$rua, Nº $numero\nBairro: $bairro\nReferência: $referencia\n\n";
  } else {
    $endereco = "🏠 *Retirada na Loja:*\nR. Natal, 127 - Centro, Campo Novo do Parecis - MT\n📍 [Abrir no Maps](https://maps.app.goo.gl/aPYdXTcfAgZFjAuW9)\n\n";
  }

  // Monta a mensagem do pedido
  $mensagem = "🍃 *Novo Pedido na BK Lounge!*\n\n";
  $mensagem .= "👤 *Nome:* $nome\n";
  $mensagem .= "📱 *WhatsApp:* $whatsapp\n";
  $mensagem .= "📦 *Tipo:* " . ucfirst($tipo) . "\n";
  $mensagem .= $endereco;
  $mensagem .= "💳 *Pagamento:* $pagamento\n\n";
  $mensagem .= "🛒 *Itens do Pedido:*\n";

  foreach ($_SESSION['cart'] as $item) {
    $nomeItem = $item['title'];
    $qtd = $item['quantity'];
    $preco = number_format($item['price'], 2, ',', '.');
    $mensagem .= "• $qtd x $nomeItem - R$ $preco\n";
  }

  $mensagem .= "\n💰 *Total:* R$ $total";

  // Número da loja
  $numeroLoja = '5565981431429';

  // Gera o link do WhatsApp com a mensagem
  $link = 'https://wa.me/' . $numeroLoja . '?text=' . urlencode($mensagem);

  // Redireciona
  header("Location: $link");
  exit;
} else {
  echo "Acesso inválido.";
}
