<?php
include('config/constants.php');

if (!isset($_GET['food_id'])) {
  header('location: index.php');
  exit;
}

$food_id = $_GET['food_id'];

$sql = "SELECT * FROM tbl_food WHERE id=$food_id";
$res = mysqli_query($conn, $sql);
if (mysqli_num_rows($res) == 1) {
  $row = mysqli_fetch_assoc($res);
  $title = $row['title'];
  $price = $row['price'];
  $description = $row['description'];
  $image_name = $row['image_name'];
} else {
  header('location: index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title><?php echo $title; ?> | BK Lounge</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background-color: #111;
      font-family: 'Poppins', sans-serif;
      color: #fff;
      margin: 0;
      padding: 20px;
    }

    .order-container {
      max-width: 600px;
      margin: auto;
      background: #222;
      padding: 20px;
      border-radius: 15px;
      text-align: center;
    }

    .order-container img {
      max-width: 100%;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .order-container h2 {
      color: #ffc107;
      margin-bottom: 10px;
    }

    .order-container p {
      margin-bottom: 20px;
      font-size: 1rem;
      line-height: 1.5;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group input {
      padding: 10px;
      width: 80px;
      font-size: 1rem;
      text-align: center;
      border-radius: 10px;
      border: none;
    }

    .btn {
      padding: 12px 20px;
      font-size: 1rem;
      border: none;
      border-radius: 8px;
      margin: 10px;
      cursor: pointer;
      font-weight: bold;
    }

    .btn-primary {
      background: #ffc107;
      color: #000;
    }

    .btn-secondary {
      background: #555;
      color: #fff;
    }
  </style>
</head>

<body>

  <div class="order-container">
    <?php if ($image_name != "") { ?>
      <img src="images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>">
    <?php } ?>
    <h2><?php echo $title; ?></h2>
    <p><?php echo $description; ?></p>
    <p><strong>Preço:</strong> R$ <?php echo number_format($price, 2, ',', '.'); ?></p>

    <div class="form-group">
      <label for="qty">Quantidade:</label><br>
      <input type="number" id="qty" value="1" min="1">
    </div>

    <button class="btn btn-primary" onclick="adicionarAoCarrinho()">Adicionar ao Carrinho</button>
    <button class="btn btn-secondary" onclick="window.location.href='index.php'">Cancelar</button>
  </div>

  <script>
    function adicionarAoCarrinho() {
      const quantity = parseInt(document.getElementById('qty').value);
      const product = {
        id: <?php echo $food_id; ?>,
        title: "<?php echo addslashes($title); ?>",
        price: <?php echo $price; ?>,
        quantity
      };

      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      const existingIndex = cart.findIndex(item => item.id === product.id);

      if (existingIndex !== -1) {
        cart[existingIndex].quantity += quantity;
      } else {
        cart.push(product);
      }

      localStorage.setItem('cart', JSON.stringify(cart));
      window.location.href = "index.php";
    }
  </script>

</body>

</html>